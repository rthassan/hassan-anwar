<?php
require_once ("ContactSyncHelp.php");

    function init_sync_sfg($authdata, $contlist, $insturl, $accesstoken, $functype) {

        $arr=array();
        $google_client = new Google_Client($arr);
        
        $auth_handler  = new GoogleOauthHandler();
        $google_client->setApplicationName('SF to Contacts');
        $google_client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
        $google_client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
        $google_client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
        $google_client->setScopes(array('https://www.google.com/m8/feeds/contacts/default/full'));
        $google_client->setAccessType('offline');
        $google_client->setState('profile');
        $res = '';
        $jsonCredentials = $auth_handler->getStoredCredentials($authdata);
        if ($jsonCredentials) {
            $oauthCredentials = $auth_handler->getOauth2Credentials($jsonCredentials);
            $google_client->setAccessToken($oauthCredentials->toJson());
            if ($google_client->getAccessToken()) {
                if ($functype == 'init') {
                    $res = ContactSyncHelp::sendUpdatedToGoogle($authdata['GSyncRt__UserEmail__c'],$google_client,$contlist,$insturl, $accesstoken);
                } else if ($functype == 'del') {
                    $res = ContactSyncHelp::deleteAllInGoogle($authdata['GSyncRt__OldEmail__c'],$google_client,$contlist,$insturl, $accesstoken);
                } else if ($functype == 'delChangedOwner') {
                    $res = ContactSyncHelp::delChangedOwnerContact($authdata['GSyncRt__UserEmail__c'],$google_client,$contlist,$insturl, $accesstoken);
                }
                
            } else {
                // file_put_contents('log.txt', '$google_client->authenticate()');
            }
        }
        else {
            // file_put_contents('log.txt', '$google_client->authenticate()');
        }
        return $res; 
    }

    function init_sync_gsf($data) {
        $arr=array();
        $google_client = new Google_Client($arr);
        
        $auth_handler  = new GoogleOauthHandler();
        $google_client->setApplicationName('SF to Contacts');
        $google_client->setClientId('656909959219-oljtmqnkvap7ho6l4873lfnq19esfq67.apps.googleusercontent.com');
        $google_client->setClientSecret('OruM9ArhjtJQU_kb2EuR7g2_');
        $google_client->setRedirectUri('https://GSyncRt.ap2.visual.force.com/apex/GoogleSync');
        $google_client->setScopes(array('https://www.google.com/m8/feeds/contacts/default/full'));
        $google_client->setAccessType('offline');
        $google_client->setState('profile');
        $res = '';
        $jsonCredentials = $auth_handler->getStoredCredentials($data);
        if ($jsonCredentials) {
            $oauthCredentials = $auth_handler->getOauth2Credentials($jsonCredentials);
            $google_client->setAccessToken($oauthCredentials->toJson());
            if ($google_client->getAccessToken()) {

                $res = ContactSyncHelp::updateFromGoogle($google_client, $data);
            } else {
                // file_put_contents('log.txt', '$google_client->authenticate()');
            }
        }
        else {
            // file_put_contents('log.txt', '$google_client->authenticate()');
        }
        return $res; 
    }

?>