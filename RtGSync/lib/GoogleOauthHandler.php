<?php
require_once 'oauth_credentials.php';

class GoogleOauthHandler{

	function getOauth2Credentials($credentials){
		// global $sugar_config;
		$oauthCredentials = new OauthCredentials(
			$credentials['access_token'],
			isset($credentials['refresh_token'])?($credentials['refresh_token']):null,
			$credentials['token_type'],
			$credentials['expires_in'],
			'917684524848-lne3qos38lnle8d7lvlqrpkb08kurpco.apps.googleusercontent.com',
			'JQ9C9D-_jlqDa5kxZVFDGxMj'
		);

		return $oauthCredentials;
	}
	
	function getStoredCredentials($data){
		$credentials=array();
		
		$credentials=array(
			
			'access_token'	=> $data['GSyncRt__Oauth_Token__c'],
			'refresh_token'	=> $data['GSyncRt__Refresh_Token__c'],
			'token_type' => $data['GSyncRt__Token_Type__c'],
			'expires_in'	=> $data['GSyncRt__Expires_In__c'],
		);
		return $credentials;
			
	}

}
?>