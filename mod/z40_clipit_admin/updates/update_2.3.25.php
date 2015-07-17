<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 01/06/2015
 * Time: 17:22
 */

// Fix correct quiz results with wrong answers
$quiz_results = ClipitQuizResult::get_all();
foreach($quiz_results as $quiz_result){
    if($quiz_result->correct){
        $quiz_question_id = ClipitQuizResult::get_quiz_question($quiz_result->id);
        if(empty($quiz_question_id)){
            continue;
        }
        $pv_array = ClipitQuizQuestion::get_properties($quiz_question_id, array("option_type","validation_array"));
        switch((string)$pv_array["option_type"]){
            case ClipitQuizQuestion::TYPE_TRUE_FALSE:
            case ClipitQuizQuestion::TYPE_SELECT_ONE:
            case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                ClipitQuizResult::set_properties(
                    $quiz_result->id,
                    array("answer" => (array)$pv_array["validation_array"]));
                break;
            case ClipitQuizQuestion::TYPE_NUMBER:
                ClipitQuizResult::set_properties(
                    $quiz_result->id,
                    array("answer" => (float)array_pop($pv_array["validation_array"])));
                break;
        }
    }
}