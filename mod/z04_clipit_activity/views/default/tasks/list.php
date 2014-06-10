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
    ?>
    <li <?php time() < $task->start ? "soon" : ""; ?>>
        <small class="date" style="text-transform: uppercase"><?php echo date("d M Y", $task->end);?></small>
        <strong>
        <?php if(time() > $task->start): ?>
            <?php echo elgg_view('output/url', array(
                'href' => "{$href}/view/{$task->id}",
                'title' => $task->name,
                'text' => $task->name,
                'is_trusted' => true,
                ));
            ?>
        </strong>
        <?php else: ?>
            <span><?php echo $task->name; ?></span>
        <?php endif; ?>
        <span class="pull-right">
            <?php echo elgg_view("tasks/type_icon", array('type' => $task->task_type)); ?>
        </span>
    </li>
    <?php endforeach; ?>
</ul>