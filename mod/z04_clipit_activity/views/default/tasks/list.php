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
$tasks = elgg_extract('tasks', $vars);
$href = elgg_extract('href', $vars);
if(!$tasks){
    echo elgg_view('output/empty', array('value' => elgg_echo('tasks:none')));
}

$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
?>
<ul class="deadline-list">
    <?php foreach($tasks as $task):
    $status = get_task_status($task);
    ?>
    <li class="overflow-hidden list-item <?php echo (time() < $task->start && $user->role == ClipitUser::ROLE_STUDENT) ? "soon" : ""; ?>">
        <div class="image-block">
            <small class="date show" style="text-transform: uppercase">
                <?php if($user->role == ClipitUser::ROLE_TEACHER):?>
                    <span><?php echo date("d M Y", $task->start);?></span><br>
                <?php endif;?>
                <span><?php echo date("d M Y", $task->end);?></span>
            </small>
        </div>
        <div class="content-block">
            <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>
            <div class="pull-right">
                <span class="margin-right-10">
                    <?php echo elgg_view("tasks/icon_task_status", array('status' => $task->status)); ?>
                </span>
                <span class="blue-lighter">
                    <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
                </span>
            </div>
            <strong>
            <?php if(time() > $task->start || $user->role == ClipitUser::ROLE_TEACHER): ?>
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
            <small class="show <?php echo $status['color']; ?>">
                <?php echo $status['text']; ?>
            </small>
        </div>
    </li>
    <?php endforeach; ?>
</ul>