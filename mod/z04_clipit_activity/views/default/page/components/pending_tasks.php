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
$activity = elgg_extract('entity', $vars);
?>
<ul>
<?php
$task_found = false;
foreach(ClipitTask::get_by_id($activity->task_array, 0, 0, 'end') as $task):
    $status = get_task_status($task);
    if($task->status == ClipitTask::STATUS_ACTIVE && $status['status'] === false):
        $task_found = true;
        ?>
        <li class="list-item">
            <small class="pull-right">
                <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
            </small>
            <?php if($vars['show_activity']):?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}",
                    'title' => $activity->name,
                    'style' => 'background: #'.$activity->color,
                    'aria-label' => $activity->name,
                    'class' => 'activity-point',
                    'text'  => '',
                )); ?>
            <?php endif; ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}",
                'title' => $task->name,
                'text'  => elgg_view("tasks/icon_task_type", array('type' => $task->task_type)) . $status['count']." ".$task->name,
            ));
            ?>
        </li>
    <?php
    endif;
endforeach;

if(!$task_found): ?>
    <small><strong><?php echo elgg_echo('task:not_actual');?></strong></small>
<?php endif; ?>
</ul>