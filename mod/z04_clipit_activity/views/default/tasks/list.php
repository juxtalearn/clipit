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
?>
<ul class="deadline-list">
    <?php foreach($tasks as $task_id):
    $task = array_pop(ClipitTask::get_by_id(array($task_id)));
    $status = get_task_status($task);
    ?>
    <li <?php echo (time() < $task->start) ? "class='soon'" : ""; ?> style="overflow: hidden;">
        <div class="image-block">
            <small class="date show" style="text-transform: uppercase">
                <span><?php echo date("d M Y", $task->start);?></span>
            </small>
            <small class="date show" style="text-transform: uppercase">
                <span><?php echo date("d M Y", $task->end);?></span>
            </small>
        </div>
        <div class="content-block">
            <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>
            <strong>
            <?php if(time() > $task->start): ?>
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
            <span class="pull-right blue-lighter">
                <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
            </span>
            <small class="show <?php echo $status['color']; ?>">
                <?php echo $status['text']; ?>
            </small>
        </div>
    </li>
    <?php endforeach; ?>
</ul>