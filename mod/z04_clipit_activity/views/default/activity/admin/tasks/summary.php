<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$href = elgg_extract('href', $vars);
$users = elgg_extract('users', $vars);
$group_id = elgg_extract('group', $vars);
$tasks = elgg_extract('tasks', $vars);
$tasks = ClipitTask::get_by_id($tasks);
if(!$tasks){
    echo elgg_view('output/empty', array('value' => elgg_echo('tasks:none')));
}
?>
<ul class="content-block">
    <?php
    foreach($tasks as $task):
        $status = get_task_status($task, $group_id);
        $user_tasks = array(
            ClipitTask::TYPE_VIDEO_FEEDBACK,
            ClipitTask::TYPE_FILE_FEEDBACK,
            ClipitTask::TYPE_QUIZ_TAKE,
            ClipitTask::TYPE_RESOURCE_DOWNLOAD
        );
        $locked = false;
        if($task->status == ClipitTask::STATUS_LOCKED){
            $locked = true;
            $user_tasks = array();
        }
        echo elgg_view("page/components/modal_remote", array('id'=> "users-task-{$task->id}-{$group_id}" ));
    ?>
    <li class="list-item content-block" <?php echo $locked ? 'style="opacity: .5;"' : ""; ?>>
        <div class="pull-right margin-left-5 text-muted">
            <?php
            if(in_array($task->task_type, $user_tasks)):
                $completed = 0;
                foreach($users as $user_id){
                    if(ClipitTask::get_completed_status($task->id, $user_id)){
                        $completed++;
                    }
                }
                if($completed == count($users)){
                    $status['icon'] = '<i class="fa fa-check green"></i>';
                }
            ?>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "ajax/view/modal/activity/admin/users_task?id={$task->id}&group_id={$group_id}",
                    'class' => 'btn btn-xs btn-blue-lighter blue pull-left',
                    'style' => 'letter-spacing: 1px;',
                    'text' => '<i class="fa fa-user"></i> '.$completed.'/'.count($users),
                    'data-toggle'   => 'modal',
                    'data-target'   => '#users-task-'.$task->id.'-'.$group_id
                ));
                ?>
                </strong>
            <?php else: // Group task ?>
                <span class="pull-left">
                    <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
                </span>
            <?php endif;?>
            <small style="width: 100px;border-left: 1px solid #ccc" class="margin-left-5 pull-right inline-block text-right">
                <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
                <span class="margin-left-5">
                    <?php echo elgg_view("tasks/icon_task_status", array('status' => $task->status)); ?>
                </span>
            </small>
        </div>
        <div class="text-truncate">
            <?php if($locked):?>
                <span class="text-muted"><?php echo $task->name; ?></span>
            <?php else: ?>
                <?php echo $status['icon']; ?>
                <?php echo elgg_view('output/url', array(
                    'href' => "{$href}/view/{$task->id}#{$group_id}",
                    'title' => $task->name,
                    'text' => $task->name,
                    'is_trusted' => true,
                ));
                ?>
            <?php endif; ?>
        </div>
    </li>
    <?php endforeach;?>
</ul>