<?php
$widget = $vars['entity'];
$widget_id = $widget->guid;
$chart_identifier = "quiz-widget-$widget_id";
//First we need to verify the settings for this widget
$to_be_configured = false;
if (isset($widget->activity_id) && is_not_null($widget->activity_id)) {
    //array_pop(ClipitActivity::get_by_id(array($widget->activity_id)));
    $activity_id = $widget->activity_id;
} else {
    $to_be_configured = true;
}
if (isset($widget->quiz_id) && is_not_null($widget->quiz_id)) {
    try {
        $quiz = array_pop(ClipitQuiz::get_by_id(array($widget->quiz_id)));
        $quiz_id=$widget->quiz_id;

    } catch (Exception $e) {
        $widget->quiz_id=null;
        $to_be_configured=true;
    }
} else {

    if  (elgg_in_context('activity_page')) {
        $page = get_input('page');
        $re = "/tasks\\/view\\/(.*)/";
        preg_match($re, $page, $matches);
        $task_id = $matches[1];
        $tmpTask = array_pop(ClipitTask::get_by_id(array($task_id)));
        $widget->quiz_id= $tmpTask->quiz;
        $widget->save();
        $quiz_id=$widget->quiz_id;
        $quiz = array_pop(ClipitQuiz::get_by_id(array($widget->quiz_id)));
    } else {
        $to_be_configured = true;
    }
}
if (isset($widget->scale) && is_not_null($widget->scale)) {
    $scale = $widget->scale;
} else {
    $to_be_configured = true;
}
if (isset($widget->question_or_stumblingblock) && is_not_null($widget->question_or_stumblingblock)) {
    $question_or_stumblingblock = $widget->question_or_stumblingblock;
} else {
    $to_be_configured = true;
}

if (! (isset($widget->group_id) && is_not_null($widget->group_id))) {
    if ($to_be_configured === false && $scale != ClipitActivity::SUBTYPE) {
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
    $task_id = ClipitQuiz::get_task($quiz_id);
    $task = array_pop(ClipitTask::get_by_id(array($task_id)));
    $additional_vars = array('question_or_stumbling_block'=>$question_or_stumblingblock,'activity_id' => $activity_id, 'quiz_id' => $quiz_id, 'scale' => $scale, 'group_id' => $widget->group_id,  'taskname'=>$task->name, 'widget_id'=>$widget_id);
    $queryString = http_build_query($additional_vars);
    $site = elgg_get_site_url();
    echo <<< HTML
	<!--[if IE]>
        <iframe src="$site/ajax/view/widgets/quizresult/quizresult_ajax?$queryString" width="100%" height="240px" frameBorder="0"></iframe>
    <![endif]-->
    <!--[if !IE]>-->
        <iframe src="$site/ajax/view/widgets/quizresult/quizresult_ajax?$queryString" width="100%" height="240px" style="border:none"></iframe>
    <!-- <![endif]-->
HTML;

}


?>