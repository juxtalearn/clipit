<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$tasks = elgg_extract('tasks', $vars);
?>
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
    $(".datepicker").each(function(){
        $(this).datepicker({
            minDate: "<?php echo date("d/m/Y", $activity->start);?>",
            maxDate: "<?php echo date("d/m/Y", $activity->end);?>"
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
                icon: <?php echo json_encode(elgg_view("tasks/icon_task_type", array('type' => $task->task_type))); ?>
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
//            var date_formated = date.format("X");
            var date_formated = date.add(-2, 'hours').format("X"); // Added -2hours T00:00:00
            if(date_formated >= <?php echo $activity->start;?> && date_formated <= <?php echo $activity->end;?> ){
                $(cell).addClass('fc-ranged');
            }
        },
        dayClick: function(date, jsEvent, view) {
//            var date_formated = date.format("X");
            var date_formated = date.add(-2, 'hours').format("X"); // Added -2hours T00:00:00
            if(date_formated >= <?php echo $activity->start;?> && date_formated <= <?php echo $activity->end;?> ){
                $("#create-new-task").modal('show').find(".input-task-start").val(date.format('DD/MM/YYYY'));
            } else {
                return false;
            }
        }
    });
});

