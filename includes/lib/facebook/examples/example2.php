<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once 'facebook.php';

$fbAppId = 'YOUR_APP_ID';
$fbSecret = 'YOUR_SECRET';
$fbCanvasUrl = 'http://apps.facebook.com/YOURAPP';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $fbAppId,
  'secret' => $fbSecret,
));

// Get User ID
$user = $facebook->getUser();

// Redirect to the canvas url if we're authorized and logged in
// You can also use $_REQUEST['signed_request'] for this
if($_GET['code']) {
    echo "<script>top.location.href='".$fbCanvasUrl."'</script>";
    exit;
}

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
else {
  $loginUrl = $facebook->getLoginUrl();
  echo "<script>top.location.href='".$loginUrl."'</script>";
  exit;
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
        font-size: 11px;
        color: #333333;
        padding: 0;
        margin: 0;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div id="fb-root"></div>
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({appId: '<?=$fbAppId?>', status: true, cookie: true, xfbml: true});
        };
        (function() {
            var ts = new Date().getTime();
            var e = document.createElement("script");
            e.type = "text/javascript";
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js?ts='+ts;
            e.async = true;
            document.getElementById("fb-root").appendChild(e);
        }());
    </script>
    <h1>php-sdk</h1>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>
  </body>
</html>
