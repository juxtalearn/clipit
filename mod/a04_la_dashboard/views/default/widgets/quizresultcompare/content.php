<?php

$widget = $vars['entity'];
$widget_id = $widget->guid;
$chart_identifier = "quiz-widget-$widget_id";
//First we need to verify the settings for this widget
$to_be_configured = false;
if (isset($widget->activity_id) && is_not_null($widget->activity_id)) {
    $activity_id = $widget->activity_id;
} else {
    $to_be_configured = true;
}
if (isset($widget->task_id1) && is_not_null($widget->task_id1)) {
    try {
        $quiz1_id = $widget->task_id1; //array_pop(ClipitQuiz::get_by_id(array($widget->task_id1)));
    } catch (Exception $e) {
        $widget->quiz_id=null;
        $to_be_configured=true;
    }

} else {
    $to_be_configured = true;
}
if (isset($widget->task_id2) && is_not_null($widget->task_id2)) {
    try {
        $quiz2_id = $widget->task_id2; //array_pop(ClipitQuiz::get_by_id(array($widget->task_id2)));
    } catch (Exception $e) {
        $widget->quiz_id=null;
        $to_be_configured=true;
    }

} else {
    $to_be_configured = true;
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
} else {
    $to_be_configured = true;
}

if (isset($widget->target_id) && is_not_null($widget->target_id)) {
    $target_id = $widget->target_id;//get_entity($widget->target_id);
} else {
    if  (( $to_be_configured === false ) && $scale!=ClipitActivity::SUBTYPE) {
        $to_be_configured = true;
    }
}

if ($to_be_configured) {
    $message = elgg_echo("la_dashboard:please_config_widget");
echo <<< HTML
    <div id="widget_not_configured">
           $message
        </div>
HTML;
} else {
    $additional_vars = array('question_or_stumbling_block'=>$question_or_stumblingblock,'target_id'=> $target_id, 'activity_id' => $activity_id, 'quiz1_id' => $quiz1_id,'quiz2_id' => $quiz2_id, 'scale' => $scale, 'group_id' => $widget->group_id,  'widget_id'=>$widget_id);
    $queryString = http_build_query($additional_vars);
    $site = elgg_get_site_url();
    echo <<< HTML
	<!--[if IE]>
        <iframe src="$site/ajax/view/widgets/quizresultcompare/quizresultcompare_ajax?$queryString" width="100%" height="240px" frameBorder="0"></iframe>
    <![endif]-->
    <!--[if !IE]>-->
        <iframe src="$site/ajax/view/widgets/quizresultcompare/quizresultcompare_ajax?$queryString" width="100%" height="240px" style="border:none"></iframe>
    <!-- <![endif]-->
HTML;
} ?>