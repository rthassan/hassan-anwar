<?php


require_once 'GoogleOAuth.php';
require_once 'googleApi/src/Google_Client.php';
require_once 'googleApi/src/contrib/Google_CalendarService.php';
require_once 'googleApi/src/contrib/Google_PlusService.php';


function upsertEvent($events = array()) {
    $response = array();
    foreach ($events as $data) {

        $eventName = $data['EventSubject'];
        $eventLocation = $data['EventLocation'];
        $eventDescription = $data['EventDescription'];



        $IsAllDayEvent = $data['IsAllDayEvent'];

        if($IsAllDayEvent == true)
        {
            $startDate = new DateTime($data['EventStart']);
            $startofEvent = $startDate->format("Y-m-d");

            $endDate = new DateTime($data['EventEnd']);
            $end = $endDate->format("Y-m-d");
            $mod_date = strtotime($end."+ 1 day");
            $endofEvent =  date("Y-m-d",$mod_date);
            
        }
        else
        {
            $startDate = new DateTime($data['EventStart']);
            $startofEvent = $startDate->format(DateTime::ATOM);
            $endDate = new DateTime($data['EventEnd']);
            $endofEvent = $endDate->format(DateTime::ATOM);
        }

        $sf_attendees = $data['attendees'];

        $obj = new GoogleOAuth();
        $obj->access_token = $data['access_token'];
        $obj->refresh_token = $data['refresh_token'];
        $obj->token_type = $data['token_type'];
        $obj->expires_in = 3600;

        $arr = array();
        $client = new Google_Client($arr);
        $client->setApplicationName('SF to Calender');
        $client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
        $client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
        $client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
        $client->setScopes(array('https://www.googleapis.com/auth/calendar'));
        $client->setAccessType('offline');

        $authUrl = $client->createAuthUrl();
        $token = json_encode($obj);
         
        if (!$client->getAccessToken()) {
            $client->setAccessToken($token);
        }

        $cal = new Google_CalendarService($client);

        if ($client->getAccessToken()) {
            $event = new Google_Event();
            $event->setSummary($eventName);
            $event->setLocation($eventLocation);
            $event->setDescription($eventDescription);

            $attendees = array();
            foreach($sf_attendees as $g_attendee)
            {
                $attendee1 = new Google_EventAttendee();
                $attendee1->setEmail($g_attendee['email']);
                if($g_attendee['Status'] == 'New')
                {
                    $status_attendee = 'needsAction';
                }
                else if($g_attendee['Status'] == 'Accepted')
                {
                    $status_attendee = 'accepted';
                }
                else if($g_attendee['Status'] == 'Declined')
                {
                    $status_attendee = 'declined';
                }
                $attendee1->setResponseStatus($status_attendee);
                $attendees[] = $attendee1;

            }
            if($attendees != null)
            {
                $event->attendees = $attendees;
            }

            $start = new Google_EventDateTime();
            if($IsAllDayEvent == true)
            {
                $start->setDate($startofEvent);
            }
            else if($IsAllDayEvent == false)
            {
                $start->setDateTime($startofEvent);
            }

            $event->setStart($start);

            $end = new Google_EventDateTime();
            if($IsAllDayEvent == true)
            {
                $end->setDate($endofEvent);
            }
            else if($IsAllDayEvent == false)
            {
                $end->setDateTime($endofEvent);
            }

            $event->setEnd($end);

            if ($data['Status'] === "new") {
                $calendarId = 'primary';
                $eventRet = $cal->events->insert($calendarId, $event);
                $response[$data['EventId']] = $eventRet['id'];

            } else if ($data['Status'] === "update") {
                
                $calendarId = 'primary';
                try {
                    $eventRet = $cal->events->update($calendarId, $data['GoogleId'], $event);
                    //$response[$data['EventId']] = $eventRet['id'];
                    //print_r($eventRet['id']);
                }
                catch(Exception $e)
                {
                    $eventRet = $cal->events->insert($calendarId, $event);
                    $response[$data['EventId']] = $eventRet['id'];
                }  
                
            }
            else if ($data['Status'] === "delete") {
                $calendarId = 'primary';
                 try {
                    $cal->events->delete($calendarId, $data['GoogleId']);
                }
                catch(Exception $e)
                {
                }      
            }
        }
    }

    return $response;
}


