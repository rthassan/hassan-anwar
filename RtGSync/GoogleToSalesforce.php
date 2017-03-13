<?php
require_once 'client.php';
require_once 'GetSalesforce.php';

session_start();

class GoogleToSalesforce
{
    public $access_token;
    public $instance_url;
    public $getSalesforce;

    public $uevents_sf_ids;
    public $uevents_attendees;
    public $count;
    public $total_size;
    public $invitees_status;

    public $final_eventids;
    public $final_invitees;
    public $final_uevents;



    public function __construct($instance_url, $access_token)
    {
        $this->access_token = $access_token;
        $this->instance_url = $instance_url;
        $this->getSalesforce = new GetSalesforce();
        $this->uevents_sf_ids = array();
        $this->uevents_attendees = array();
        $this->invitees_status = array();
        $this->count = 0;
        $this->final_eventids = array();
        $this->final_invitees = array();
        $this->final_uevents = array();
    }


    public function delete_EventRelation($er_id)
    {
        $url = "$this->instance_url/services/data/v29.0/sobjects/EventRelation/$er_id";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $this->access_token"));
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 204 ) {
            // die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        echo "HTTP status $status deleting Event Relation<br/><br/>";

        curl_close($curl);
    }


    public function update_EventRelation($e_relid,$status)
    {
        $url = "$this->instance_url/services/data/v29.0/sobjects/EventRelation/$e_relid";
        if($status == 'needsAction')
        {
            // $status = 'new';
        }
        else if( $status == 'tentative')
        {
            $status = 'accepted';
        }
        $content = json_encode(array("Status" => $status));

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

        echo "HTTP status $status updating Events Relation<br/><br/>";
        curl_close($curl);
    }


