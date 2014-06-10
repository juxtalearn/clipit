<?php
session_start();
set_include_path(get_include_path() . PATH_SEPARATOR . elgg_get_plugins_path() . "z02_clipit_api/libraries/google_api/src/");
require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';
$REDIRECT = elgg_get_site_url()."youtube_auth";
$APP_NAME = elgg_get_site_entity()->name;
$SCOPES = "https://www.googleapis.com/auth/youtube";

$client = new Google_Client();
$client->setAccessType('offline');
$client->setApplicationName($APP_NAME);
$client->setClientId(get_config("google_id")); // @todo: replace with form
$client->setClientSecret(get_config("google_secret")); // @todo: replace with form
$client->setRedirectUri($REDIRECT);
$client->setScopes($SCOPES);
$client->setApprovalPrompt("force");

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if (isset($_GET['code'])) {
    if (strval($_SESSION['state']) !== strval($_GET['state'])) {
        die('The session state did not match.');
    }

    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: ' . $REDIRECT);
}

if ($token = $client->getAccessToken()) {
    $html_title = "SUCCESS!";
    $html_body = "Google API token: ". $token;
    $_SESSION['token'] = $token;
    $token_array = json_decode($token);
    set_config("google_token", $token_array->access_token);
    set_config("google_refresh_token", $token_array->refresh_token);
    //session_destroy();
}else{
    $html_title = "Authorization needed";

    //@todo: make form so that the user inputs google_id and google_secret
    $html_body = "Click <a href=\"".$client->createAuthUrl()."\">HERE</a> to Authorize access to Google.";
}
?>

<html>
<body>
<H3><?echo $html_title?></H3>
<?echo $html_body?>
</body>
</html>

