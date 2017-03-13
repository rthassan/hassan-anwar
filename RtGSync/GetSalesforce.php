<?php

class GetSalesforce
{
	function getStogUsers($instance_url, $access_token)
	{
	    $query = "SELECT Id, Name, GSyncRt__Oauth_Token__c, GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c, GSyncRt__Expires_In__c, GSyncRt__LastEventSyncSfg__c, GSyncRt__SyncEventsFrom__c from GSyncRt__GSync_User__c where GSyncRt__syncStatus__c='Salesforce to Google' OR GSyncRt__syncStatus__c='Bidirectional'";
	    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
	    curl_setopt($curl, CURLOPT_HTTPHEADER,
	            array("Authorization: OAuth $access_token"));

	    $json_response = curl_exec($curl);
	    curl_close($curl);

	    $response = json_decode($json_response, true);

	    return $response;

	}

	function getUser($instance_url, $access_token, $userId)
	{
	    $query = "SELECT Id, Name, GSyncRt__Oauth_Token__c, GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c, GSyncRt__Expires_In__c from GSyncRt__GSync_User__c where Name='". $userId . "'";
	    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
	    curl_setopt($curl, CURLOPT_HTTPHEADER,
	            array("Authorization: OAuth $access_token"));

	    $json_response = curl_exec($curl);
	    curl_close($curl);

	    $response = json_decode($json_response, true);

	    return $response;

	}

	function maskUserId($users=array())
	{
	    $total_size = $users['totalSize'];
	    $count=0;
	    $usersId="(";
	    foreach ( $users['records'] as $user) {
	        $count++;
	        $usersId=$usersId . "'" . $user['Name'] . "'";
	        if($count!=$total_size)
	        {
	            $usersId=$usersId . ",";
	        }
	    }
	    $usersId=$usersId . ")";
	    
	    return $usersId;
	}

	function getGtosUsers($instance_url, $access_token)
	{
	    $query = "SELECT Id, Name, GSyncRt__Oauth_Token__c, GSyncRt__Refresh_Token__c, GSyncRt__Token_Type__c, GSyncRt__Expires_In__c, GSyncRt__LastEventSyncGsf__c, GSyncRt__SyncEventsFrom__c FROM GSyncRt__GSync_User__c where GSyncRt__syncStatus__c='Google to Salesforce' OR GSyncRt__syncStatus__c='Bidirectional'";
	    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
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

	function getEventsFromSalesforce($instance_url, $access_token, $eventId, $user_id)
	{
	    $query = "SELECT Id, Subject, Description, Location, StartDateTime, EndDateTime, GSyncRt__Event_Id__c from Event where GSyncRt__Event_Id__c IN ". $this->maskEventId($eventId)
			     . "and OwnerId =  '" . $user_id . "'" ;
	    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
	    curl_setopt($curl, CURLOPT_HTTPHEADER,
	            array("Authorization: OAuth $access_token"));
	    $json_response = curl_exec($curl);
	    curl_close($curl);
	    $response = json_decode($json_response, true);
	    
	    return $response;

	}

}


?>
