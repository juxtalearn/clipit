<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/06/14
 * Last update:     9/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('activity', $vars);
$tasks = elgg_extract('tasks', $vars);
$href = elgg_extract('href', $vars);
if(!$tasks){
    echo elgg_view('output/empty', array('value' => elgg_echo('tasks:none')));
}
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$individual_tasks = array(
    ClipitTask::TYPE_FILE_FEEDBACK,
    ClipitTask::TYPE_VIDEO_FEEDBACK,
    ClipitTask::TYPE_RESOURCE_DOWNLOAD,
    ClipitTask::TYPE_QUIZ_TAKE
);
?>
<ul class="deadline-list">
    <?php
    foreach($tasks as $task):
        $status = get_task_status($task);
        $access = true;
        if( time() < $task->start && $user->role == ClipitUser::ROLE_STUDENT ) {
            $access = false;
        } elseif(isset($activity)) {
            if ($activity->is_open && !in_array($user_id, $activity->student_array)) {
                $access = false;
            }
        }
    ?>
    <li class="overflow-hidden list-item <?php echo $access ? "" : "soon"; ?>">
        <div class="image-block hidden-xs">
            <small class="date show" style="text-transform: uppercase">
                <span><?php echo date("d M Y", $task->start);?></span><br>
                <span><?php echo date("d M Y", $task->end);?></span>
            </small>
        </div>
        <div class="content-block">
            <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>
            <div class="pull-right hidden-xs">
                <?php if(hasTeacherAccess($user->role)):?>
                    <?php echo elgg_view('output/url', array(
                        'href' => "clipit_activity/$task->activity/admin?filter=tasks#edit-task-{$task->id}",
                        'title' => elgg_echo('task:edit'),
                        'text' => elgg_echo('task:edit'),
                        'class' => 'btn btn-xs btn-border-blue btn-default margin-right-10',
                        'target' => '_blank',
                    ));
                    ?>
                <?php endif;?>
                <span class="blue-lighter margin-right-10">
                    <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
                </span>
                <span>
                    <?php echo elgg_view("tasks/icon_task_status", array('status' => $task->status)); ?>
                </span>
            </div>
            <strong>
            <?php if($access): ?>
                <?php echo elgg_view('output/url', array(
                    'href' => "{$href}/view/{$task->id}",
                    'title' => $task->name,
                    'text' => $task->name,
                    'is_trusted' => true,
                ));
                ?>
            <?php else: ?>
                <span><?php echo $task->name; ?></span>
            <?php endif; ?>
            </strong>
            <?php if($access): ?>
            <small class="show <?php echo $status['color']; ?>">
                <?php echo $status['text']; ?>
            </small>
            <?php endif; ?>
        </div>
    </li>
    <?php endforeach; ?>
</ul>