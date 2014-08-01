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
$tasks = ClipitTask::get_by_id($activity->task_array);
?>
<script src="http://arshaw.com/js/fullcalendar-2.0.2/lib/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.css" type="text/css" />
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

    $('#full-calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventAfterAllRender: function(){
            var content = $(".fc-header-left, .fc-header-right");
            content.find('.fc-header-space').remove();
            content.removeClass().addClass("btn-group btn-group-sm")
                .find('.fc-button').removeClass()
                .addClass("btn btn-default btn-border-blue");
            content.find('.fc-icon-right-single-arrow').removeClass().addClass("fa fa-caret-right")
            content.find('.fc-icon-left-single-arrow').removeClass().addClass("fa fa-caret-left");
            $(".fc-header td:eq(0)").addClass('pull-left');
            $(".fc-header td:eq(2)").addClass('pull-right');
        },
        editable: false,
        events: [
            <?php foreach($tasks as $task):?>
            {
                id: "<?php echo $task->id;?>",
                title: "<?php echo $task->name;?>",
                start: "<?php echo date("Y-m-d",$task->start);?>",
                end: "<?php echo date("Y-m-d",$task->end);?>T10:00:00",
                icon: '<?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>'
            },
            <?php endforeach;?>
        ],
        eventRender: function(event, element) {
            $(element).find(".fc-event-inner").prepend($(event.icon).removeClass('blue').addClass('margin-right-10 margin-left-5'));
        },
        eventClick: function(event, calEvent, jsEvent, view, element) {
            $("[data-target='#edit-task-"+event.id+"']").click();
        },
        dayRender: function(date, cell) {
            var date_formated = date.format("X");
            if(date_formated >= <?php echo $activity->start;?> && date_formated <= <?php echo $activity->end;?> ){
                $(cell).addClass('fc-ranged');
            }
        },
        dayClick: function(date, jsEvent, view) {
            var date_formated = date.format("X");
            if(date_formated >= <?php echo $activity->start;?> && date_formated <= <?php echo $activity->end;?> ){
                $("#create-new-task").modal('show').find(".input-task-start").val(date.format('DD/MM/YYYY'));
            } else {
                return false;
            }
        }
    });
});
</script>
<style>
.delete-task{
    display: none;
}
.fc-event{
    background: #32b4e5;
    border: 1px solid #32b4e5;
}
.fc-event-inner{
    cursor: pointer;
}
.fc-event-time{
    display: none;
}
.fc-event-end{
    padding-left: 10px;
}
.fc-event-end .fa{
    display: none;
}
.fc-event-start{
    padding-left: 0 !important;
}
.fc-event-start .fa{
    display: inline-block !important;
}
.fc-widget-content{
    border: 1px solid #fff !important;
    color: #999;
    background: #fafafa;
}
.fc-ranged{
    color: #32b4e5;
    font-weight: bold;
    background-color: #d6f0fa;
    cursor: pointer;
}
.fc-state-highlight {
    background: #FFF !important;
    border: 3px solid #d6f0fa !important;
}
/*.fc-start:after{*/
    /*content: "Activity start";*/
    /*position: absolute;*/
    /*left: 3px;*/
    /*bottom: 0;*/
    /*font-size: 85%;*/
    /*font-weight: normal;*/
    /*color: #666;*/
    /*text-transform: uppercase;*/
    /*background: #fff;*/
    /*padding: 2px 5px;*/
    /*font-weight: bold;*/
    /*margin: 3px;*/

/*}*/
.fc-ranged.fc-other-month{
    background-color: #F2FBFF;
}
.fc-grid .fc-other-month .fc-day-number{
    opacity: .5;
}
.task-item{
    display: none;
}
</style>
<div>
    <small class="show"><?php echo elgg_echo('view_as');?></small>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'calendar',
        'class' => 'btn btn-xs btn-border-blue active button-view-as',
        'text'  => '<i class="fa fa-calendar"></i> Calendar',
    ));
    ?>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'list',
        'class' => 'btn btn-xs btn-border-blue button-view-as',
        'text'  => '<i class="fa fa-th-list"></i> List',
    ));
    ?>
</div>
<hr>

<!-- Calendar view -->
<div id="full-calendar" class="view-element" data-view="calendar" style="display: nonse;"></div>


<?php echo elgg_view_form('task/create', array('data-validate' => "true" ), array('entity'  => $activity)); ?>
<div class="margin-bottom-20 view-element" data-view="list" style="display: none">
    <button type="button" data-toggle="modal" data-target="#create-new-task" class="btn btn-default">
        <?php echo elgg_echo('task:create'); ?>
    </button>
</div>
<ul>
    <?php
    foreach($tasks as $task):
        // Task edit (modal remote)
        echo '<li>'.elgg_view("page/components/modal_remote", array('id'=> "edit-task-{$task->id}" )).'</li>';

        if(!$task->parent_task):
    ?>
            <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task));?>
            <?php
            if($task_id = ClipitTask::get_child($task->id)):
                $task = array_pop(ClipitTask::get_by_id(array($task_id)));
            ?>
                <?php echo elgg_view('activity/admin/tasks/list', array('task' => $task, 'feedback_task' => true));?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach;?>
</ul>