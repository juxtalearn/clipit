<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task = elgg_extract('task', $vars);
$feedback_task = elgg_extract('feedback_task', $vars);
$task_type = 'upload';
if($feedback_task){
    $task_type = 'feedback';
}
?>
<li data-view="list" style="display: none;" class="view-element list-item <?php echo $feedback_task ? 'margin-left-10' : '';?>">
    <div class="pull-right">
        <?php echo elgg_view('output/url', array(
            'href'  => "action/task/remove?id={$task->id}",
            'class' => 'btn btn-xs btn-danger remove remove-object',
            'is_action' => true,
            'title' => elgg_echo('delete'),
            'text'  => '<i class="fa fa-times"></i> '.elgg_echo('delete'),
        ));
        ?>
    </div>
    <div>
        <?php if($feedback_task): ?>
            <i class="fa fa-level-up text-muted-2 fa-rotate-90 margin-right-10 pull-left" style="font-size: 21px;margin-right: 10px;"></i>
            <small class="show"><?php echo elgg_echo('task:feedback');?></small>
        <?php endif; ?>
        <div class="image-block fa-2x">
            <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type, 'size' => false)); ?>
        </div>
        <div class="content-block">
            <span class="blue-lighter margin-right-5">
                <?php echo elgg_view("tasks/icon_user_type", array('type' => $task->task_type)); ?>
            </span>
            <strong>
                <?php echo elgg_view('output/url', array(
                    'text' => $task->name,
                    'href'  => "ajax/view/modal/task/edit?id={$task->id}",
                    'title' => elgg_echo('edit'),
                    'data-toggle'   => 'modal',
                    'data-target'   => '#edit-task-'.$task->id
                ));
                ?>
            </strong>
            <small class="show">
                <strong><?php echo elgg_echo('start');?>: </strong>
                <?php echo elgg_view('output/friendlytime', array('time' => $task->start));?>,
                <strong><?php echo elgg_echo('end');?>: </strong>
                <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
            </small>
        </div>
    </div>
</li>