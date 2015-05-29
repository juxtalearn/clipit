<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/02/2015
 * Last update:     17/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$students = elgg_extract('entities', $vars);
$task = elgg_extract('task', $vars);
?>
<ul class="row">
    <?php foreach($students as $student):?>
    <li class="list-item col-md-6" data-entity="<?php echo $student->id;?>">
        <div class="pull-right">
            <?php if(ClipitTask::get_completed_status($task->id, $student->id)):?>
                <i class="fa fa-check green" title="<?php echo elgg_echo('task:completed');?>"></i>
            <?php elseif($task->status == ClipitTask::STATUS_ACTIVE):?>
                <i class="fa fa-minus yellow" title="<?php echo elgg_echo('task:pending');?>"></i>
            <?php else: ?>
                <i class="fa fa-times red"></i>
            <?php endif;?>
        </div>
        <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
    </li>
    <?php endforeach;?>
</ul>