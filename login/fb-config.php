<?php
require_once 'FB_API/vendor/autoload.php';

session_start();

$fb = new Facebook\Facebook([
  'app_id' => '2018913155040770', // Replace {app-id} with your app id
  'app_secret' => 'f24b6f4f26606a4e951a4ed34bae6a91',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('http://photolio.com/login/fb-callback.php', $permissions);

?>
