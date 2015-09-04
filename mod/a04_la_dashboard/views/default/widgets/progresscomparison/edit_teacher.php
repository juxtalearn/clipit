<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;

//$activities = ClipitActivity::get_all();
$activities = ClipitActivity::get_from_user(elgg_get_logged_in_user_guid());
$activity_options = array(0 => elgg_echo('la_dashboard:widget:quizresult:selectactivity'));
foreach ($activities as $activity) {
    $activity_options[$activity->id] = $activity->name;
}

$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[activity_id]',
    'value' => $vars['entity']->activity_id,
    'options_values' => $activity_options,
    'id' => "activity_dropdown-$widget_id",
    'required' => true,
);
$activity_dropdown = elgg_view('input/dropdown', $params);


$activity_id = $vars['entity']->activity_id;
//if (is_null($activity_id) || empty($activity_id)) {
$group_options = LADashboardHelper::getGroupBundlePHP($activity_id);
//    $group_disabled = false;
//} else {
//    $group_disabled = true;
//    $group_options = LADashboardHelper::getGroupBundlePHP(null);
//}
$group_disabled = is_null($activity_id) || empty($activity_id);

$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[group_id]',
    'value' => $vars['entity']->group_id,
    'options_values' => $group_options,
    'disabled' => $group_disabled,
    'id' => "group_dropdown-$widget_id",
    'required' => false,
);

$group_dropdown = elgg_view('input/dropdown', $params);

?>
<p>
    <?php echo elgg_echo('activity'); ?>:
    <?php echo $activity_dropdown ?>
</p>

<p>
    <?php echo elgg_echo('group'); ?>:
    <?php echo $group_dropdown ?>
</p>
<script>

    $('<?php echo "#group_dropdown-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled = $(this).val() == 0;
    });

    $('<?php echo "#activity_dropdown-$widget_id" ?>').change(function () {
        var activityId = $('<?php echo "#activity_dropdown-$widget_id" ?>').find(':selected').val();
        var validActivityId = activityId != 0;
        document.getElementById('<?php echo "group_dropdown-$widget_id" ?>').disabled = true;
        $('<?php echo "#group_dropdown-$widget_id" ?> option').remove();
        elgg.get('ajax/view/metrics/get_groups', {
            data: {
                id: activityId
            },
            success: function (data) {
                var group_array = JSON.parse(data);
                var currentGroups = document.getElementById('<?php echo "group_dropdown-$widget_id" ?>');

                for (i = 0; i < group_array.length; i++) {
                    if (group_array[i].id == 0) {
                        var newOption = new Option(group_array[i].name, group_array[i].id, true, true);
                    } else {
                        var newOption = new Option(group_array[i].name, group_array[i].id, false, false);
                    }
                    currentGroups = document.getElementById('<?php echo "group_dropdown-$widget_id" ?>');
                    currentGroups.options[currentGroups.options.length] = newOption;
                }
                currentGroups.disabled = !validActivityId;
                currentGroups.style.visibility = 'visible';
            }
        });
        $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = true;
    });
    $(document).ready(function () {
        var activityId = $('<?php echo "#activity_dropdown-$widget_id" ?>').find(':selected').val();
        $('<?php echo "#widget-edit-$widget_id" ?>').find('.elgg-button-submit')[0].disabled = activityId == 0;
    });
</script>