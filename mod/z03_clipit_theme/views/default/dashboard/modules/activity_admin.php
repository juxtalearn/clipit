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
$entities = elgg_extract('entities', $vars);
$activities = ClipitActivity::get_by_id($entities);
// debug
$activities = ClipitActivity::get_by_id(array(3926));
?>
<style>
.panel-blue > .panel-heading{
    background: transparent;
    padding: 0;
}
.panel-blue .panel-body{
    padding: 5px;
}
.panel-blue{
    border-bottom: 2px solid #bae6f6 !important;
}
</style>
<div class="wrapper">
<?php
foreach($activities as $activity):
    $tasks = ClipitTask::get_by_id($activity->task_array);
?>
    <h4><?php echo $activity->name;?></h4>
    <ul class="panel-group" id="accordion">
    <?php
    foreach($tasks as $task):
//        $users_completed = count($task->storyboard_array)."/".count($activity->group_array);
//        $task_progress = (count($task->storyboard_array)/count($activity->group_array)) * 100;
//        $completed_count = get_task_completed_count($task);
//        $progress_color = "blue";
//        if($completed_count['count'] > 50 ){
//            $progress_color = "yellow";
//            if($completed_count['count'] == 100){
//                $progress_color = "green";
//            }
//        }
    ?>
        <li class="panel panel-blue list-item-5">
            <div class="panel-heading" style="cursor: pointer" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $task->id;?>">
                <i class="blue-lighter fa fa-chevron-down pull-right"></i>
                <small class="pull-right hide">
                    <div class="progressbar-mini progressbar-blue inline-block">
                        <div class="<?php echo $progress_color;?>" data-value="<?php echo $completed_count['count'];?>" style="width: <?php echo $completed_count['count'];?>%"></div>
                    </div>
                    <strong class="inline-block blue margin-left-5"><?php echo $completed_count['text'];?></strong>
                </small>
                <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>
                <span class="blue"><?php echo $task->name;?></span>
            </div>
            <div id="collapse_<?php echo $task->id;?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <hr class="margin-0 margin-bottom-10">
                    <?php
                    switch($task->task_type):
                        case ClipitTask::TYPE_VIDEO_UPLOAD:
                            echo elgg_view('dashboard/modules/activity_admin/video_upload', array('entities' => $task->video_array));
                            break;
                        case ClipitTask::TYPE_STORYBOARD_UPLOAD:
                            echo elgg_view('dashboard/modules/activity_admin/storyboard_upload',
                                array(
                                    'groups' => $activity->group_array,
                                    'task' => $task
                                ));
                            break;
                    endswitch;
                    ?>
                </div>
            </div>
        </li>


    <?php endforeach;?>
    </ul>
<?php endforeach;?>
</div>