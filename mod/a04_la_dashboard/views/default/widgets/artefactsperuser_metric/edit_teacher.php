<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$logged_in_user = elgg_get_logged_in_user_entity();

$activities = ClipitActivity::get_by_id(ClipitUser::get_activities($logged_in_user->guid));
$activity_options = array(0 => elgg_echo('la_dashboard:widget:quizresult:selectactivity'));
foreach ($activities as $activity) {
    $activity_options[$activity->id] = $activity->name;
}
if (!isset($widget->activity_id)) {
    $widget->activity_id = reset($activities);
}

?>
<div class="select-metrics">
    <div style="padding: 10px;background: #fafafa;">
        <div class="form-group">
            <label><?php echo elgg_echo("la_dashboard:widget:availableactivities"); ?></label>
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
    </div>
</div>
<script>
    $('<?php echo "#activity_dropdown-$widget_id" ?>').change(function(){
        var selectedOption = $('<?php echo "#activity_dropdown-$widget_id" ?> option:selected').val();
        if (selectedOption == 0){
            $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = true;
        } else {
            $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = false;
        }
    })
</script>