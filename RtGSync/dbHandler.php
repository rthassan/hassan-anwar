<?php

	$db = mysqli_connect('localhost','root','@UGARcrm00700');

	if(!$db){
		return "ERROR! Connection could not be made.";
		}
	$dbname = 'gsync';
	$dbtest = mysqli_select_db($db,$dbname);
	if(!$dbtest){
		return "ERROR! Database could not be opened.";
	}


	function addCredentials($tokenid, $access_token, $refresh_token, $instance_url, $userId){

		global $db;
		
		$query = "insert into Credentials(tokenid, accesstoken, refreshtoken, instanceurl, userId) values('$tokenid','$access_token','$refresh_token', '$instance_url','$userId')";
		
		$result = mysqli_query($db,$query);
		
		return $query;

	}

	function updateUserCredentials($tokenid, $access_token, $refresh_token, $instance_url, $userId) {
		global $db;

		$query="update Credentials set tokenid='$tokenid', accesstoken='$access_token', refreshtoken='$refresh_token', instanceurl='$instance_url' where userId = '$userId'";
		$result=mysqli_query($db,$query);

		return $result;

	}


	function checkUserCredentials($userId) {
		global $db;
		$query = "select * from Credentials where userid = '$userId' ";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) > 0){
			return true;
		}
		return false;

	}

	function getUserCredentials($userId){
		global $db;
		$query = "select * from Credentials where  userid = '$userId'"; 
		$result = mysqli_query($db,$query);
		return $result;
	}

	function getAllCredentials(){
		global $db;
		$query = "select * from Credentials"; 
		$result = mysqli_query($db,$query);
		return $result;
	}


?>