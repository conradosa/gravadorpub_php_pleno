<?php
session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '1015307052458565';
$appSecret = '37e9527ad2b18f19224416eb0cf89b32';
$redirectURL = 'https://gravadorpub.com.br/Facebook/index.php';
//$redirectURL = 'https://gravadorpub.com.br/home.php';
//$redirectURL = 'http://cp.chasingpapers.com/'; // Callback URL
//$redirectURL = 'http://cp4.chasingpapers.com/';
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>