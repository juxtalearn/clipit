<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   15/07/2015
 * Last update:     15/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = elgg_extract('id', $vars);
$entity = elgg_extract('entity', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
$task_type = ClipitTask::TYPE_QUIZ_TAKE;
?>
<div class="task-advanced-options margin-top-15" style="display: <?php echo $entity->task_type==$task_type ? 'block':'none';?>" data-options="<?php echo $task_type;?>">
    <!-- Advanced options -->
    <a class="blue show" data-toggle="collapse" href="#options-<?php echo $id;?>">
        <i class="fa fa-angle-down pull-right"></i>
        <i class="fa fa-cog"></i> <strong><?php echo elgg_echo('options:advanced');?></strong>
    </a>
    <hr class="margin-top-5 margin-bottom-10">
    <div class="collapse task-advanced-options-collapse" id="options-<?php echo $id;?>">
        <div>
            <label><?php echo elgg_echo('quiz:options:results_after_finished');?></label>
            <small>(<?php echo elgg_echo('quiz:options:results_after_finished:info');?>)</small>
            <div>
                <label style="font-weight: normal;" class="inline-block margin-right-5">
                    <input type="radio"
                           name="task<?php echo $input_prefix;?>[results_after_finished]"
                        <?php echo $entity->results_after_finished ? 'checked':'';?>
                           value="1">
                    <?php echo elgg_echo('input:yes');?>
                </label>
                <label style="font-weight: normal;" class="inline-block">
                    <input type="radio"
                           name="task<?php echo $input_prefix;?>[results_after_finished]"
                        <?php echo !$entity->results_after_finished ? 'checked':'';?>
                           value="0">
                    <?php echo elgg_echo('input:no');?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('quiz:options:random');?></label>
            <div>
                <label style="font-weight: normal;" class="inline-block margin-right-5">
                    <input type="radio"
                           name="task<?php echo $input_prefix;?>[quiz_random_order]"
                        <?php echo $entity->quiz_random_order ? 'checked':'';?>
                           value="1">
                    <?php echo elgg_echo('input:yes');?>
                </label>
                <label style="font-weight: normal;" class="inline-block">
                    <input type="radio"
                           name="task<?php echo $input_prefix;?>[quiz_random_order]"
                        <?php echo !$entity->quiz_random_order ? 'checked':'';?>
                           value="0">
                    <?php echo elgg_echo('input:no');?>
                </label>
            </div>
        </div>
    </div>
</div>
