<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/11/2014
 * Last update:     04/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$questions = array_filter(get_input('question', array()));
$task_id = get_input('task-id');
$quiz_id = get_input('entity-id');
$user_id = elgg_get_logged_in_user_guid();

foreach($questions as $question_id => $value){
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($question_id)));
    switch($question->option_type){
        case ClipitQuizQuestion::TYPE_NUMBER:
            break;
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            $p = array_fill(0, count($question->validation_array), 0);
            $p[$value-1] = 1;
            $value = $p;
            break;
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            $p = array_fill(0, count($question->validation_array), 0);
            for($x = 0; $x <= count($value); $x++){
                if($value[$x]  ){
                    $s = $value[$x]-1;
                    $p[$s] = 1;
                }
            }
            $value = $p;
            break;
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            $a = array_fill(0, 2, 0);
            switch($value){
                case 'true':
                    $a[0] = 1;
                    break;
                case 'false':
                    $a[1] = 1;
                    break;
            }
            $value = $a;
            break;
    }

    $result_id = ClipitQuizResult::create(array(
        'quiz_question' => $question_id,
        'answer' => $value,
    ));
    ClipitQuizResult::evaluate_result($result_id);
}

$task = array_pop(ClipitTask::get_by_id(array($task_id)));
if(ClipitQuiz::has_finished_quiz($quiz_id, $user_id) || $task->end <= time()){
    echo 'finished';
} else {
    echo ClipitQuiz::questions_answered_by_user($quiz_id, $user_id);
}

if(get_input('finish')){
    ClipitQuiz::set_quiz_as_finished($quiz_id, $user_id);
}
forward("clipit_activity/" . $task->activity . "/tasks");