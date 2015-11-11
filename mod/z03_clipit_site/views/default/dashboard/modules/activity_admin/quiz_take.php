<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$task = elgg_extract('task', $vars);
$quiz = array_pop(ClipitQuiz::get_by_id(array($task->quiz)));
$i=1;

foreach(ClipitQuizQuestion::get_by_id($quiz->quiz_question_array) as $question):
    $entities = ClipitActivity::get_students($task->activity);
    $results = array_pop(ClipitQuizResult::get_by_quiz_question(array($question->id)));
    $finished_task = $task->end <= time() ? true : false;

    $users = array();
    $us = array();
    foreach($results as $result){
        if($result->correct) {
            $users['correct'][] = $result->owner_id;
        } else {
            $users['error'][] = $result->owner_id;;
        }
        $us[] = $result->owner_id;
    }
    foreach(array_diff($entities, $us) as $user_pending){
        if(ClipitQuiz::has_finished_quiz($quiz->id, $user_pending) || $finished_task){
            $users['error'][]['not_answered'] = $user_pending;
            $us[] = $user_pending;
        }
    }
    $users['pending'] = array_diff($entities, $us);
?>
    <li class="list-item-5">
        <?php echo elgg_view('output/url', array(
            'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}#{$question->id}",
            'title' => $question->name,
            'text'  => '<strong>'.$i.'.</strong> '.$question->name,
            'class' => 'text-truncate blue'
        ));
        ?>
        <div class="margin-left-20">
            <small class="margin-right-10">
                <i class="fa fa-times red"></i> <strong class="a-error"><?php echo count($users['error']);?></strong>
            </small>
            <small class="margin-right-10">
                <i class="fa fa-check green"></i> <strong class="a-correct"><?php echo count($users['correct']);?></strong>
            </small>
            <small class="margin-right-10">
                <i class="fa fa-clock-o yellow"></i> <strong class="a-pending"><?php echo count($entities) - count($us);?></strong>
            </small>
        </div>
    </li>
<?php
$i++;
endforeach;?>

