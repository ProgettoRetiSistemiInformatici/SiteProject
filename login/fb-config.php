<?php
require_once 'FB_API/vendor/autoload.php';

session_start();

$fb = new Facebook\Facebook([
  'app_id' => 'YOUR-APP-ID', // Replace {app-id} with your app id
  'app_secret' => 'YOUR-APP-SECRET',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('YOUR-CALLBACK-FILE', $permissions);

?>
