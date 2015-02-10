
<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$metrics = elgg_extract('metrics', $vars);

$available_metrics = array('' => elgg_echo('la_dashboard:select_metric'));
foreach(ActivityStreamer::get_available_metrics() as $metric){
    $available_metrics[$metric['TemplateId']] = $metric['Name'];
}

$activities = array('' => elgg_echo('la_dashboard:select_activity'));
foreach (ClipitUser::get_activities(elgg_get_logged_in_user_guid()) as $activity_id) {
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    $activities[$activity->id] = $activity->name;
}
if (!isset($widget->metric_id)) {
    $widget->metric_id=reset($available_metrics);
    $configured = false;
}
if (!isset($widget->activity_id)) {
    $widget->activity_id=reset($activities);
}
?>
<div class="select-metrics">
    <div style="padding: 10px;background: #fafafa;">
        <div class="form-group">
            <label><?php echo elgg_echo("activity:select"); ?></label>
            <?php echo elgg_view('input/dropdown', array(
                'name' => 'params[activity_id]',
                'class' => "form-control activities-$widget_id",
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'required' => true,
                'value' =>  $widget->activity_id,
                'options_values' => $activities
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo("la_dashboard:available_metrics"); ?></label>
            <?php echo elgg_view('input/dropdown', array(
                'name' => 'params[metric_id]',
                'class' => "form-control available-metrics-$widget_id",
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'required' => true,
                'value' =>  $widget->metric_id,
                'options_values' => $available_metrics
            ));
            ?>
        </div>
    </div>
</div>