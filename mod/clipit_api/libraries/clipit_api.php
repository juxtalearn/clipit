<?php

/**
 * @package clipit
 */
namespace clipit;

function expose_api(){
    expose_quiz_functions();
    expose_quiz_question_functions();
    expose_quiz_result_functions();
    expose_user_functions();
}


/**
 * Expose library functions to REST API.
 */
function expose_user_functions(){
    $namespace = "\\clipit\\user";
    expose_function(
        "clipit.user.list_properties",
        $namespace."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.user.get_properties",
        $namespace."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.set_properties",
        $namespace."\\set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true),
             "value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.create",
        $namespace."\\create",
        array(
             "login" => array(
                 "type" => "string",
                 "required" => true),
             "password" => array(
                 "type" => "string",
                 "required" => true),
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "email" => array(
                 "type" => "string",
                 "required" => true),
             "role" => array(
                 "type" => "string",
                 "required" => false),
             "description" => array(
                 "type" => "string",
                 "required" => false)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.delete",
        $namespace."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_all",
        $namespace."\\get_all",
        null, "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_by_id",
        $namespace."\\get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_by_login",
        $namespace."\\get_by_login",
        array(
             "login_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_by_email",
        $namespace."\\get_by_email",
        array(
             "email_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_by_role",
        $namespace."\\get_by_role",
        array(
             "role_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
}

/**
 * Expose libraty functions to REST API.
 */
function expose_quiz_functions(){
    $namespace = "\\clipit\\quiz";
    expose_function(
        "clipit.quiz.list_properties",
        $namespace."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_properties",
        $namespace."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.set_properties",
        $namespace."\\set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true),
             "value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.create",
        $namespace."\\create",
        array(
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "target" => array(
                 "type" => "string",
                 "required" => true),
             "description" => array(
                 "type" => "string",
                 "required" => false),
             "public" => array(
                 "type" => "bool",
                 "required" => false),
             "question_array" => array(
                 "type" => "array",
                 "required" => false),
             "taxonomy" => array(
                 "type" => "int",
                 "required" => false)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.delete",
        $namespace."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.add_questions",
        $namespace."\\add_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_all",
        $namespace."\\get_all",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_by_id",
        $namespace."\\get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_questions",
        $namespace."\\get_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Expose libraty functions to REST API.
 */
function expose_quiz_question_functions(){
    $namespace = "\\clipit\\quiz\\question";
    expose_function(
        "clipit.quiz.question.list_properties",
        $namespace."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_properties",
        $namespace."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.set_properties",
        $namespace."\\set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true),
             "value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.create",
        $namespace."\\create",
        array(
             "question" => array(
                 "type" => "string",
                 "required" => true),
             "option_array" => array(
                 "type" => "array",
                 "required" => true),
             "option_type" => array(
                 "type" => "string",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => false),
             "video" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.delete",
        $namespace."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.add_taxonomy_tags",
        $namespace."\\add_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_all",
        $namespace."\\get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_results",
        $namespace."\\get_results",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_by_id",
        $namespace."\\get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Expose libraty functions to REST API.
 */
function expose_quiz_result_functions(){
    $namespace = "\\clipit\\quiz\\result";
    expose_function(
        "clipit.quiz.result.list_properties",
        $namespace."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_properties",
        $namespace."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.set_properties",
        $namespace."\\set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true),
             "value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.create",
        $namespace."\\create",
        array(
             "quiz_question" => array(
                 "type" => "int",
                 "required" => true),
             "result_array" => array(
                 "type" => "array",
                 "required" => true),
             "user" => array(
                 "type" => "int",
                 "required" => true),
             "correct" => array(
                 "type" => "bool",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.delete",
        $namespace."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_all",
        $namespace."\\get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_from_question",
        $namespace."\\get_from_question",
        array(
             "quiz_question_id" => array(
                 "type" => "int",
                 "required" => true),
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_by_id",
        $namespace."\\get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
}