function deleteEventsFromGoogle($events = array()) {
    $response = array('Sync deletion Successful');
    foreach ($events as $data) {

        $obj = new GoogleOAuth();
        $obj->access_token = $data['access_token'];
        $obj->refresh_token = $data['refresh_token'];
        $obj->token_type = $data['token_type'];
        $obj->expires_in = 3600;

        $arr = array();
        $client = new Google_Client($arr);
        $client->setApplicationName('SF to Calender');
        $client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
        $client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
        $client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
        $client->setScopes(array('https://www.googleapis.com/auth/calendar'));
        $client->setAccessType('offline');

        $authUrl = $client->createAuthUrl();
        $token = json_encode($obj);
         
        if (!$client->getAccessToken()) {
            $client->setAccessToken($token);
        }

        $cal = new Google_CalendarService($client);

        if ($client->getAccessToken()) {
           
            $calendarId = 'primary';
            try {
                $cal->events->delete($calendarId, $data['GoogleId']);
            }
            catch(Exception $e)
            {
            }      
        
        }

    }

    return $response;
}

function deleteEventFromGoogle($googleid, $access_token, $refresh_token, $token_type) {
    $response = array('Sync deletion Successful');

        $obj = new GoogleOAuth();
        $obj->access_token = $access_token;
        $obj->refresh_token = $refresh_token;
        $obj->token_type = $token_type;
        $obj->expires_in = 3600;

        $arr = array();
        $client = new Google_Client($arr);
        $client->setApplicationName('SF to Calender');
        $client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
        $client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
        $client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
        $client->setScopes(array('https://www.googleapis.com/auth/calendar'));
        $client->setAccessType('offline');

        $authUrl = $client->createAuthUrl();
        $token = json_encode($obj);
         
        if (!$client->getAccessToken()) {
            $client->setAccessToken($token);
        }

        $cal = new Google_CalendarService($client);

        if ($client->getAccessToken()) {
           
            $calendarId = 'primary';
            try {
                $cal->events->delete($calendarId, $googleid);
            }
            catch(Exception $e)
            {
            }      
        
        }

    return $response;
}


function getEvents($data) {
    $response = array();
    
    $obj = new GoogleOAuth();
    $obj->access_token = $data['access_token'];
    $obj->refresh_token = $data['refresh_token'];
    $obj->token_type = $data['token_type'];
    $obj->expires_in = 3600;

    $lastSync=$data['last_sync'];
    $syncEventsFrom=$data['syncEventsFrom'];

    $arr = array();
    $client = new Google_Client($arr);
    $client->setApplicationName('SF to Calender');
    $client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
    $client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
    $client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
    $client->setScopes(array('https://www.googleapis.com/auth/calendar'));
    $client->setAccessType('offline');

    $authUrl = $client->createAuthUrl();
    $token = json_encode($obj);

    if (!$client->getAccessToken()) {
        $client->setAccessToken($token);
    }

    $cal = new Google_CalendarService($client);

    if ($client->getAccessToken()) {
        $calendarId = 'primary';

        if($lastSync!=null)
        {
		print_r('We are provided with lastSync');
             $events = $cal->events->listEvents($calendarId, array('showDeleted'=>true, "updatedMin"=>$lastSync));
        }
        else if ($syncEventsFrom!=null)
        {
		print_r('We are provided with SyncEventsFrom');
             $events = $cal->events->listEvents($calendarId, array('showDeleted'=>true, "timeMin"=>$syncEventsFrom));
        }
	else
	{
		print_r('We are provided with default 2016');
	     $events = $cal->events->listEvents($calendarId, array('showDeleted'=>true, "timeMin"=>"2016-01-01T0:00:00-00:00"));
	}

	print_r('Checkkk Eventss Here!!!');
        print_r($events);
       // die();
        return $events;
    }
}


function getEmail($access,$refresh,$tokentype,$expiresin) {
    
    $response=array();
    $obj = new GoogleOAuth();
    $obj->access_token =$access;
    $obj->refresh_token = $refresh;//$data['refresh_token'];
    $obj->token_type = $tokentype;
    $obj->expires_in = 3600;

    
    $arr = array();
    $client = new Google_Client($arr);
    $client->setApplicationName('Get Email');
    $client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
    $client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
    $client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
    $client->setScopes(array(
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/userinfo.email'));
    $client->setAccessType('offline');


    $authUrl = $client->createAuthUrl();
    $token = json_encode($obj);

    if (!$client->getAccessToken()) {
        $client->setAccessToken($token);
    }

    $plus = new Google_PlusService($client);

    //print_r($plus);
    $me = $plus->people->get('me');

    return $me['emails'][0]['value'];


}