<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   08/07/2015
 * Last update:     08/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = elgg_extract('id', $vars);
$entity = elgg_extract('entity', $vars);
$input_array = elgg_extract('input_array', $vars);
$rubric_id = uniqid('rubric_');
?>
<?php if($entity->task_type == ClipitTask::TYPE_VIDEO_FEEDBACK || $entity->task_type == ClipitTask::TYPE_FILE_FEEDBACK):?>
    <?php
    if($entity->rubric):
        $rubric = ClipitRubric::get_by_id(array($entity->rubric));
    ?>
        <?php echo elgg_view('forms/rubric/save', array(
        'entity' => array_pop(ClipitRubric::get_by_id(array($entity->rubric))),
        'input_prefix' => 'task'.$input_array,
        'select' => true,
        'pre_populate' => true,
        'unselected' => true
    ));?>
    <?php else: ?>
        <script>
            clipit.task.rubricList( $('#<?php echo $rubric_id;?>').closest('.feedback_task') );
        </script>
    <?php endif;?>
    <div class="clearfix"></div>
<?php endif;?>
<div id="<?php echo $rubric_id;?>" class="rubric-select-list"></div>
