<?php
/**
 * Created by PhpStorm.
 * User: Daems
 * Date: 22.07.14
 * Time: 12:01
 */

admin_gatekeeper();
action_gatekeeper("rebuild");
include_once(elgg_get_plugins_path(). "a01_activitystreamer" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "logProcessing.php");
$_SESSION['transaction'] = "";
$affirmative = get_input('affirmative', 1);
$context = array();
//$context['activity_id'] = 3802;
$runId = ActivityStreamer::get_metric(1,1, $context);
system_message("<h1>Successfully requested analysis with runId = ".$runId);

