<?php
require_once __DIR__ . '/../app/vendor/autoload.php';
require_once '../app/config.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;

// start session
session_start();

// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper($GLOBALS["LOGIN_URL"]);

$session = getSession();
if (!$session) {
    try {
        $session = $helper->getSessionFromRedirect();
    } catch (FacebookRequestException $ex) {
    } catch (Exception $ex) {
    }

    if ($session) {
        $_SESSION["fb-auth"] = $session->getToken();
    }
}

// see if we have a session
if ($session) {
    header('Location: index.html');
} else {
    // show login url
    header("Location:" . $helper->getLoginUrl( array('publish_actions', 'user_events', 'rsvp_event') ));
}

?>
