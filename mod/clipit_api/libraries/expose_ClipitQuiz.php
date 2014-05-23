<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:02
 */

function expose_quiz_functions(){
    $api_suffix = "clipit.quiz.";
    $class_suffix = "ClipitQuiz::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_quiz_questions",
        $class_suffix . "add_quiz_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_question_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_quiz_questions",
        $class_suffix . "set_quiz_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_question_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_quiz_questions",
        $class_suffix . "remove_quiz_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_question_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_quiz_questions",
        $class_suffix . "get_quiz_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Quiz Questions",
        'GET', false, true);
}
