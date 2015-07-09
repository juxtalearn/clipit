<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   08/07/2015
 * Last update:     08/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$selected = elgg_extract('selected', $vars);
$input_array = elgg_extract('input_array', $vars);
$task_type = ClipitTask::TYPE_OTHER;
?>
<?php if($entity->task_type == $task_type || !$entity):?>
<div class="col-md-3 margin-bottom-10">
    <div class="thumbnail cursor-pointer <?php echo $entity->task_type == $task_type?'active':'';?>" data-task-type="<?php echo $task_type;?>">
        <span class="task-icon blue-lighter fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-question fa-stack-1x fa-inverse"></i>
        </span>
        <div class="task-title blue"><?php echo elgg_echo('task:other');?></div>
        <?php if(!$entity):?>
        <label class="cursor-pointer">
            <input type="radio"
                   id="task<?php echo $input_array;?>[type]"
                   name="task<?php echo $input_array;?>[type]"
                   value="<?php echo $task_type;?>"
                   required="true"
                   <?php echo $entity->task_type == $task_type?'checked':false;?>
                   class="hidden hidden-validate"/>
        </label>
        <?php endif;?>
    </div>
</div>
<?php endif;?>