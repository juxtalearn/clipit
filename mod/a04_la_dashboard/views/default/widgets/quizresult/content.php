<?php
elgg_load_js("dojotoolkit");

$spider_colors = array("FF0000", "00FF00", "0000FF", "FFFF00", "FF00FF", "00FFFF", "000000",
    "800000", "008000", "000080", "808000", "800080", "008080", "808080",
    "C00000", "00C000", "0000C0", "C0C000", "C000C0", "00C0C0", "C0C0C0",
    "400000", "004000", "000040", "404000", "400040", "004040", "404040",
    "200000", "002000", "000020", "202000", "200020", "002020", "202020",
    "600000", "006000", "000060", "606000", "600060", "006060", "606060",
    "A00000", "00A000", "0000A0", "A0A000", "A000A0", "00A0A0", "A0A0A0",
    "E00000", "00E000", "0000E0", "E0E000", "E000E0", "00E0E0", "E0E0E0");
$widget = $vars['entity'];
$widget_id = $widget->guid;
$chart_identifier = "quiz-widget-$widget_id";
//First we need to verify the settings for this widget
$to_be_configured = false;
if (isset($widget->activity_id) && is_not_null($widget->activity_id)) {
    $activity = array_pop(ClipitActivity::get_by_id(array($widget->activity_id)));
} else {
    $to_be_configured = true;
}
if (isset($widget->quiz_id) && is_not_null($widget->quiz_id)) {
    $quiz = array_pop(ClipitQuiz::get_by_id(array($widget->quiz_id)));
} else {
    $to_be_configured = true;
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

if (isset($widget->group_id) && is_not_null($widget->group_id)) {
    if ($widget->group_id != 'all') {
        $group = ClipitGroup::get_by_id(array($widget->group_id));
    } else {
        $group_ids = ClipitActivity::get_groups($activity->id);
        $group = ClipitGroup::get_by_id($group_ids);
    }
} else {
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
    $additional_vars = array('activity' => $activity, 'quiz' => $quiz, 'scale' => $scale, 'group' => $group, 'spider_colors'=>$spider_colors);
    switch ($question_or_stumblingblock) {
        case ClipitTag::SUBTYPE:
            echo elgg_view('widgets/quizresult/content_sb', array_merge($vars, $additional_vars));
            break;
        case ClipitQuizQuestion::SUBTYPE:
            echo elgg_view('widgets/quizresult/content_quest', array_merge($vars, $additional_vars));
            break;
    }
}


?>