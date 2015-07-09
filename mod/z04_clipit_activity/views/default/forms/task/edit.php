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
$params = array();
$id = uniqid();
$body = "
<script>
$('.datepicker').datetimepicker(clipit.datetimepickerDefault({
    minDate: '".date("d/m/y", $activity->start)."',
    maxDate: '".date("d/m/y", $activity->end)."'
}));
</script>
";
$body .= elgg_view("input/hidden", array(
    'name' => 'task-id',
    'value' => $task->id,
));
$task_type = 'upload';

$feedback_check = false;
if(ClipitTask::get_child_task($task->id) == 0 && $task->task_type != ClipitTask::TYPE_QUIZ_TAKE && $task->task_type != ClipitTask::TYPE_OTHER){
    $feedback_check = true;
}
if($task->parent_task){
    $task_type = 'feedback';
}elseif($task->task_type == ClipitTask::TYPE_RESOURCE_DOWNLOAD){
    $task_type = 'download';
    $feedback_check = false;
    $resources = array_merge(
        ClipitTask::get_videos($task->id),
        ClipitTask::get_files($task->id)
    );
    $params = array(
        'entity' => array(
            'class' => 'show',
            'selected' => json_encode($resources),
        )
    );
}elseif($task->task_type == ClipitTask::TYPE_QUIZ_TAKE){

}

//$body .= elgg_view('activity/create/task', array('task_type' => $task_type, 'id' => $id, 'task' => $task));
switch($task->task_type){
    case ClipitTask::TYPE_FILE_UPLOAD:
        $feedback_option = ClipitTask::TYPE_FILE_FEEDBACK;
        break;
    case ClipitTask::TYPE_VIDEO_UPLOAD:
        $feedback_option = ClipitTask::TYPE_VIDEO_FEEDBACK;
        break;
}

$defaults = array(
    'task_type' => $task_type,
    'feedback_check' => $feedback_check,
    'id' => $id,
    'task' => $task
);
$params = array_merge($defaults, $params);
$body .='
<li class="list-item col-md-12 task">
    '.elgg_view('activity/create/task', $params);
if($task_type == 'upload' && $feedback_check){
$body .= '<ul class="feedback_form" style="margin-left: 20px;display: none">
        <li style="padding: 10px;background: #fafafa;" class="col-md-12">
            <div class="col-mds-12">
                <h4>'.elgg_echo('task:feedback').'</h4>
            </div>
            '.elgg_view('activity/create/task', array('task_type' => 'feedback', 'id' => $id, 'default_task' => $feedback_option)).'
        </li>
    </ul>';
}
$body .= '</li>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "edit-task-{$task->id}",
        "title"     => elgg_echo("task:edit"),
        "form"      => true,
        "body"      => $body,
        "footer" =>  elgg_view('output/url', array(
            'href'  => "action/task/remove?id=".$task->id,
            'is_action' => true,
            'class' => 'btn btn-primary btn-danger remove btn-border-red pull-left',
            'title' => elgg_echo('delete'),
            'text'  => '<i class="fa fa-times"></i> '.elgg_echo('delete'),
        )),
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('save'),
                'class' => "btn btn-primary"
            ))
    ));
?>