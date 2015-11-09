<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activities = elgg_extract('entities' ,$vars);
$task_found = false;
?>
<ul class="separator wrapper-list">
<?php
$all_tasks = array();
foreach($activities as $activity){
    $all_tasks = array_merge($all_tasks, $activity->task_array);
}

$tasks = ClipitTask::get_by_id($all_tasks, 0, 0, 'end');
foreach($tasks as $task):
    $status = get_task_status($task);
    if($task->start <= time() && $task->end >= time() && $status['status'] === false):
        $task_found = true;
        $activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
?>
    <li class="list-item">
        <small class="pull-right">
            <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
        </small>
        <?php echo elgg_view('output/url', array(
            'href'  => "clipit_activity/{$task->activity}",
            'title' => $activity->name,
            'style' => 'background: #'.$activity->color,
            'aria-label' => $activity->name,
            'class' => 'activity-point',
            'text'  => '',
        ));?>
        <?php echo elgg_view('output/url', array(
            'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}",
            'title' => $task->name,
            'text'  => $status['count']." ".$task->name,
        ));?>
    </li>
<?php
    endif;
endforeach;
    if(!$task_found): ?>
        <li class="list-item">
            <small><strong><?php echo elgg_echo('task:not_actual');?></strong></small>
        </li>
    <?php endif; ?>
</ul>