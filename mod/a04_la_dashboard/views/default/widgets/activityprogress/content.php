<?php
$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$activities = array();
if ($widget->activityids) {
    $activity_ids = unserialize($widget->activityids);
    $activities = ClipitActivity::get_by_id($activity_ids);
}
$content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
if (!empty($activities)) {
    $content = elgg_view('dashboard/modules/activity_status_progress', array(
        'entities' => $activities
    ));
}
echo $content;
?>






