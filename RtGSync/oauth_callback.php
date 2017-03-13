<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once 'config.php';

session_start();

$token_url = LOGIN_URI . "/services/oauth2/token";

$code = $_GET['code'];

if (!isset($code) || $code == "") {
    die("Error - code parameter missing from request!");
}

$params = "grant_type=authorization_code" 
    . "&code=" . $code
    . "&client_id=" . CLIENT_ID
    . "&client_secret=" . CLIENT_SECRET
    . "&redirect_uri=" . urlencode(REDIRECT_URI);



$curl = curl_init($token_url);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

$json_response = curl_exec($curl);


$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


if ( $status != 200 ) {
    die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}

curl_close($curl);


$response = json_decode($json_response, true);


$access_token = $response['access_token'];
$refresh_token = $response['refresh_token'];
$instance_url = $response['instance_url'];
$tokenid = $response['id'];
$userId= $_SESSION['userId'];

if (!isset($access_token) || $access_token == "") {
    die("Error - access token missing from response!");
}

if (!isset($instance_url) || $instance_url == "") {
    die("Error - instance URL missing from response!");
}


$dbstatus = include "dbHandler.php";
	if($dbstatus == "ERROR! Connection could not be made." || $dbstatus == "ERROR! Database could not be opened."){
			die("Database Error!");
	}


if(checkUserCredentials($userId))
{
	$dbresponse=updateUserCredentials($tokenid, $access_token, $refresh_token, $instance_url, $userId);
}
else
{
	$dbresponse=addCredentials($tokenid, $access_token, $refresh_token, $instance_url, $userId);
}


echo ("<script>location.href='https://gsyncrt.ap2.visual.force.com/apex/GoogleSync'</script>");

?>
