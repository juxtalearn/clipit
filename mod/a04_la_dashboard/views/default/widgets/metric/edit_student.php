
<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$metrics = elgg_extract('metrics', $vars);

$available_metrics = array('' => elgg_echo('la_dashboard:select_metric'));
foreach(ActivityStreamer::get_available_metrics() as $metric){
    $available_metrics[$metric['TemplateId']] = $metric['Name'];
}

if ( elgg_is_admin_logged_in() ) {
    $activities = ClipitActivity::get_all();
} else {
    $activities = ClipitActivity::get_from_user(elgg_get_logged_in_user_guid(),false);
}


$activity_options = array(0 => elgg_echo('la_dashboard:widget:quizresult:selectactivity'));
foreach ($activities as $activity) {
    $activity_options[$activity->id] = $activity->name;
}
if (!isset($widget->metric_id)) {
    $widget->metric_id=reset($available_metrics);
    $configured = false;
}
if (!isset($widget->activity_id)) {
    $widget->activity_id=reset($activities);
}

if ( elgg_is_admin_logged_in() ) {
    $all_users = ClipitUser::get_all();
} else {
    $all_users = array(elgg_get_logged_in_user_entity());
}
$user_options = array();
foreach ($all_users as $user){
    $user_options[$user->id] = $user->name;
}

if (!isset($widget->user_id)) {
    $widget->activity_id=reset($all_users);
}


?>
<div class="select-metrics">
    <div style="padding: 10px;background: #fafafa;">
        <div class="form-group">
            <label><?php echo elgg_echo("activity:select"); ?></label>
            <?php
            $params = array('class' => "form-control available-metrics-$widget_id",
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'name' => 'params[activity_id]',
                'value' => $vars['entity']->activity_id,
                'options_values' => $activity_options,
                'id' => "activity_dropdown-$widget_id",
                'required' => false,
            );
            echo elgg_view('input/dropdown', $params);
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo("user:select"); ?></label>
            <?php
            $params = array('class' => "form-control available-metrics-$widget_id",
                'style' => 'padding-top: 5px;padding-bottom: 5px;',
                'name' => 'params[user_id]',
                'value' => $vars['entity']->user_id,
                'options_values' => $user_options,
                'id' => "userid_dropdown-$widget_id",
                'required' => false,
            );
            echo elgg_view('input/dropdown', $params);
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