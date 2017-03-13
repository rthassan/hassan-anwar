<?php

require_once 'config.php';
require_once 'SalesforceToGoogle.php';
require_once 'GoogleToSalesforce.php';
require_once 'SyncContacts.php';
require_once 'refreshtoken.php';

require_once 'GoogleSyncHelp.php';
require_once 'lib/GoogleOauthHandler.php';
require_once 'googleApi/src/Google_Client.php';

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');


                $dbstatus = include "dbHandler.php";
                    if($dbstatus == "ERROR! Connection could not be made." || $dbstatus == "ERROR! Database could not be opened."){
                            die("Database Error!");
                    }

                $results=getAllCredentials();

                while ( $row = mysqli_fetch_assoc($results) )
                {
                    $access_token=refreshToken($row['refreshtoken']);
                    $instance_url=$row['instanceurl'];

                    $obj = new SyncContacts($instance_url,$access_token);
                    $obj->syncGsf();
                    $obj->syncSfg();

                    $obj = new GoogleToSalesforce($instance_url,$access_token);
                    $obj->syncEventsFromGoogle();

                    $obj = new SalesforceToGoogle($instance_url,$access_token);
                    $obj->syncEventsToGoogle();

                    
                   
                }


?>
        
