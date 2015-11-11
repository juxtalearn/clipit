<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/06/14
 * Last update:     9/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$task = elgg_extract('entity', $vars);
$status = elgg_extract('status', $vars);
$super_title = elgg_extract('super_title', $vars);
$user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
?>
<div class="task-info">
    <?php if(hasTeacherAccess($user->role)):?>
        <?php echo elgg_view('output/url', array(
            'href' => "clipit_activity/$task->activity/admin?filter=tasks#edit-task-{$task->id}",
            'title' => elgg_echo('task:edit'),
            'text' => elgg_echo('task:edit'),
            'class' => 'pull-right btn btn-xs btn-border-blue btn-default',
            'target' => '_blank',
        ));
        ?>
    <?php endif;?>
    <h3>
        <span class="task-status <?php echo $status['color'];?> pull-right"><?php echo $status['text'];?></span>
        <?php if($super_title):?>
            <span class="text-muted show"><?php echo $super_title;?></span>
        <?php endif;?>
        <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type, 'size' => false)); ?>
        <?php echo $task->name;?>
    </h3>
    <small class="show details">
        <strong><?php echo elgg_echo('start');?>: </strong>
        <?php echo elgg_view('output/friendlytime', array('time' => $task->start));?>
        <span class="pull-right">
            <strong><?php echo elgg_echo('end');?>: </strong>
            <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
        </span>
    </small>
    <?php if($task->description):?>
    <div class="description">
        <?php echo nl2br($task->description);?>
    </div>
    <?php endif;?>
</div>

<div class="task-body">
    <?php echo $vars['body']; ?>
</div>