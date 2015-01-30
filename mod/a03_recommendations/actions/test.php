<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */
include_once(elgg_get_plugins_path(). "a03_recommendations" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "RecommendationEngine.php");
admin_gatekeeper();
action_gatekeeper("request");

$user_id = elgg_get_logged_in_user_guid();
$videos = RecommendationEngine::get_recommended_lsd_videos(array($user_id), 5);
if (!empty($videos)) {
    system_message("Successfully received " . count($videos['videos']) . " videos as recommendations:<br />".print_r($videos, true));
} else {
    system_message("Sadly I did not receive any video recommendations.");
}