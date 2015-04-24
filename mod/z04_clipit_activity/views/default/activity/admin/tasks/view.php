<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$tasks = ClipitTask::get_by_id($activity->task_array, 0, 0, 'start');
elgg_load_js("jquery:timepicker");
elgg_load_js("fullcalendar:moment");
elgg_load_js("fullcalendar");
elgg_load_css("fullcalendar");
elgg_load_js("jquery:dynatable");
$id = uniqid();
?>
<script>
    $(function() {
        // Task views
        $(".button-view-as").click(function(){
            $(".view-element").hide();
            $(".view-element[data-view="+$(this).attr('id')+"]").show();
            $(this).toggleClass(function(){
                $(this).parent('div').find('a').removeClass('active');
                return 'active';
            });
        });
        $(".datepicker").each(function() {
            var defaults = {hour: 0, minute: 0};
            if($(this).hasClass('input-task-end')){
                defaults = {hour: 23, minute: 45};
            }
            $(this).datetimepicker(clipit.datetimepickerDefault(
                $.extend(defaults, {
                    minDate: "<?php echo date("d/m/y", $activity->start);?>",
                    maxDate: "<?php echo date("d/m/y", $activity->end);?>",
                    timeText: "<?php echo elgg_echo('time');?>",
                    closeText: "<?php echo elgg_echo('ok');?>"
                })
            ));
        });
        $('#full-calendar').fullCalendar(clipit.task.admin.fullCalendar({
            messages: {
                monthNames: <?php echo elgg_echo('calendar:month_names');?>,
                monthNamesShort: <?php echo elgg_echo('calendar:month_names_short');?>,
                dayNames: <?php echo elgg_echo('calendar:day_names');?>,
                dayNamesShort: <?php echo elgg_echo('calendar:day_names_short');?>,
                buttonText: {
                    month: "<?php echo elgg_echo('calendar:month');?>",
                    week: "<?php echo elgg_echo('calendar:week');?>",
                    day: "<?php echo elgg_echo('calendar:day');?>",
                    list: "<?php echo elgg_echo('calendar:agenda');?>"
                }
            },
            events: [
                <?php foreach($tasks as $task):?>
                {
                    id: "<?php echo $task->id;?>",
                    title: "<?php echo $task->name;?>",
                    start: "<?php echo date("Y-m-d",$task->start);?>T10:00:00",
                    end: "<?php echo date("Y-m-d",$task->end);?>T10:00:00",
                    icon: <?php echo json_encode(elgg_view("tasks/icon_task_type", array('type' => $task->task_type))); ?>
                },
                <?php endforeach;?>
            ],
            start: <?php echo $activity->start;?>,
            end: <?php echo $activity->end;?>,
        }));
    });
</script>
<div class="pull-right">
    <small class="show"><?php echo elgg_echo('view_as');?></small>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'calendar',
        'class' => 'btn btn-xs btn-border-blue active button-view-as',
        'text'  => '<i class="fa fa-calendar"></i> '.elgg_echo('calendar'),
    ));
    ?>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'list',
        'class' => 'btn btn-xs btn-border-blue button-view-as',
        'text'  => '<i class="fa fa-th-list"></i> '.elgg_echo('list'),
    ));
    ?>
</div>

<button type="button" data-toggle="modal" data-target="#create-new-task" class="btn btn-default margin-top-10">
    <?php echo elgg_echo('task:create'); ?>
</button>
<hr>
<!-- Calendar view -->
<div id="full-calendar" class="view-element" data-view="calendar"></div>

<?php
echo elgg_view_form('task/save', array(
    'body' => elgg_view('forms/task/create', array('entity'  => $activity, 'id' => $id)),
    'data-validate'=> "true",
    'enctype' => 'multipart/form-data'
));
?>
<div class="margin-bottom-20 view-element" data-view="list" style="display: none"></div>
<ul>
    <?php
    foreach($tasks as $task):
        // Task edit (modal remote)
        echo '<li>'.elgg_view("page/components/modal_remote", array('id'=> "edit-task-{$task->id}" )).'</li>';
    ?>
        <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task));?>
    <?php endforeach;?>
</ul>