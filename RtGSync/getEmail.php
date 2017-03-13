<?php

require_once 'client.php';

class GetEmail
{
    public function getUserEmail($access,$refresh,$tokentype,$expiresin){
         return getEmail($access,$refresh,$tokentype,$expiresin);

    }

}

$data = file_get_contents("php://input");
$parsedData = json_decode($data);
$access=$parsedData->access;
$refresh=$parsedData->refresh;
$tokentype=$parsedData->tokentype;
$expiresin=$parsedData->expiresin;


$obj = new GetEmail();

$response=$obj->getUserEmail($access,$refresh,$tokentype,$expiresin);

print_r($response);
return $response;




?>