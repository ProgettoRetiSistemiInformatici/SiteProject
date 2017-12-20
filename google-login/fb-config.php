<?php

require_once 'FB_API/vendor/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '384437665319826', // Replace {app-id} with your app id
  'app_secret' => '059369468eb08916c3d0f174fe0cba51',
  'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('https://localhost:8000/fb-callback.php', $permissions);

?>
