<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


function refreshToken($refreshtoken)
{

    $token_url = LOGIN_URI. "/services/oauth2/token";
    
    $params = "grant_type=refresh_token" 
        . "&client_id=" . CLIENT_ID
        . "&client_secret=" . CLIENT_SECRET
        . "&refresh_token=" . $refreshtoken;


    $curl = curl_init($token_url);
    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
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


    return $response['access_token'];

}


?>
