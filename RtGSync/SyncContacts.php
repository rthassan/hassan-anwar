<?php
//ini_set('display errors',1);
require_once 'GoogleSyncHelp.php';
require_once 'lib/GoogleOauthHandler.php';
require_once 'googleApi/src/Google_Client.php';

session_start();

class SyncContacts
{
	public $access_token;
    public $instance_url;

    public function __construct($instance_url, $access_token)
    {
        $this->access_token = $access_token;
        $this->instance_url = $instance_url;
    }

    function syncGsf() {
   		
        // Set our GET request URL
        $query = "SELECT Name, Id, GSyncRt__LastSyncGsf__c, GSyncRt__Oauth_Token__c, GSyncRt__Expires_In__c, GSyncRt__UserEmail__c, 
                        GSyncRt__Refresh_Token__c, GSyncRt__syncStatus__c, GSyncRt__Token_Type__c, GSyncRt__DuplicationPref__c FROM GSyncRt__GSync_User__c 
                        WHERE GSyncRt__syncStatus__c='Google to Salesforce' OR GSyncRt__syncStatus__c='Bidirectional'";
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
        // echo "<br>response<br>";
        // print_r($response);
        // echo "<br>responseresponse<br>";

        $idsarr = array();
        foreach ((array) $response['records'] as $record) {
            // echo $record['GSyncRt__LastSyncGsf__c'] . ", " . $record['GSyncRt__UserEmail__c'] . "<br/>";
            
            $gcontactid = init_sync_gsf($record);
            $idsarr = array_merge($idsarr, $gcontactid);
        }
        $gcont_ids="(";
        foreach($idsarr as $cont) {
            $gcont_ids = $gcont_ids . "'" . $cont['GSyncRt__gcontactid__c'] . "',";
        }


        $gcont_ids = substr($gcont_ids, 0, -1) . ")";
        // print_r($gcont_ids);

        $query1 = "SELECT FirstName,LastName,Email,Id,GSyncRt__gcontactid__c FROM Contact WHERE GSyncRt__gcontactid__c in " . $gcont_ids;
        $getURL1 = $this->instance_url . "/services/data/v20.0/query?q=" . urlencode($query1);

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $getURL1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headerOpts);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSLVERSION, 6);
        $result1 = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($result1, true);
        $insertionarr = array();
        $emailarr = array();
        foreach ($idsarr as $contfromgoogle) {            
            $found = false;
            foreach((array) $response1['records'] as $contfromsf) {
                if ($contfromgoogle['GSyncRt__gcontactid__c'] == $contfromsf['GSyncRt__gcontactid__c']) {

                    $found = true;
                    if ($contfromgoogle['IsDeleted'] == 'false') {
                        //update it
                        $id = $contfromsf['Id'];
                        $contentfromgoogle = $contfromgoogle;
                        unset($contentfromgoogle['IsDeleted']);
                        unset($contentfromgoogle['CurrentUserEmail']);
                        unset($contentfromgoogle['GSyncRt__DuplicationPref__c']);
                        unset($contentfromgoogle['syncStatus']);
                        $content = json_encode($contentfromgoogle);
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

                    } else if ($contfromgoogle['IsDeleted'] == 'true') {
                        //delete it
                        $id = $contfromsf['Id'];
                        $url = $this->instance_url . "/services/data/v20.0/sobjects/Contact/$id";
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->access_token));
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
                        curl_exec($curl); 
                        curl_close($curl);
                    }
                    break;
                }
            }
         
			if ($found == false && $contfromgoogle['IsDeleted'] == 'false') {
               //insert it
               //handle contacts without email
               if (isset($contfromgoogle['Email'])) {
                   array_push($insertionarr, $contfromgoogle);
                   array_push($emailarr, $contfromgoogle['Email']);
               } else {
                   //insert it right away:
                   $url = $this->instance_url . "/services/data/v20.0/sobjects/Contact/";
                   $contentfromgoogle = $contfromgoogle;
                   unset($contentfromgoogle['IsDeleted']);
                   unset($contentfromgoogle['GSyncRt__DuplicationPref__c']);
                   unset($contentfromgoogle['CurrentUserEmail']);
                   unset($contentfromgoogle['syncStatus']);
                   $contentfromgoogle['GSyncRt__SyncDirection__c'] = 'From Google';
                   $content = json_encode($contentfromgoogle);
                   $curl = curl_init($url);
                   curl_setopt($curl, CURLOPT_HEADER, false);
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                   curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->access_token, "Content-type: application/json"));
                   curl_setopt($curl, CURLOPT_POST, true);
                   curl_setopt($curl, CURLOPT_POSTFIELDS, $content);                
                   curl_setopt($curl, CURLOPT_SSLVERSION, 6);
                   $json_response = curl_exec($curl);
                   curl_close($curl);        
               }
           }
            
        }
        $emailidsunique = array_unique($emailarr);
        if (sizeof($emailidsunique > 0)) {
            $emailids="(";
            foreach ($emailidsunique as $emailidd) {
                $emailids = $emailids . "'" . $emailidd . "',";
            }
            $emailids = substr($emailids, 0, -1) . ")";

            
            //get all contacts with this email id
            $query2 = "SELECT Id,FirstName,LastName,Email,GSyncRt__gcontactid__c,Title,OwnerId
                                      FROM Contact WHERE Email in " . $emailids;
            $getURL2 = $this->instance_url . "/services/data/v20.0/query?q=" . urlencode($query2);
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $getURL2);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, $headerOpts);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
            $result2 = curl_exec($ch2);
            curl_close($ch2);
            $typeString2 = gettype($result2);
            $response2 = json_decode($result2, true);

            foreach ($insertionarr as $insertioncont) {

                $foundemail = false;
                foreach ((array) $response2['records'] as $sfconttoupdate) {
                    if ($sfconttoupdate['Email'] == $insertioncont['Email']) {
                        $foundemail = true;
                        if ($sfconttoupdate['GSyncRt__gcontactid__c'] == '') {

                            if ($insertioncont['syncStatus'] == 'Bidirectional') {
                                if ($insertioncont['GSyncRt__DuplicationPref__c'] == 'Salesforce') {
                                    //update GSyncRt__gcontid__c

                                    $id = $sfconttoupdate['Id'];
                                    $gcontidd = $insertioncont['GSyncRt__gcontactid__c'];

                                    $content = json_encode(array("GSyncRt__gcontactid__c" => $gcontidd, "GSyncRt__SyncDirection__c" => "From Sf"));
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

                                } else if ($insertioncont['GSyncRt__DuplicationPref__c'] == 'Google') {
                                    //update all of it
                                    $id = $sfconttoupdate['Id'];
                                    $contentfromgoogle = $insertioncont;
                                    unset($contentfromgoogle['IsDeleted']);
                                    unset($contentfromgoogle['CurrentUserEmail']);
                                    unset($contentfromgoogle['GSyncRt__DuplicationPref__c']);
                                    unset($contentfromgoogle['syncStatus']);
                                    $contentfromgoogle['GSyncRt__SyncDirection__c'] = 'From Sf';
                                    $content = json_encode($contentfromgoogle);
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


                                } else if ($insertioncont['GSyncRt__DuplicationPref__c'] == 'Do not Sync') {
                                    //update it to have do not sync true
                                    $id = $sfconttoupdate['Id'];

                                    $content = json_encode(array("GSyncRt__Do_not_Sync__c" => true));
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
                            } else if ($insertioncont['syncStatus'] == 'Google to Salesforce') {
                                if ($insertioncont['GSyncRt__DuplicationPref__c'] == 'Google') {
                                    //update all of it
                                    $id = $sfconttoupdate['Id'];
                                    $contentfromgoogle = $insertioncont;
                                    unset($contentfromgoogle['IsDeleted']);
                                    unset($contentfromgoogle['CurrentUserEmail']);
                                    unset($contentfromgoogle['GSyncRt__DuplicationPref__c']);
                                    unset($contentfromgoogle['syncStatus']);
                                    $contentfromgoogle['GSyncRt__SyncDirection__c'] = 'From Sf';
                                    $content = json_encode($contentfromgoogle);
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
                                } else {
                                    //update as do not sync
                                    $id = $sfconttoupdate['Id'];

                                    $content = json_encode(array("GSyncRt__Do_not_Sync__c" => true));
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
                        }
                        
                        break;
                    }
                }
                if ($foundemail == false) {
                    //insert it
                    //OLD INSERT STARTSS

                    $url = $this->instance_url . "/services/data/v20.0/sobjects/Contact/";
                    $contentfromgoogle = $insertioncont;
                    unset($contentfromgoogle['IsDeleted']);
                    unset($contentfromgoogle['GSyncRt__DuplicationPref__c']);
                    unset($contentfromgoogle['CurrentUserEmail']);
                    unset($contentfromgoogle['syncStatus']);
                    $contentfromgoogle['GSyncRt__SyncDirection__c'] = 'From Google';
                    $content = json_encode($contentfromgoogle);
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->access_token, "Content-type: application/json"));
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);                
                    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
                    $json_response = curl_exec($curl);
                    curl_close($curl);
                    //OLD INSERT ENDS
                }
            }
        }

        foreach ((array) $response['records'] as $record) {
            // echo $record['Id'] . ", " . $record['GSyncRt__LastSyncGsf__c'] . ", " . $record['GSyncRt__UserEmail__c'] . "<br/>";
            // update the user's lastsyncGsf here
            $id = $record['Id']; 
            $datetime = new DateTime();
            $datetime->modify('-1 minutes');
            $d2 = $datetime->format(DateTime::ATOM);
            $content = json_encode(array("GSyncRt__LastSyncGsf__c" => $d2));
            $url = $this->instance_url . "/services/data/v38.0/sobjects/GSyncRt__GSync_User__c/$id";
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
        return $idsarr;

    }



    function syncSfg() {

        // Set our GET request URL
        $query = "SELECT Name, Id, GSyncRt__LastSync__c, GSyncRt__Oauth_Token__c, GSyncRt__Expires_In__c, GSyncRt__UserEmail__c, 
                        GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c FROM GSyncRt__GSync_User__c 
                        WHERE GSyncRt__syncStatus__c='Salesforce to Google' OR GSyncRt__syncStatus__c='Bidirectional'";

        $getURL = $this->instance_url. "/services/data/v20.0/query?q=" . urlencode($query);

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

        foreach ((array) $response['records'] as $record) {            
            if ($record['GSyncRt__LastSync__c'] == null) {
                $query1 = "SELECT Id,FirstName,LastName,Email,Account.Name,GSyncRt__gcontactid__c,Title,Description,MailingStreet,
                                  MailingCity,MailingState,MailingPostalCode,MailingCountry,OtherStreet,OtherCity,
                                  OtherState,OtherPostalCode,OtherCountry,MobilePhone,Fax,Phone
                                  FROM Contact WHERE OwnerId = '" . $record['Name'] . "' AND GSyncRt__Do_not_Sync__c = false";
                                

                $getURL1 = $this->instance_url. "/services/data/v29.0/query?q=" . urlencode($query1);
            } else {
                $query1 = "SELECT IsDeleted,Id,FirstName,LastName,Email,Account.Name,GSyncRt__gcontactid__c,Title,Description,MailingStreet,
                              MailingCity,MailingState,MailingPostalCode,MailingCountry,OtherStreet,OtherCity,
                              OtherState,OtherPostalCode,OtherCountry,MobilePhone,Fax,Phone
                              FROM Contact WHERE OwnerId = '" . $record['Name'] . "' AND GSyncRt__Do_not_Sync__c = false AND LastModifiedDate > " . $record['GSyncRt__LastSync__c'];

                $getURL1 = $this->instance_url. "/services/data/v29.0/queryAll?q=" . urlencode($query1); 
            }
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
            $gcontactid = init_sync_sfg($record, $response1, $this->instance_url, $this->access_token, 'init');


            // update the user's lastsync here
            $id = $record['Id']; 
            $datetime = new DateTime();
            $datetime->modify('-1 minutes');
            $d2 = $datetime->format(DateTime::ATOM);
            $content = json_encode(array("GSyncRt__LastSync__c" => $d2));
            $url = $this->instance_url. "/services/data/v20.0/sobjects/GSyncRt__GSync_User__c/$id";
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




}



?>