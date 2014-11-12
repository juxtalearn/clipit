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
//    if((is_array($value) && (empty($value) || empty($value[1]))) || trim($value) == ''){
//       continue;
//    }
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($question_id)));
    $correct = false;
    switch($question->option_type){
        case ClipitQuizQuestion::TYPE_NUMBER:
            $valid = array_pop($question->validation_array);
            if($valid == $value){
                $correct = true;
            }
            break;
        case ClipitQuizQuestion::TYPE_SELECT_ONE:
            $value = $value - 1;
            if($question->validation_array[$value]){
                $correct = true;
            }
            break;
        case ClipitQuizQuestion::TYPE_SELECT_MULTI:
            $total_validate = count(array_filter($question->validation_array));
            $validate = 0;
            $novalidate = 0;
            for($i = 0; $i<count($question->validation_array); $i++){
                $value[$i] = $value[$i] - 1;
                if($question->validation_array[$value[$i]]){
                    $validate++;
                } else {
                    $novalidate++;
                }
            }
            if($total_validate == $validate && $novalidate == 0){
                $correct = true;
            }
            break;
        case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            if($value == array_pop($question->validation_array)){
                $correct = true;
            }
            break;
        case ClipitQuizQuestion::TYPE_STRING:
            $correct = false;
            break;
    }

    if($answered = ClipitQuizResult::get_from_question_user($question_id, $user_id)){
        ClipitQuizResult::set_properties($answered->id, array(
            'correct' => $correct,
            'answer' => $value,
        ));
    } else {
        $result_id = ClipitQuizResult::create(array(
            'correct' => $correct,
            'answer' => $value,
        ));
        ClipitQuizQuestion::add_quiz_results($question_id, array($result_id));
    }
}

$task = array_pop(ClipitTask::get_by_id(array($task_id)));
if(ClipitQuiz::has_finished_quiz($quiz_id, $user_id) || $task->end <= time()){
    echo 'finished';
} else {
    $by_owner = array_pop(ClipitQuizResult::get_by_owner(array(elgg_get_logged_in_user_guid())));
    echo count($by_owner);
}

