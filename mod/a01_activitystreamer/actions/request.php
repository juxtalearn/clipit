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
$context = array();
//$context['activity_id'] = 3802;
$first_return_id = ActivityStreamer::get_metric(1,1, $context);
$second_return_id = ActivityStreamer::get_metric(1,1, $context);

if ($first_return_id == $second_return_id) {
    system_message("<h1>Successfully requested two analysis runs with returnId = ".$first_return_id);
}
else {
    system_message("<h1>Sadly I requested two analysis runs and got two different returnIds: ".$first_return_id." and ".$second_return_id);
}

