<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;


$activities = ClipitUser::get_activities(elgg_get_logged_in_user_entity()->getGUID());
$activity_options = array();
$values = array();
$activities = ClipitActivity::get_by_id($activities);
foreach ($activities as $activity) {
    $activity_options[$activity->name] = $activity->id;
    array_push($values,$activity->id);
}
if ( $widget->activityids ) {

    $values = unserialize($widget->activityids);
}

$params = array(
    'internalname' =>'params[activityids]',
    'name' => 'params[activityids]',
    'value' => $values,
    'options' => $activity_options,
    'id' => "activity_dropdown-$widget_id"

);

$activity_dropdown = elgg_view('input/checkboxes', $params);


?>
<div>
    <?php  elgg_echo('la_dashboard:widget:quizresult:selectactivity') ?>
</div>
<div>
    <?php echo $activity_dropdown; ?>
</div>


