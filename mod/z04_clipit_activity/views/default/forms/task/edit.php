<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task = elgg_extract('entity', $vars);
$activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
$body .= '
<script>
$(".datepicker").datepicker({
    minDate: "'.date("d/m/Y", $activity->start).'",
    maxDate: "'.date("d/m/Y", $activity->end).'"
});
</script>
';
$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $task->id,
));
$task_type = 'upload';

$feedback_check = ClipitTask::get_child($task->id) == 0 ? true : false;
if($task->parent_task){
    $task_type = 'feedback';
}
$id = uniqid();
//$body .= elgg_view('activity/create/task', array('task_type' => $task_type, 'id' => $id, 'task' => $task));
switch($task->task_type){
    case ClipitTask::TYPE_STORYBOARD_UPLOAD:
        $feedback_option = ClipitTask::TYPE_STORYBOARD_FEEDBACK;
        break;
    case ClipitTask::TYPE_VIDEO_UPLOAD:
        $feedback_option = ClipitTask::TYPE_VIDEO_FEEDBACK;
        break;
}
$body .='
<li class="list-item col-md-12 task">
    '.elgg_view('activity/create/task', array('task_type' => $task_type, 'feedback_check' => $feedback_check, 'id' => $id, 'task' => $task)).'
    <ul class="feedback_form" style="margin-left: 20px;display: none">
        <li style="padding: 10px;background: #fafafa;" class="col-md-12">
            <div class="col-md-12">
                <h4>Feedback task</h4>
            </div>
            '.elgg_view('activity/create/task', array('task_type' => 'feedback', 'id' => $id, 'default_task' => $feedback_option)).'
        </li>
    </ul>
</li>';
echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "edit-task-{$task->id}",
        "title"     => elgg_echo("task:edit"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('update'),
                'class' => "btn btn-primary"
            ))
    ));
?>