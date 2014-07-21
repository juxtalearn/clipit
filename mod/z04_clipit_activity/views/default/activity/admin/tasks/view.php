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
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2014-06-12',
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: '2014-06-01'
            },
            {
                title: 'Long Event',
                start: '2014-06-07',
                end: '2014-06-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2014-06-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2014-06-16T16:00:00'
            },
            {
                title: 'Meeting',
                start: '2014-06-12T10:30:00',
                end: '2014-06-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2014-06-12T12:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2014-06-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2014-06-28'
            }
        ]
    });

});
</script>
<div id='calendar'></div>
<ul>
<?php foreach($tasks as $task):?>
    <li class="list-item">
        <span class="blue-lighter margin-right-5">
            <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
        </span>
        <?php echo elgg_view('output/url', array(
            'text' => $task->name,
            'href' => "clipit_activity/{$activity->id}/tasks/view/{$task->id}",
        ));
        ?>
    </li>
<?php endforeach;?>
</ul>
<div class="row" style="display: none">
    <ul class="task-list">
        <?php echo elgg_view('activity/create/task_list');?>
    </ul>
</div>