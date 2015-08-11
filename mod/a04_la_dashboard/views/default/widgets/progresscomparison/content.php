<?php
//elgg_load_js("dojoconfig");
//elgg_load_js("dojotoolkit");


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

if (isset($widget->group_id) && is_not_null($widget->group_id)) {
    if ($widget->group_id != 'all') {
        $group = ClipitGroup::get_by_id(array($widget->group_id));
    } else {
        $group_ids = ClipitActivity::get_groups($activity->id);
        $group = ClipitGroup::get_by_id($group_ids);
    }
} else {
    $to_be_configured = true;
}


if ($to_be_configured) {
    $message = elgg_echo("la_dashboard:please_config_widget");
    echo <<< HTML
    <div id="widget_not_configured">
           $message
        </div>
HTML;
} else {
    echo <<< HTML
	<!--[if IE]>
   <iframe src="ajax/view/dojovis/progresscomparison_ajax?activity_id=$widget->activity_id&group_id=$widget->group_id&widget_id=$widget_id" width="500px" height="240px" frameBorder="0"></iframe>
<![endif]-->
<!--[if !IE]>-->
    <iframe src="ajax/view/dojovis/progresscomparison_ajax?activity_id=$widget->activity_id&group_id=$widget->group_id&widget_id=$widget_id" width="500px" height="240px" style="border:none"></iframe>
<!-- <![endif]-->
HTML;

  //  echo elgg_view("dojovis/progresscomparison",array('activity_id'=>$widget->activity_id, 'group_id'=>$widget->group_id,'widget_id'=>$widget_id));
}


?>