<?php
require_once 'client.php';

session_start();

function getSyncUsers($instance_url, $access_token)
{
    $query = "SELECT Name from GSync_User__c";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));

    $json_response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($json_response, true);

    $total_size = $response['totalSize'];

    $count=0;
    $usersId="(";
    foreach ((array) $response['records'] as $record) {
        $count++;
        $usersId=$usersId . "'" . $record['Name'] . "'";
        if($count!=$total_size)
        {
            $usersId=$usersId . ",";
        }
    }
    $usersId=$usersId . ")";
    
    return $usersId;
}

function getAllUsers($instance_url, $access_token)
{
    $query = "SELECT Name, Oauth_Token__c, Refresh_Token__c, Token_Type__c, Expires_In__c, Timezone__c FROM GSync_User__c";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    $json_response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($json_response, true);
    
    return $response;

}

function maskEventId($eventId=array())
{
    $total_size = sizeof($eventId);
    $count=0;
    $maskId="(";
    foreach ($eventId as $e) {
        $count++;
        $maskId=$maskId . "'" . $e . "'";
        if($count!=$total_size)
        {
            $maskId=$maskId . ",";
        }
    }
    $maskId=$maskId . ")";
    
    return $maskId;
}

function getEventsFromSalesforce($instance_url, $access_token, $eventId)
{

    $query = "SELECT Id, Subject, Description, Location, StartDateTime, EndDateTime, Last_Sync_Date__c, Event_Id__c from Event where Event_Id__c IN ". maskEventId($eventId);
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    $json_response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($json_response, true);
    
    return $response;

}



function syncEventsToGoogle($instance_url, $access_token) {
    
    $usersId=getSyncUsers($instance_url, $access_token);

    //Now getting the events related to users
    $getEventsQuery = 'SELECT Id, Event_Id__c, OwnerId, isDeleted, isNew__c, isSync__c, Subject, Description, Location, StartDateTime, EndDateTime from Event where ((isNew__c=TRUE AND Event_Id__c=null) OR (isNew__c=FALSE AND isSync__c=FALSE) OR (isDeleted=true AND Event_Id__c <> null) ) AND OwnerId IN ' . $usersId ;

    $url = "$instance_url/services/data/v29.0/queryAll?q=" . urlencode($getEventsQuery);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    $json_response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($json_response, true);
    $total_size = $response['totalSize'];

    //SYNC TO GOOGLE 
    $allUsers=getAllUsers($instance_url, $access_token);
    $timezone='';
    $events=array();
    echo "$total_size record(s) returned<br/><br/>";
    foreach ((array) $response['records'] as $event) {
        
        $accesstoken='';
        $refreshtoken='';
        $tokentype='';
        $expiresin='';

        foreach ((array) $allUsers['records'] as $user)
        {
            if($user['Name']==$event['OwnerId'])
            {
                $accesstoken=$user['Oauth_Token__c'];
                $refreshtoken=$user['Refresh_Token__c'];
                $tokentype=$user['Token_Type__c'];
                $expiresin=$user['Expires_In__c'];
                $timezone=$user['Timezone__c'];
            }
        }

        $eventDetail=array();
        //Distinguishing for new, update and deleted records
        $eventDetail['access_token']=$accesstoken;
        $eventDetail['refresh_token']=$refreshtoken;
        $eventDetail['token_type']=$tokentype;
        $eventDetail['expires_in']=$expiresin;
        $eventDetail['EventId']=$event['Id'];
        $eventDetail['EventSubject']=$event['Subject'];;
        $eventDetail['EventDescription']=$event['Description'];
        $eventDetail['EventLocation']=$event['Location'];
        $eventDetail['EventStart']=$event['StartDateTime'];
        $eventDetail['EventEnd']=$event['EndDateTime'];
        $eventDetail['TimeZone']=$timezone;

        
        //New Records
        if ($event['isNew__c']==true && $event['Event_Id__c']==null && $event['IsDeleted']==null )
        {
            $eventDetail['Status']='new'; 
        }
        else if($event['isNew__c']==null && $event['isSync__c']==null && $event['IsDeleted']==null)
        {
            $eventDetail['Status']='update';
            $eventDetail['GoogleId']=$event['Event_Id__c'];
        }
        else if($event['IsDeleted']==true && $event['Event_Id__c']!=null)
        {
            $eventDetail['Status']='delete';
            $eventDetail['GoogleId']=$event['Event_Id__c'];
        }

        array_push($events, $eventDetail);
    
    }

    $result=upsertEvent($events);
    date_default_timezone_set($timezone); 
    foreach((array) $response['records'] as $event)
    {
        
        if($result[$event['Id']]!=null && $event['IsDeleted']==null)
        { 
            updateEventForStog($instance_url, $access_token, $event['Id'], $result[$event['Id']]);
        }
        else if($result[$event['Id']]==null && $event['IsDeleted']==null)
        {
            $datetime = new DateTime();
            updateEventForStog($instance_url, $access_token, $event['Id'], $datetime->format(DateTime::ATOM), null);
        }
           
    }

    echo "<br/>";
        
}