    public function CheckEventRelationDuplication($eventid, $invitee_id)//will check  events,Updation and DELETION
    {

        echo '<br><br> Inside Check Event Updation and Deletion:<br>';

        $query = 'SELECT Id,EventId,RelationId FROM EventRelation 
                              where  EventId In ' .  $eventid ;
        //' AND RelationId In ' .  $invitee_id ;


        $url = "$this->instance_url/services/data/v29.0/query?q=" . urlencode($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $this->access_token"));
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        $json_response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($json_response, true);
        $total_size = $response['totalSize'];
        echo "<br><br>Duplicate Event Relation $total_size<br><br>";
        print_r($response);
        if($total_size == 0)
        {
            echo '<br>Empty<br>';
        }
        else
        {
            echo '<br><br>Duplication fUNCTION rESPONSE<br>';
            $EventRelation_obj = (array)$response['records'];
            //print_r($response);
            print_r($EventRelation_obj);
            $flag_del = false;
            foreach($EventRelation_obj as $er_obj)
            {
                foreach($this->final_uevents as $fstatus)
                {
                    if(($er_obj['RelationId'] == $fstatus['relation_id'] AND $er_obj['EventId'] == $fstatus['event_id']))
                    {
                        $this->update_EventRelation($er_obj['Id'],$fstatus['status']);
                        $flag_del = true;
                    }
                }

                if($flag_del == false)
                {
                    echo '<br><br>DELETION<br><br>';
                    $this->delete_EventRelation($er_obj['Id']);
                }
                $flag_del = false;

            }


        }
    }




    public function add_invitees($results,$eventid)//will add OR UPDATE invitees into salesforce through EVENT RELATION
    {
        $dup_emails = array();
        $this->final_eventids[] = $eventid; //extra line added
        foreach($results as $invitees_emails)
        {
            //this line tells the type of $invitee
            $type = $invitees_emails['attributes']['type'];
            //making an object of Event Relation
            $event_relation = array();
            $event_relation['EventId'] = $eventid;
            $event_relation['RelationId'] = $invitees_emails['Id'];
            $invite_id = $invitees_emails['Id'];

            if( ( in_array($invitees_emails['Email'], $dup_emails) == false) and ($type = 'Contact' or $type = 'Lead'))
            {
                $dup_emails[] = $invitees_emails['Email'];

                //inserting Event Relation Object
                $Status_Invitee = $this->invitees_status[$invitees_emails['Email']];
                if($Status_Invitee == 'needsAction')
                {
                    $Status_Invitee = 'new';
                }
                else if( $Status_Invitee == 'tentative')
                {
                    $Status_Invitee = 'accepted';
                }
                $url = "$this->instance_url/services/data/v29.0/sobjects/EventRelation";
                $content = json_encode(array(
                    'EventId' => $eventid,
                    'RelationId' => $invitees_emails['Id'],
                    'Status' => $Status_Invitee
                ));

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: OAuth $this->access_token",
                        "Content-type: application/json"
                    ));
                curl_setopt($curl, CURLOPT_SSLVERSION, 6);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                $json_response = curl_exec($curl);
                $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($status != 201) {       //204 for update and 201 for insert
                    // die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
                }
                $this->final_uevents[] = array('event_id' => $eventid, 'relation_id' =>$invite_id , 'status' => $Status_Invitee);
                if($status == 400)
                {
                    $this->final_eventids[] = $eventid;//will hold updated event ids for updating INVITEES OBJECT(EVENT RELATION)
                    $this->final_invitees[] = $invite_id;
                    $this->final_uevents[] = array('event_id' => $eventid, 'relation_id' =>$invite_id , 'status' => $Status_Invitee);
                }

                echo "HTTP status $status creating Event Relation<br/><br/>";
                curl_close($curl);
                $response = json_decode($json_response, true);
            }
        }
    }


    public function sosl_query($event_invitees,$user_id)//will get matched (CONTACT OR lEAD) according to email
    {
        echo '<br><br>Searching Sosl Invitees:<br>';
        print_r($event_invitees);

        $query = "FIND {";
        $invitees_count = count($event_invitees);

        if($invitees_count != 0)
        {
            $counter = 0;
            foreach($event_invitees as $invitee)
            {
                $counter = $counter + 1;
                $email = $invitee['email'];
                if($counter != $invitees_count)
                {
                    $query = $query . "$email OR ";
                }
                else
                {
                    $query = $query . "$email ";
                }
                $this->invitees_status[$email] = $invitee['responseStatus'];

            }


            $query = $query . "}  In Email FIELDS RETURNING Contact(Id,name,Email where OwnerId='" . $user_id . "' ),Lead(Id,Name,Email where OwnerId='" . $user_id . "')";
            echo  "<br><br>query $query <br>";
            $url = "$this->instance_url/services/data/v37.0/search?q=" . urlencode($query);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Authorization: OAuth $this->access_token"));
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            $json_response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($json_response, true);
            $results =  (array) $response['searchRecords'];
            echo '<br><br>Salesforce Searched Events:<br>';
            print_r($results);
            echo '<br><br>';
            return $results;
        }
    }


    function maskUserId($eventid=array())
    {
        $total_size = count($eventid);
        $count=0;
        $f_eventid="(";
        foreach ( $eventid as $eid) {
            $count++;
            $f_eventid=$f_eventid . "'" . $eid . "'";
            if($count!=$total_size)
            {
                $f_eventid=$f_eventid . ",";
            }
        }
        $f_eventid=$f_eventid . ")";

        if($total_size == 0)
        {
            return null;
        }

        return $f_eventid;
    }


    public function get_updated_event($user_id)//will get sfdc event id of new and updated events
    {
        $query = "SELECT Id, Subject, Description, Location, StartDateTime, EndDateTime, GSyncRt__Event_Id__c FROM Event where GSyncRt__Event_Id__c In " . $this->uevents_sf_ids
            . " and OwnerId =  '" . $user_id . "'" ;

        echo $query;



        $url = "$this->instance_url/services/data/v29.0/query?q=" . urlencode($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $this->access_token"));
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        $json_response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json_response, true);
        $results =  (array) $response['records'];

        echo '<br><br>Salesforce Updated Event:<br>';
        print_r($results);

        $this->final_eventids = null;
        $this->final_invitees = null;

        foreach($results as $res)//will get attendees object by comparison between salesforce events id with local temp ids
        {
            $flag = false;
            $event_id_g = null;
            $event_sfdc_id = null;
            $event_invitees = null;
            foreach($this->uevents_attendees as $e_attendees)
            {
                if( $res['GSyncRt__Event_Id__c']  == $e_attendees['event_id'])
                {
                    $flag = true;
                    $event_invitees = $e_attendees['attendees'];

                }
            }
            if($flag == true)
            {
                echo "<br><br>Event Name ";
                echo $res['Subject'];
                echo "<br><br>";
                $invitees_ids = $this->sosl_query($event_invitees, $user_id); //will get matched (CONTACT OR lEAD) according to email
                $this->add_invitees($invitees_ids,$res['Id']);//will add invitees into salesforce through EVENT RELATION

            }
        }

        $this->final_eventids = $this->maskUserId($this->final_eventids);
        $this->final_invitees = $this->maskUserId($this->final_invitees);

        echo '<br><br> Final Event Ids:<br>';
        print_r($this->final_eventids);
        echo '<br><br> Final Contact or Lead Ids:<br>';
        print_r($this->final_invitees);
        echo '<br><br> Final Event Status:<br>';
        print_r($this->final_uevents);

        if($this->final_eventids != null)
        {
            $this->CheckEventRelationDuplication($this->final_eventids,$this->final_invitees);//will check fro duplication of events,Updation and DELETION
        }
        $this->final_eventids = null;//will hold updated event ids for updating INVITEES OBJECT(EVENT RELATION)
        $this->final_invitees = array();
        $this->invitees_status = array();


    }


    public function Upsert_Event($event,$api_GSyncRt__Event_Id__c, $attendees, $type, $event_sfd)
    {

        if ($type == 'Update')
        {
            $url = "$this->instance_url/services/data/v20.0/sobjects/Event/$event_sfd";
            $datetime = new DateTime();
            $datetime->modify('-1 minutes');
            $content = json_encode(array(
                "Subject" => $event['Subject'],
                "Description" => $event['Description'],
                "Location" => $event['Location'],
                "IsAllDayEvent" => $event['IsAllDayEvent'],
                "StartDateTime" => $event['StartDateTime'],
                "EndDateTime" => $event['EndDateTime'],
                "OwnerId" => $event['OwnerId']       
            ));

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: Bearer $this->access_token",
                    "Content-type: application/json"
                ));
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            echo "<br><br>Here is content=======<br/><br/>";
            echo $content;
            echo "<br><br>HTTP status $status Updating Event<br/><br/>";
        }
        else if ($type == 'New')
        {
            $url = "$this->instance_url/services/data/v20.0/sobjects/Event";
            $datetime = new DateTime();
            $datetime->modify('-1 minutes');

            $content = json_encode(array(
                "Subject" => $event['Subject'],
                "Description" => $event['Description'],
                "Location" => $event['Location'],
                "StartDateTime" => $event['StartDateTime'],
                "EndDateTime" => $event['EndDateTime'],
                "OwnerId" => $event['OwnerId'],
                "IsAllDayEvent" => $event['IsAllDayEvent'],
                "GSyncRt__Event_Id__c" => $api_GSyncRt__Event_Id__c,
                "GSyncRt__gtos__c" => true
            ));

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: Bearer $this->access_token",
                    "Content-type: application/json"
                ));
            curl_setopt($curl, CURLOPT_SSLVERSION, 6);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            echo "HTTP status $status creating Event<br/><br/>";
        }


        if ($status != 204 && $status != 201) {       //204 for update and 201 for insert
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        curl_close($curl);
        $response = json_decode($json_response, true);
        $id = $response["id"];

        $this->uevents_sf_ids [] =  $api_GSyncRt__Event_Id__c ;//will hold ids and attendees of new and updated event
        $this->uevents_attendees[] = array('event_id' => $api_GSyncRt__Event_Id__c, 'attendees' => $attendees);
        echo "Google EventAttendees<br/><br/>";
        print_r($attendees);
        echo '<br><br>';
        echo "Google Updated Event Ids<br/><br/>";
        print_r($this->uevents_sf_ids);
        echo '<br><br>';


    }

    function syncEventsFromGoogle() {

        $usersId=$this->getSalesforce->getGtosUsers($this->instance_url, $this->access_token);

        $count=0;
        foreach ((array) $usersId['records'] as $user)
        {
            $deleteEventsId=array();
            $eventsToUpsert = array();
            $upsertEventsId = array();
           
            $eventDetail=array();
            $eventDetail['access_token']=$user['GSyncRt__Oauth_Token__c'];
            $eventDetail['refresh_token']=$user['GSyncRt__Refresh_Token__c'];
            $eventDetail['token_type']=$user['GSyncRt__Token_Type__c'];
            $eventDetail['expires_in']=$user['GSyncRt__Expires_In__c'];
	    $eventDetail['last_sync']=$user['GSyncRt__LastEventSyncGsf__c'];
	    $eventDetail['syncEventsFrom']=$user['GSyncRt__SyncEventsFrom__c'];
            
            //date_default_timezone_set($user['Timezone__c']);
            $result=getEvents($eventDetail);
            $this->total_size = count($result['items']);//will get total updated events from google according to last sync date
            $this->count = 0;

            foreach($result['items'] as $event)
            {
                $this->count = $this->count + 1;
                if($event['status']=='cancelled')
                 {
                     array_push($deleteEventsId, $event['id']);
                 }
                 else if($event['status']=='confirmed')
                 {
                    $eu=array();
                     if( $event['recurrence'] == null)
                     {
                         $eu['Subject']=$event['summary'];
                         $eu['Description']=$event['description'];
                         $eu['Location']=$event['location'];
                         if($event['start']['date'] != null && $event['end']['date'] != null)
                         {
                             $eu['IsAllDayEvent'] = true;
                             $eu['StartDateTime']=$event['start']['date'];

                             $enddate=$event['end']['date'];
                             $mod_date = strtotime($enddate."- 1 day");
                             $eu['EndDateTime'] =  date("Y-m-d",$mod_date);
                             
                         }
                         else
                         {
                             $eu['IsAllDayEvent'] = false;
                             $eu['StartDateTime']=$event['start']['dateTime'];
                             $eu['EndDateTime']=$event['end']['dateTime'];
                         }

                         $eu['GSyncRt__Event_Id__c']=$event['id'];
                         $eu['OwnerId']=$user['Name'];
                         $eu['attendees'] = $event['attendees'];

                         //$this->upsertEvent($eu);
                         array_push($upsertEventsId, $event['id']);
                         array_push($eventsToUpsert, $eu);
                     }

                }
            }

            if(sizeof($eventsToUpsert) > 0)
            {
                $response=$this->getSalesforce->getEventsFromSalesforce($this->instance_url, $this->access_token, $upsertEventsId, $user['Name']);
                $sf_events= (array) $response['records'];

                foreach($eventsToUpsert as $u_events)
                {
                    $isInsert = true;

                    foreach($sf_events as $sf)
                    {
                        if($u_events['GSyncRt__Event_Id__c'] == $sf['GSyncRt__Event_Id__c'])
                        {
                            $isInsert = false;
                            $this->Upsert_Event($u_events,$u_events['GSyncRt__Event_Id__c'],$u_events['attendees'], 'Update', $sf['Id']);
                        }
                    }

                    if($isInsert == true)
                    {
                        $this->Upsert_Event($u_events,$u_events['GSyncRt__Event_Id__c'],$u_events['attendees'], 'New', null);
                    }

                }

                $this->uevents_sf_ids = $this->maskUserId($this->uevents_sf_ids);
                $this->get_updated_event($user['Name']);
                $this->uevents_sf_ids = array();
                $this->uevents_attendees = array();

            }



            if(sizeof($deleteEventsId) > 0)
            {
                //Deleting the events
                $deleteEvents=$this->getSalesforce->getEventsFromSalesforce($this->instance_url, $this->access_token, $deleteEventsId, $user['Name']);
                foreach($deleteEvents['records'] as $deleteEvent)
                {
                    $this->deleteEvent($deleteEvent['Id']);
                }
            }
            

            $this->updateUserSync($user['Id']);

        }
    }


    function deleteEvent($id) {
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

    function updateUserSync($userId) {
        $url = "$this->instance_url/services/data/v20.0/sobjects/GSyncRt__GSync_User__c/$userId";

        $datetime = new DateTime();
        $datetime->modify('-1 minutes');
        $content = json_encode(array("GSyncRt__LastEventSyncGsf__c"=>$datetime->format(DateTime::ATOM) ));
       
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Authorization: OAuth $this->access_token",
                    "Content-type: application/json"));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);

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


