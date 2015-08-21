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

$task_options = LADashboardHelper::getQuizTasksPHP($vars['entity']->activity_id);
$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[task_id1]',
    'value' => $vars['entity']->task_id1,
    'options_values' => $task_options,
    'disabled' => !(count($task_options)>1),
    'id' => "task_dropdown1-$widget_id",
    'required' => true,
);

$task_dropdown1 = elgg_view('input/dropdown', $params);

$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[task_id2]',
    'value' => $vars['entity']->task_id2,
    'options_values' => $task_options,
    'disabled' => !(count($task_options)>1),
    'id' => "task_dropdown2-$widget_id",
    'required' => true,
);

$task_dropdown2 = elgg_view('input/dropdown', $params);


$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[scale]',
    'value' => $vars['entity']->scale,
    'options_values' => array(ClipitActivity::SUBTYPE => elgg_echo('activity'), ClipitGroup::SUBTYPE => elgg_echo('group'), ClipitUser::SUBTYPE => elgg_echo('student')),
    'disabled' => false,
    'id' => "scale_dropdown-$widget_id",
    'required' => true,
);
$scale_dropdown = elgg_view('input/dropdown', $params);


if (isset($vars['entity']->scale) && $vars['entity']->scale == ClipitGroup::SUBTYPE) {
    $target_options = LADashboardHelper::getGroupBundlePHP($vars['entity']->activity_id, false);
    $target_disabled = false;

} else if (isset($vars['entity']->scale) && $vars['entity']->scale == ClipitUser::SUBTYPE) {
    $target_options = LADashboardHelper::getUserBundlePHP($vars['entity']->activity_id);
    $target_disabled = false;
} else {
    $target_disabled = true;
    $target_options = LADashboardHelper::getUserBundlePHP(null);
}
$params = array(
    'class' => "form-control available-metrics-$widget_id",
    'style' => 'padding-top: 5px;padding-bottom: 5px;',
    'name' => 'params[target_id]',
    'value' => $vars['entity']->target_id,
    'options_values' => $target_options,
    'disabled' => $target_disabled,
    'id' => "target_dropdown-$widget_id",
    'required' => false,
);

$target_dropdown = elgg_view('input/dropdown', $params);

?>
<p>
    <?php echo elgg_echo('activity'); ?>:
    <?php echo $activity_dropdown ?>
</p>

<p>
    <?php echo elgg_echo('quiz'); ?>:
    <?php echo $task_dropdown1 ?>
</p>

<p>
    <?php echo elgg_echo('quiz'); ?>:
    <?php echo $task_dropdown2 ?>
</p>

<p>
    <?php echo elgg_echo('scope'); ?>:
    <?php echo $scale_dropdown ?>
</p>

<p>
    <?php echo elgg_echo('group'); ?>:
    <?php echo $target_dropdown ?>
</p>

<script>

    $('<?php echo "#target_dropdown-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled = false
    })

    $('<?php echo "#task_dropdown1-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled = false
    })
    $('<?php echo "#task_dropdown2-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled = false
    })


    $('<?php echo "#activity_dropdown-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled=false
        var activityId = document.getElementById('<?php echo "activity_dropdown-$widget_id" ?>').selectedOptions[0].value
        document.getElementById('<?php echo "task_dropdown1-$widget_id" ?>').disabled = true;
        $('<?php echo "#task_dropdown1-$widget_id" ?> option').remove();
        document.getElementById('<?php echo "task_dropdown2-$widget_id" ?>').disabled = true;
        $('<?php echo "#task_dropdown2-$widget_id" ?> option').remove();

        elgg.get('ajax/view/metrics/get_quiztasks', {
            data: {
                id: activityId
            },
            success: function (data) {
                var quiz_array = JSON.parse(data);
                var currentTasks1 = document.getElementById('<?php echo "task_dropdown1-$widget_id" ?>');

                var currentTasks2 = document.getElementById('<?php echo "task_dropdown2-$widget_id" ?>');

                for (i = 0; i < quiz_array.length; i++) {
                    if (quiz_array[i].id == 0) {
                        var newOption = new Option(quiz_array[i].name, quiz_array[i].id, true, true);
                        currentTasks1.options[currentTasks1.options.length] = newOption;
                        newOption = new Option(quiz_array[i].name, quiz_array[i].id, true, true);
                        currentTasks2.options[currentTasks2.options.length] = newOption;
                    } else {
                        var newOption = new Option(quiz_array[i].name, quiz_array[i].id, false, false);
                        currentTasks1.options[currentTasks1.options.length] = newOption;
                        newOption = new Option(quiz_array[i].name, quiz_array[i].id, false, false);
                        currentTasks2.options[currentTasks2.options.length] = newOption;
                    }

                    document.getElementById('<?php echo "scale_dropdown-$widget_id" ?>').disabled = false;
                }
                document.getElementById('<?php echo "task_dropdown1-$widget_id" ?>').disabled = false;
                document.getElementById('<?php echo "task_dropdown2-$widget_id" ?>').disabled = false;
            }
        });
    })


    $('#<?php echo "scale_dropdown-$widget_id" ?>').change(function () {
        $('#' + this.id).parent().parent().find('.elgg-button-submit')[0].disabled=false;
        if (document.getElementById('<?php echo "scale_dropdown-$widget_id" ?>').selectedOptions[0].value != "<?php echo ClipitActivity::SUBTYPE?>") {
            var activityId = document.getElementById('<?php echo "activity_dropdown-$widget_id" ?>').selectedOptions[0].value;
            var typeId = document.getElementById('<?php echo "scale_dropdown-$widget_id" ?>').selectedOptions[0].value;
            document.getElementById('<?php echo "target_dropdown-$widget_id" ?>').disabled = true;
            $('<?php echo "#target_dropdown-$widget_id" ?> option').remove()
            elgg.get('ajax/view/metrics/get_targets', {
                data: {
                    id: activityId,
                    type: typeId,
                    addAll:0
                },
                success: function (data) {
                    var quiz_array = JSON.parse(data);
                    var currentTarget = document.getElementById('<?php echo "target_dropdown-$widget_id" ?>');

                    for (i = 0; i < quiz_array.length; i++) {
                        if (quiz_array[i].id == 0) {
                            var  newOption = new Option(quiz_array[i].name, quiz_array[i].id, true, true);
                        } else {
                            var newOption = new Option(quiz_array[i].name, quiz_array[i].id, false, false);
                        }
                        currentTarget = document.getElementById('<?php echo "target_dropdown-$widget_id" ?>');
                        currentTarget.options[currentTarget.options.length] = newOption;
                    }
                    currentTarget.disabled = false;
                    currentTarget.style.visibility = 'visible';
                }
            });
        } else {
            document.getElementById('<?php echo "target_dropdown-$widget_id" ?>').disabled = true;
            document.getElementById('<?php echo "target_dropdown-$widget_id" ?>').style.visibility = 'visible';
        }
    })




</script>