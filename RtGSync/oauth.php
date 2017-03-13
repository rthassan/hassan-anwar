<?php
require_once 'config.php';

session_start();

//$data = file_get_contents("php://input");
//$parsedData = json_decode($data);
//$parsedData->userId;

$_SESSION['userId']=$_GET['userId'];

$auth_url = LOGIN_URI
        . "/services/oauth2/authorize?response_type=code&client_id="
        . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT_URI);

header('Location: ' . $auth_url);
?>
