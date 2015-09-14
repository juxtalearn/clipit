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
$id = elgg_extract('id', $vars);
$entity = elgg_extract('entity', $vars);
$input_array = elgg_extract('input_array', $vars);
?>
<?php if($entity->task_type == ClipitTask::TYPE_QUIZ_TAKE):?>
    <?php
    echo elgg_view('activity/admin/tasks/quiz/quiz', array(
        'entity' => array_pop(ClipitQuiz::get_by_id(array($entity->quiz))),
        'activity_id' => $entity->activity,
        'tricky_topic' => ClipitActivity::get_tricky_topic($entity->activity),
        'input_prefix' => "task{$input_array}"
    ));
    ?>
<?php endif;?>
