<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;

$activities = ClipitActivity::get_all();
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
if (is_null($activity_id)||empty($activity_id)){
  $group_options = LADashboardHelper::getGroupBundlePHP($activity_id);
    $group_disabled = false;
} else {
    $group_disabled = true;
    $group_options = LADashboardHelper::getGroupBundlePHP(null);
}

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
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled = false
    });

    $('<?php echo "#activity_dropdown-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled=false
        var activityId = document.getElementById('<?php echo "activity_dropdown-$widget_id" ?>').selectedOptions[0].value
        document.getElementById('<?php echo "group_dropdown-$widget_id" ?>').disabled = true;
        $('<?php echo "#group_dropdown-$widget_id" ?> option').remove()
        elgg.get('ajax/view/metrics/get_groups', {
            data: {
                id: activityId
            },
            success: function (data) {
                var quiz_array = JSON.parse(data);
                var currentGroups = document.getElementById('<?php echo "group_dropdown-$widget_id" ?>');

                for (i = 0; i < quiz_array.length; i++) {
                    if (quiz_array[i].id == 0) {
                        var  newOption = new Option(quiz_array[i].name, quiz_array[i].id, true, true);
                    } else {
                        var newOption = new Option(quiz_array[i].name, quiz_array[i].id, false, false);
                    }
                    currentGroups = document.getElementById('<?php echo "group_dropdown-$widget_id" ?>');
                    currentGroups.options[currentGroups.options.length] = newOption;
                }
                currentGroups.disabled = false;
                currentGroups.style.visibility = 'visible';
            }
        });
    });
</script>