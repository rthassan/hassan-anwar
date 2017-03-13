<?php

require_once 'client.php';

$data = file_get_contents("php://input");
$parsedData = json_decode($data);

$googleid=$parsedData->GoogleId;
$access_token=$parsedData->access_token;
$refresh_token=$parsedData->refresh_token;
$token_type=$parsedData->token_type;


deleteEventFromGoogle($googleid, $access_token, $refresh_token, $token_type);

?>