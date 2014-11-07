<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */

admin_gatekeeper();
action_gatekeeper("request");
include_once(elgg_get_plugins_path(). "a01_activitystreamer" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "logProcessing.php");
$_SESSION['transaction'] = "";
$affirmative = get_input('affirmative', 1);
$context = array('debug' => true);
//$context['activity_id'] = 3802;
$metrics = ActivityStreamer::get_available_metrics();
if (!empty($metrics) && isset($metrics[0]) && isset($metrics[0]['TemplateId']) && $metrics[0]['TemplateId'] > 0) {
    $metric_id = $metrics[0]['TemplateId'];
    $first_return_id = ActivityStreamer::get_metric($metric_id, $context);
    $second_return_id = ActivityStreamer::get_metric($metric_id, $context);

    if ($first_return_id == $second_return_id) {
        system_message("Successfully requested two analysis runs with returnId = ".$first_return_id);
    }
    else {
        system_message("Sadly I requested two analysis runs and got two different returnIds: ".$first_return_id." and ".$second_return_id);
    }
}
else {
    system_message("No metric available for the test run!");
}