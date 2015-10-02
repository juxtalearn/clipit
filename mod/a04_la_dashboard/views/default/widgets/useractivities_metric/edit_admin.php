<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$logged_in_user = elgg_get_logged_in_user_entity();

$all_users = ClipitUser::get_all();
$user_options = array(0 => elgg_echo('la_dashboard:widget:selectuser'));
foreach ($all_users as $user) {
    $user_options[$user->id] = $user->name;
}

if (!isset($widget->user_id)) {
    $widget->activity_id = reset($all_users);
    $configured = false;
}


?>
<div class="select-metrics">
    <div style="padding: 10px;background: #fafafa;">
        <div class="form-group">
            <label><?php echo elgg_echo("la_dashboard:widget:availableusers"); ?></label>
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
    </div>
</div>
<script>
    $('<?php echo "#userid_dropdown-$widget_id" ?>').change(function(){
        var selectedOption = $('<?php echo "#userid_dropdown-$widget_id" ?> option:selected').val();
        if (selectedOption == 0){
            $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = true;
        } else {
            $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = false;
        }
    })
</script>