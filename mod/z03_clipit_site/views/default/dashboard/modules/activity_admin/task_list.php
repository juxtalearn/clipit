<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task_id = get_input('task_id');
$task = array_pop(ClipitTask::get_by_id(array($task_id)));
$activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
$completed_count = get_task_completed_count($task);
$progress_color = "blue";
if($completed_count['count'] > 50 ){
    $progress_color = "yellow";
    if($completed_count['count'] == 100){
        $progress_color = "green";
    }
}
?>
<div class="task-details">
<small class="margin-bottom-10 show">
    <div class="pull-right margin-top-5">
        <div class="progressbar-mini progressbar-blue inline-block">
            <div class="<?php echo $progress_color;?>" data-value="<?php echo $completed_count['count'];?>" style="width: <?php echo $completed_count['count'];?>%"></div>
        </div>
        <strong class="inline-block blue margin-left-5"><?php echo $completed_count['text'];?></strong>
    </div>
    <div>
        <strong><?php echo elgg_echo('start');?>:</strong>
        <?php echo elgg_view('output/friendlytime', array('time' => $task->start));?>
    </div>
    <div>
        <strong><?php echo elgg_echo('end');?>:</strong>
        <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
    </div>
</small>
<hr class="margin-0 margin-bottom-10">
<ul style="max-height: 300px;overflow-y: auto">
<?php
switch($task->task_type):
    case ClipitTask::TYPE_VIDEO_UPLOAD:
        echo elgg_view('dashboard/modules/activity_admin/video_upload',
            array(
                'groups' => $activity->group_array,
                'task' => $task
            ));
        break;
    case ClipitTask::TYPE_FILE_UPLOAD:
        echo elgg_view('dashboard/modules/activity_admin/file_upload',
            array(
                'groups' => $activity->group_array,
                'task' => $task
            ));
        break;
    case ClipitTask::TYPE_FILE_FEEDBACK:
        echo elgg_view('dashboard/modules/activity_admin/storyboard_feedback',
            array(
                'users' => $activity->student_array,
                'task' => $task
            ));
        break;
    case ClipitTask::TYPE_VIDEO_FEEDBACK:
        echo elgg_view('dashboard/modules/activity_admin/video_feedback',
            array(
                'users' => $activity->student_array,
                'task' => $task
            ));
        break;
    case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
        echo elgg_view('dashboard/modules/activity_admin/resource_download',
            array(
                'users' => $activity->student_array,
                'task' => $task
            ));
        break;
    case ClipitTask::TYPE_QUIZ_TAKE:
        echo elgg_view('dashboard/modules/activity_admin/quiz_take',
            array(
                'task' => $task
            ));
        break;
endswitch;
?>
</ul>
</div>
