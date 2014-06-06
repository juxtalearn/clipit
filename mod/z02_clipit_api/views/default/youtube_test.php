<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 06/06/2014
 * Time: 13:10
 */
session_start();


// Call set_include_path() as needed to point to your client library.
set_include_path( get_include_path() . PATH_SEPARATOR . elgg_get_plugins_path() . "z02_clipit_api/libraries/google_api/src/" );

require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';

$CLIENT_ID = "601527589472-06u94hm8dnodib6qmqk6mlul3auoosv0@developer.gserviceaccount.com";
$KEY = file_get_contents(elgg_get_plugins_path() . "z02_clipit_api/google_private_key.p12");
$SCOPE = "https://www.googleapis.com/auth/youtube";
$APP_NAME = "ClipIt";

$client = new Google_Client();
// Replace this with your application name.
$client->setApplicationName("$APP_NAME");
// Replace this with the service you are using.
$youtube = new Google_Service_YouTube($client);

if (isset($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['service_token']);
}else {
    $creds = new Google_Auth_AssertionCredentials(
        $CLIENT_ID,
        array($SCOPE),
        $KEY
    );
    $client->setAssertionCredentials($creds);
    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($creds);
    }
    $_SESSION['access_token'] = $client->getAccessToken();
}


$snippet = new Google_VideoSnippet();
$snippet->setTitle("Test title");
$snippet->setDescription("Test descrition");
$snippet->setTags(array("tag1","tag2"));
$snippet->setCategoryId("22");

$status = new Google_VideoStatus();
$status->privacyStatus = "private";

$video = new Google_Video();
$video->setSnippet($snippet);
$video->setStatus($status);

$error = true;
$i = 0;

try {
    $obj = $youTubeService->videos->insert("status,snippet", $video,
        array("data"=>file_get_contents("video.mp4"),
            "mimeType" => "video/mp4"));
} catch(Google_ServiceException $e) {
    print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage(). " <br>";
    print "Stack trace is ".$e->getTraceAsString();
}

//*
// * You can acquire an OAuth 2.0 client ID and client secret from the
// * Google Developers Console <https://console.developers.google.com/>
// * For more information about using OAuth 2.0 to access Google APIs, please see:
// * <https://developers.google.com/youtube/v3/guides/authentication>
// * Please ensure that you have enabled the YouTube Data API for your project.
// */
//$OAUTH2_CLIENT_ID = '601527589472-p8dhttocqhj1hkioamaanvb1gnjo89n7.apps.googleusercontent.com';
//$OAUTH2_CLIENT_SECRET = 'Wdw1LWJpAGwSONGsoAsIp3HT';
//
//$client = new Google_Client();
//$client->setClientId($OAUTH2_CLIENT_ID);
//$client->setClientSecret($OAUTH2_CLIENT_SECRET);
//$client->setScopes('https://www.googleapis.com/auth/youtube');
//$redirect = "http://jxl1.escet.urjc.es/clipit_dev/youtube_test";
////$client->setRedirectUri($redirect);
//$client->setRedirectUri($redirect);
//
//// Define an object that will be used to make all API requests.
//$youtube = new Google_Service_YouTube($client);
//
//if (isset($_GET['code'])) {
//    if (strval($_SESSION['state']) !== strval($_GET['state'])) {
//        die('The session state did not match.');
//    }
//
//    $client->authenticate($_GET['code']);
//    $_SESSION['token'] = $client->getAccessToken();
//    header('Location: ' . $redirect);
//}
//
//if (isset($_SESSION['token'])) {
//    $client->setAccessToken($_SESSION['token']);
//}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
    try{
        // REPLACE this value with the path to the file you are uploading.
        $videoPath = elgg_get_plugins_path() . "z02_clipit_api/video_test.m2v";

        // Create a snippet with title, description, tags and category ID
        // Create an asset resource and set its snippet metadata and type.
        // This example sets the video's title, description, keyword tags, and
        // video category.
        $snippet = new Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle("Test title");
        $snippet->setDescription("Test description");
        $snippet->setTags(array("tag1", "tag2"));

        // Numeric video category. See
        // https://developers.google.com/youtube/v3/docs/videoCategories/list
        $snippet->setCategoryId("22");

        // Set the video's status to "public". Valid statuses are "public",
        // "private" and "unlisted".
        $status = new Google_Service_YouTube_VideoStatus();
        $status->privacyStatus = "unlisted";

        // Associate the snippet and status objects with a new video resource.
        $video = new Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);

        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $youtube->videos->insert("status,snippet", $video);

        // Create a MediaFileUpload object for resumable uploads.
        $media = new Google_Http_MediaFileUpload(
            $client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );
        $media->setFileSize(filesize($videoPath));


        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($videoPath, "rb");
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }

        fclose($handle);


        $htmlBody .= "<h3>Video Uploaded</h3><ul>";
        $htmlBody .= sprintf('<li>%s (%s)</li>',
            $status['snippet']['title'],
            $status['id']);

        $htmlBody .= '</ul>';

    } catch (Google_ServiceException $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    }

    $_SESSION['token'] = $client->getAccessToken();
} else {
    // If the user hasn't authorized the app, initiate the OAuth flow
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl();
    $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
?>

<!doctype html>
<html>
<head>
    <title>Video Uploaded</title>
</head>
<body>
<?=$htmlBody?>
</body>
</html>