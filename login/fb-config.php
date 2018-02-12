<?php
require_once 'FB_API/vendor/autoload.php';

session_start();

$fb = new Facebook\Facebook([
  'app_id' => 'APP-ID', // Replace {app-id} with your app id
  'app_secret' => 'APP-SECRET',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('http://photolio.altervista.org/login/fb-callback.php', $permissions);

?>
