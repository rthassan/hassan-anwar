<?php


require_once 'config.php';
require_once 'client.php';
require_once 'GetSalesforce.php';
require_once 'refreshtoken.php';

require_once 'GoogleSyncHelp.php';
require_once 'lib/GoogleOauthHandler.php';
require_once 'googleApi/src/Google_Client.php';

class SyncChangeToGoogle
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


    public function syncChangeGoogle($userId)
    {
    	$users= $this->getSalesforce->getUser($this->instance_url, $this->access_token, $userId);
    
 		//SYNC TO GOOGLE 
        $events=array();
        foreach ((array) $users['records'] as $user) {
            
            $getEventsQuery = "SELECT Id, GSyncRt__Event_Id__c from Event where isDeleted=false AND GSyncRt__stog__c=true AND OwnerId ='" . $user['Name'] . "'";

            $url = "$this->instance_url/services/data/v29.0/queryAll?q=" . urlencode($getEventsQuery);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: OAuth $this->access_token"));
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            $json_response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($json_response, true);
            
    
            foreach ((array) $response['records'] as $event)
            {
                $eventDetail=array();
            
                $eventDetail['access_token']=$user['GSyncRt__Oauth_Token__c'];
                $eventDetail['refresh_token']=$user['GSyncRt__Refresh_Token__c'];
                $eventDetail['token_type']=$user['GSyncRt__Token_Type__c'];
                $eventDetail['expires_in']=$user['GSyncRt__Expires_In__c'];
                $eventDetail['EventId']=$event['Id'];
                $eventDetail['GoogleId']=$event['GSyncRt__Event_Id__c'];
                
                array_push($events, $eventDetail);
                
            }

        }


        $result=deleteEventsFromGoogle($events);

        //For making Google Event Id null for next email sync
        foreach ($events as $event)
        {
            $this->updateEvent($event['EventId']);
        }

    }


    public function syncChangeSalesforce($userId)
    {
    	$users= $this->getSalesforce->getUser($this->instance_url, $this->access_token, $userId);
    
 		//SYNC TO GOOGLE 
        $events=array();
        foreach ((array) $users['records'] as $user) {
            
            $getEventsQuery = "SELECT Id, GSyncRt__Event_Id__c from Event where isDeleted=false AND GSyncRt__gtos__c=true AND OwnerId ='" . $user['Name'] . "'";

            $url = "$this->instance_url/services/data/v29.0/queryAll?q=" . urlencode($getEventsQuery);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: OAuth $this->access_token"));
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            $json_response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($json_response, true);

			foreach ((array) $response['records'] as $event ) //For making Google Event Id null for next email sync
            {
                $this->updateEvent($event['Id']);
            }
		  
            foreach ((array) $response['records'] as $event)
            {
                $this->deleteEventFromSalesforce($event['Id']);
            }

        }

    }

    function updateEvent($eventId) {
        $url = "$this->instance_url/services/data/v20.0/sobjects/Event/$eventId";

        $content = json_encode(array("GSyncRt__Event_Id__c" => '', "GSyncRt__stog__c"=>false, "GSyncRt__gtos__c"=>false));
       
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Authorization: OAuth $this->access_token",
                    "Content-type: application/json"));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 204 ) {
            die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        echo "HTTP status $status updating event<br/><br/>";

        curl_close($curl);
    }
	

    function deleteEventFromSalesforce($id) {
        $url = "$this->instance_url/services/data/v20.0/sobjects/Event/$id";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Authorization: OAuth $this->access_token"));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);

        curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 204 ) {
            die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        echo "HTTP status $status deleting event<br/><br/>";

        curl_close($curl);
    }

    function deleteContactsFromGoogle($userid) {
       
        $query = "SELECT Name, Id, GSyncRt__LastSync__c, GSyncRt__Oauth_Token__c, GSyncRt__Expires_In__c, GSyncRt__UserEmail__c, GSyncRt__OldEmail__c,
                        GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c FROM GSyncRt__GSync_User__c 
                        WHERE Name = '" . $userid . "'";
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
        // echo "$total_size record(s) returned<br/><br/>";

        //get all contacts of this user where syncedfromsf = true

        $query1 = "SELECT Id,FirstName,LastName,Email,GSyncRt__gcontactid__c
                              FROM Contact WHERE OwnerId = '" . $userid . "' AND GSyncRt__SyncDirection__c = 'From Sf' 
                              And GSyncRt__gcontactid__c != ''";

        $getURL1 = $this->instance_url . "/services/data/v29.0/query?q=" . urlencode($query1); 

        $headerOpts = array('Authorization: Bearer ' . $this->access_token);
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $getURL1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headerOpts);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSLVERSION, 6);
        $result1 = curl_exec($ch1);
        curl_close($ch1);

        $typeString = gettype($result1);
        $response1 = json_decode($result1, true);

        print_r($response1);

        $total_size = $response1['totalSize'];
        $optionn = 'del';
        //update the gcontactids of these contacts
        

        $gcontactid = init_sync_sfg($response['records'][0], $response1, $this->instance_url, $this->access_token, $optionn);

        foreach ((array) $response1['records'] as $record1) {
            $id = $record1['Id']; 
            $content = json_encode(array("GSyncRt__gcontactid__c" => "", "GSyncRt__SyncDirection__c" => "", "GSyncRt__Do_not_Sync__c" => false));
            $url = $this->instance_url . "/services/data/v20.0/sobjects/Contact/$id";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: Bearer " . $this->access_token,
                        "Content-type: application/json"));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_exec($curl); 
            curl_close($curl);
        }
    }



    function deleteContactsFromSf($userid) {

        $query = "SELECT Name, Id, GSyncRt__LastSync__c, GSyncRt__Oauth_Token__c, GSyncRt__Expires_In__c, GSyncRt__UserEmail__c, 
                        GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c FROM GSyncRt__GSync_User__c 
                        WHERE Name = '" . $userid . "'";
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
        // echo "$total_size record(s) returned<br/><br/>";

        //get all contacts of this user where syncedfromsf = true
        $query1 = "SELECT Id,FirstName,LastName,Email,GSyncRt__gcontactid__c
                              FROM Contact WHERE OwnerId = '" . $userid . "' AND GSyncRt__SyncDirection__c = 'From Google' 
                              And GSyncRt__gcontactid__c != ''";

        $getURL1 = $this->instance_url . "/services/data/v29.0/query?q=" . urlencode($query1); 

        $headerOpts = array('Authorization: Bearer ' . $this->access_token);
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $getURL1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headerOpts);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSLVERSION, 6);
        $result1 = curl_exec($ch1);
        curl_close($ch1);

        $typeString = gettype($result1);
        $response1 = json_decode($result1, true);
        $total_size = $response1['totalSize'];

        //update the gcontactids of these contacts
        foreach ((array) $response1['records'] as $record1) {
            $id = $record1['Id']; 
            $content = json_encode(array("GSyncRt__gcontactid__c" => "", "GSyncRt__SyncDirection__c" => "", "GSyncRt__Do_not_Sync__c" => false));
            $url = $this->instance_url . "/services/data/v20.0/sobjects/Contact/$id";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: Bearer " . $this->access_token,
                        "Content-type: application/json"));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_exec($curl); 
            curl_close($curl);


            $url1 = $this->instance_url . "/services/data/v20.0/sobjects/Contact/$id";
            $curl1 = curl_init($url1);
            curl_setopt($curl1, CURLOPT_HEADER, false);
            curl_setopt($curl1, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->access_token));
            curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl1, CURLOPT_SSLVERSION, 6);
            curl_exec($curl1); 
            curl_close($curl1);
        }
    }


}


$data = file_get_contents("php://input");
$parsedData = json_decode($data);
$orgId=$parsedData->orgId;
$userId=$parsedData->userId;

print_r($orgId);
print_r($userId);

$dbstatus = include "dbHandler.php";
	if($dbstatus == "ERROR! Connection could not be made." || $dbstatus == "ERROR! Database could not be opened."){
			die("Database Error!");
	}

$result=getUserCredentials($orgId);
$cr = mysqli_fetch_assoc($result);
$instance_url = $cr['instanceurl'];
$refresh_token = $cr['refreshtoken'];




if ( (!isset($access_token) || $access_token == "") && $userId=="" ) {
    die("Error - access/userId token missing from session!");
}

$access_token=refreshToken($refresh_token); 

if($access_token!=null)
 {
 	$obj = new SyncChangeToGoogle($instance_url,$access_token);
 	$obj->syncChangeGoogle($userId);
 	$obj->syncChangeSalesforce($userId);
    $obj->deleteContactsFromGoogle($userId);
    $obj->deleteContactsFromSf($userId);
 }



?>
