<?php
require_once 'client.php';
require_once 'GetSalesforce.php';

session_start();

class SalesforceToGoogle
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

    function syncEventsToGoogle() {
    
        $users=$this->getSalesforce->getStogUsers($this->instance_url, $this->access_token);
	print_r($users);
        //SYNC TO GOOGLE 
        $events=array();
        foreach ((array) $users['records'] as $user) {

	   
	$getEventsQuery=''; 
	if($user['GSyncRt__LastEventSyncSfg__c']!=null)
	{
		print_r('We are provided with lastSync SFG\n');
		print_r($user['GSyncRt__LastEventSyncSfg__c']);
		$getEventsQuery='SELECT Id, GSyncRt__Event_Id__c, OwnerId, isDeleted, Subject,IsRecurrence,RecurrenceActivityId, Description, Location, IsAllDayEvent,StartDateTime, EndDateTime,
                                (SELECT Status,TYPEOF Relation
                                     WHEN Contact THEN Email, FirstName,LastName,Phone
                                     WHEN Lead THEN Email, FirstName,LastName,Phone
                                     END
                                     FROM EventRelations)
                                from Event where LastModifiedDate >= '. $user['GSyncRt__LastEventSyncSfg__c'] . " AND OwnerId ='" . $user['Name'] . "'";

	}
	else if($user['GSyncRt__SyncEventsFrom__c']!=null)
	{
		print_r('We are provided with SyncEventsFrom SFG');
		$getEventsQuery='SELECT Id, GSyncRt__Event_Id__c, OwnerId, isDeleted, Subject,IsRecurrence, RecurrenceActivityId, Description,IsAllDayEvent, Location, StartDateTime, EndDateTime,
                                (SELECT Status,TYPEOF Relation
                                     WHEN Contact THEN Email, FirstName,LastName,Phone
                                     WHEN Lead THEN Email, FirstName,LastName,Phone
                                     END
                                     FROM EventRelations)
                                from Event where StartDateTime >= '. $user['GSyncRt__SyncEventsFrom__c'] . " AND OwnerId ='" . $user['Name'] . "'";

	}
	else
	{
		print_r('We are provided with default 2016 SFG');
		$getEventsQuery='SELECT Id, GSyncRt__Event_Id__c, OwnerId, isDeleted, Subject, IsRecurrence, RecurrenceActivityId,Description,IsAllDayEvent, Location, StartDateTime, EndDateTime,
                                (SELECT Status,TYPEOF Relation
                                     WHEN Contact THEN Email, FirstName,LastName,Phone
                                     WHEN Lead THEN Email, FirstName,LastName,Phone
                                     END
                                     FROM EventRelations)
                                from Event where StartDateTime >= '. '2016-01-01T00:00:00.000+0000' . " AND OwnerId ='" . $user['Name'] . "'";

	}

            $url = "$this->instance_url/services/data/v29.0/queryAll?q=" . urlencode($getEventsQuery);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Authorization: OAuth $this->access_token"));
            $json_response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($json_response, true);
            print_r($response);
    
            foreach ((array) $response['records'] as $event)
            {
                //EventRelations/records/EventRelation
                $attendees = $event['EventRelations']['records'];
                $attendees_size = $event['EventRelations']['totalSize'];
                $add_attendees = array();
                foreach($attendees as $n_attendees)
                {
                    $attendee_type = $n_attendees['Relation']['attributes']['type'];
                    $attendee_email = $n_attendees['Relation']['Email'];
                    $add_attendees[] = array('email' => $attendee_email,'Status' => $n_attendees['Status']);
                }


                $eventDetail=array();
                if($event['IsRecurrence'] == false && $event['RecurrenceActivityId'] ==null )  //false for single event
                {
                    $eventDetail['access_token']=$user['GSyncRt__Oauth_Token__c'];
                    $eventDetail['refresh_token']=$user['GSyncRt__Refresh_Token__c'];
                    $eventDetail['token_type']=$user['GSyncRt__Token_Type__c'];
                    $eventDetail['expires_in']=$user['GSyncRt__Expires_In__c'];
                    $eventDetail['EventId']=$event['Id'];
                    $eventDetail['EventSubject']=$event['Subject'];
                    $eventDetail['EventDescription']=$event['Description'];
                    $eventDetail['EventLocation']=$event['Location'];
                    $eventDetail['EventStart']=$event['StartDateTime'];
                    $eventDetail['EventEnd']=$event['EndDateTime'];
                    $eventDetail['IsDeleted']=$event['IsDeleted'];
                    $eventDetail['attendees']=$add_attendees;
                    $eventDetail['IsAllDayEvent']=$event['IsAllDayEvent'];

                    //New Records
                    if ( $event['GSyncRt__Event_Id__c']==null && $event['IsDeleted']==null )
                    {
                        $eventDetail['Status']='new';
                    }
                    else if($event['GSyncRt__Event_Id__c']!=null && $event['IsDeleted']==null)
                    {
                        $eventDetail['Status']='update';
                        $eventDetail['GoogleId']=$event['GSyncRt__Event_Id__c'];
                    }
                    else if($event['GSyncRt__Event_Id__c']!=null && $event['IsDeleted']==true )
                    {
                        $eventDetail['Status']='delete';
                        $eventDetail['GoogleId']=$event['GSyncRt__Event_Id__c'];
                    }

                    array_push($events, $eventDetail);
                }

                
            }

        }

        $result=upsertEvent($events);
            
        foreach($events as $event)
        {

            if($result[$event['EventId']]!=null && $event['IsDeleted']==null)
            { 
                $this->updateEventForStog($event['EventId'], $result[$event['EventId']]); //$result[$event['Id']] represents Google Id
            } 
           
        }

        //Updating users last sync
        foreach ((array) $users['records'] as $user) {
             $this->updateUserSync($user['Id']);
        }

        echo "<br/>";
        
    }

    function updateEventForStog($eventId, $googleId) {
        $url = "$this->instance_url/services/data/v20.0/sobjects/Event/$eventId";

        $content = json_encode(array("GSyncRt__Event_Id__c" => $googleId, "GSyncRt__stog__c"=>true));
       
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


    function updateUserSync($userId) {
        $url = "$this->instance_url/services/data/v20.0/sobjects/GSyncRt__GSync_User__c/$userId";

        $datetime = new DateTime();
        $datetime->modify('-1 minutes');
        $content = json_encode(array("GSyncRt__LastEventSyncSfg__c"=>$datetime->format(DateTime::ATOM) ));
       
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

        echo "HTTP status $status updating user<br/><br/>";

        curl_close($curl);
    }



}

?>
