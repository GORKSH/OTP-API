<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '845962967977-vlj33c9htvhtakj9k8qffjbbevb0u4bl.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'aCg0vRxVtRVBRPwG99NxFNKN'; //Google client secret
$redirectURL = 'http://localhost/OTP-API/'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>