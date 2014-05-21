<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:02
 */

function expose_quiz_result_functions(){
    $api_suffix = "clipit.quiz_result.";
    $class_suffix = "ClipitQuizResult::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_quiz_question",
        $class_suffix . "get_quiz_question",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Quiz Question for this Quiz Result",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_quiz_question",
        $class_suffix . "get_by_quiz_question",
        array(
            "quiz_question_array" => array(
                "type" => "array",
                "required" => true)),
        "Get instances by Question Id",
        'GET', false, true);
}
