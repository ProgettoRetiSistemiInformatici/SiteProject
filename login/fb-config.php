<?php
require_once 'FB_API/vendor/autoload.php';

session_start();

$fb = new Facebook\Facebook([
  'app_id' => '139108946732772', // Replace {app-id} with your app id
  'app_secret' => '3fa20aec1944b8ea55e28f249caabc6d',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('http://photolio.altervista.org/login/fb-callback.php', $permissions);

?>
