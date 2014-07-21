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
$task = elgg_extract('entity', $vars);
$status = elgg_extract('status', $vars);
$super_title = elgg_extract('super_title', $vars);
?>
<style>
.task-info{
    margin-bottom: 15px;
}
.task-info h3{
    margin-top: 0;
}
.task-info .details{
    border-bottom: 1px solid #bae6f6;
    padding-bottom: 5px;
}
.task-info .description{
    color: #666666;
    margin-top: 10px;
    background: #fafafa;
    padding: 10px;
}
</style>
<div class="task-info">
    <h3>
        <span class="<?php echo $status['color'];?> pull-right"><?php echo $status['text'];?></span>
        <?php if($super_title):?>
            <span class="text-muted show"><?php echo $super_title;?></span>
        <?php endif;?>
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
    <div class="description">
        <?php echo $task->description;?>
    </div>
</div>

<div class="task-body">
    <?php echo $vars['body']; ?>
</div>