function syncEventsFromGoogle($instance_url, $access_token) {

    $usersId=getAllUsers($instance_url, $access_token);
    foreach ((array) $usersId['records'] as $user)
    {
        $deleteEventsId=array();
        $eventsToUpsert=array();
        $upsertEventsId=array();

        $eventDetail=array();
        $eventDetail['access_token']=$user['Oauth_Token__c'];
        $eventDetail['refresh_token']=$user['Refresh_Token__c'];
        $eventDetail['token_type']=$user['Token_Type__c'];
        $eventDetail['expires_in']=$user['Expires_In__c'];

        date_default_timezone_set($user['Timezone__c']); 

        $result=getEvents($eventDetail);

        foreach($result['items'] as $event)
        {
             if($event['status']=='cancelled')
             {
                 array_push($deleteEventsId, $event['id']);
             }
             else if($event['status']=='confirmed')
             {
                 $eu=array();
                 $eu['Subject']=$event['summary'];
                 $eu['Description']=$event['description'];
                 $eu['Location']=$event['location'];
                 $eu['StartDateTime']=$event['start']['dateTime'];
                 $eu['EndDateTime']=$event['end']['dateTime'];
                 $eu['Event_Id__c']=$event['id'];
                 $eu['OwnerId']=$user['Name'];

                 array_push($eventsToUpsert, $eu);
                 array_push($upsertEventsId, $event['id']);

            }
        }

        $updateEvents=getEventsFromSalesforce($instance_url, $access_token, $upsertEventsId);

        //Upserting Events
        foreach($eventsToUpsert as $eventToUpsert)
        {
            $isInsert=true;
             
            foreach($updateEvents['records'] as $ue)
            {
                if($eventToUpsert['Event_Id__c']==$ue['Event_Id__c'])
                {
                    $isInsert=false;
                    updateEventForGtos($instance_url, $access_token, $ue['Id'], $eventToUpsert['Subject'], $eventToUpsert['Description'], $eventToUpsert['Location'], $eventToUpsert['StartDateTime'], $eventToUpsert['EndDateTime'] );
                   
                }
            }
                    
            if($isInsert)
            {
                insertEvent($instance_url, $access_token, $eventToUpsert);
            }
        }

        //Deleting the events
        $deleteEvents=getEventsFromSalesforce($instance_url, $access_token, $deleteEventsId);
        foreach($deleteEvents['records'] as $deleteEvent)
        {

            deleteEvent($instance_url, $access_token, $deleteEvent['Id']);
        }

    }
}

function insertEvent($instance_url, $access_token,  $event) {
    $url = "$instance_url/services/data/v20.0/sobjects/Event/";
    $datetime = new DateTime();
    $content = json_encode(array("Subject" => $event['Subject'], "Description" => $event['Description'], "Location" => $event['Location'], "StartDateTime" => $event['StartDateTime'], "EndDateTime" => $event['EndDateTime'], "OwnerId" => $event['OwnerId'], "Event_Id__c"=>$event['Event_Id__c'], "Last_Sync_Date__c" => $datetime->format(DateTime::ATOM) ));

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    
    echo "HTTP status $status creating account<br/><br/>";

    curl_close($curl);

    $response = json_decode($json_response, true);

    $id = $response["id"];

    echo "New record id $id<br/><br/>";

    return $id;
}

function deleteEvent($instance_url, $access_token, $id) {
    $url = "$instance_url/services/data/v20.0/sobjects/Event/$id";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

    curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status deleting account<br/><br/>";

    curl_close($curl);
}


function updateEventForGtos($instance_url, $access_token, $eventId, $subject, $description, $location, $StartDateTime, $EndDateTime) {
    $url = "$instance_url/services/data/v20.0/sobjects/Event/$eventId";

    $datetime = new DateTime();
    $content = json_encode(array("Subject" => $subject, "Description" => $description, "Location"=>$location, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Last_Sync_Date__c"=>$datetime->format(DateTime::ATOM) ));
   
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status updating event<br/><br/>";

    curl_close($curl);
}


function updateEventForStog($instance_url, $access_token, $eventId, $googleId) {
    $url = "$instance_url/services/data/v20.0/sobjects/Event/$eventId";

    $datetime = new DateTime();
    if($googleId!=null)
    {
        $content = json_encode(array("Event_Id__c" => $googleId, "Last_Sync_Date__c" => $datetime->format(DateTime::ATOM) ));
    }
    else
    {
        $content = json_encode(array("Last_Sync_Date__c" => $lastSyncDate));
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }

    echo "HTTP status $status updating event<br/><br/>";

    curl_close($curl);
}

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>REST/OAuth Example</title>
    </head>
    <body>
        <tt>
            <?php
            $access_token = $_SESSION['access_token'];
            $instance_url = $_SESSION['instance_url'];

            if (!isset($access_token) || $access_token == "") {
                die("Error - access token missing from session!");
            }

            syncEventsToGoogle($instance_url, $access_token);

            //syncEventsFromGoogle($instance_url, $access_token);
            
            /*if (!isset($instance_url) || $instance_url == "") {
                die("Error - instance URL missing from session!");
            }

            show_accounts($instance_url, $access_token);

            $id = create_account("My New Org", $instance_url, $access_token);

            show_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);

            update_account($id, "My New Org, Inc", "San Francisco",
                    $instance_url, $access_token);

            show_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);

            delete_account($id, $instance_url, $access_token);

            show_accounts($instance_url, $access_token);*/
            ?>
        </tt>
    </body>
</html>
