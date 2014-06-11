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
$activity_id = elgg_extract('activity_id', $vars);
if(!$tasks){
    echo elgg_view('output/empty', array('value' => elgg_echo('tasks:none')));
}
?>
<ul class="deadline-list">
    <?php foreach($tasks as $task_id):
    $task = array_pop(ClipitTask::get_by_id(array($task_id)));
    $status = get_task_status($task, $activity_id);
    ?>
    <li <?php echo (time() < $task->start) ? "class='soon'" : ""; ?> style="overflow: hidden;">
        <div class="image-block">
            <small class="date show" style="text-transform: uppercase">
                <span class="pull-right" style="margin-left: 10px;"><?php echo date("d M Y", $task->start);?></span>
            </small>
            <small class="date show" style="text-transform: uppercase">
                <span class="pull-right" style="margin-left: 10px;"><?php echo date("d M Y", $task->end);?></span>
            </small>
        </div>
        <div class="content-block">
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
            <span class="pull-right blue">
                <?php echo elgg_view("tasks/type_icon", array('type' => $task->task_type)); ?>
            </span>
            <small class="show <?php echo $status['color']; ?>">
                <?php echo $status['text']; ?>
            </small>
        </div>
    </li>
    <?php endforeach; ?>
</ul>