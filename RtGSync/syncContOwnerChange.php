<?php


require_once 'config.php';
require_once 'client.php';
require_once 'GetSalesforce.php';
require_once 'refreshtoken.php';

require_once 'GoogleSyncHelp.php';
require_once 'lib/GoogleOauthHandler.php';
require_once 'googleApi/src/Google_Client.php';

class syncContOwnerChange
{
    public $access_token;
    public $instance_url;
    public $getSalesforce;

    public function __construct($instance_url, $access_token)
    {
        $this->access_token = $access_token;
        $this->instance_url = $instance_url;
        $this->getSalesforce = new GetSalesforce();
    }

    function deleteContactOwnerChanged($contid, $oldownerid)
    {

        $query = "SELECT Name, Id, GSyncRt__LastSync__c, GSyncRt__Oauth_Token__c, GSyncRt__Expires_In__c, GSyncRt__UserEmail__c, 
                        GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c FROM GSyncRt__Gsync_User__c 
                        WHERE Name = '" . $oldownerid . "'";
        $getURL = $this->instance_url . "/services/data/v20.0/query?q=" . urlencode($query);

        $headerOpts = array('Authorization: Bearer ' . $this->access_token);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerOpts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        $result = curl_exec($ch);
        curl_close($ch);

        $typeString = gettype($result);
        $response = json_decode($result, true);
        $total_size = $response['totalSize'];
        $option1 = 'delChangedOwner';


        $gcontactid = init_sync_sfg($response['records'][0], $contid, $this->instance_url, $this->access_token, $option1);

    }

}


    

$data = file_get_contents("php://input");
$parsedData = json_decode($data);
$gcontactid=$parsedData->gcontid;
$oldowner=$parsedData->oldownerid;
$orgId=$parsedData->orgId;


$dbstatus = include "dbHandler.php";
	if($dbstatus == "ERROR! Connection could not be made." || $dbstatus == "ERROR! Database could not be opened."){
			die("Database Error!");
	}

$result=getUserCredentials($orgId);
$cr = mysqli_fetch_assoc($result);
$instance_url = $cr['instanceurl'];
$refresh_token = $cr['refreshtoken'];


if ( (!isset($access_token) || $access_token == "") && $oldowner=="" ) {
    die("Error - access/userId token missing from session!");
}

$access_token=refreshToken($refresh_token); 

if($access_token!=null)
{
    $obj = new syncContOwnerChange($instance_url,$access_token);
    $obj->deleteContactOwnerChanged($gcontactid, $oldowner);
}



?>
