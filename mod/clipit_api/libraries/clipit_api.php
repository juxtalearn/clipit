<?php

/**
 * @package clipit
 */
namespace clipit;

function expose_rest_api(){
    expose_quiz_functions();
    expose_quiz_question_functions();
    expose_quiz_result_functions();
    expose_user_functions();
    expose_video_functions();
    //    expose_activity_functions();
    //    expose_comment_functions();
    //    expose_file_functions();
    //    expose_group_function();
    //    expose_palette_functions();
    //    expose_site_functions();
    //    expose_sta_functions();
    //    expose_storyboard_functions();
    //    expose_taxonomy_functions();
    //    expose_taxonomy_sb_functions();
    //    expose_taxonomy_tag_functions();
    //    expose_taxonomy_tc_functions();
}


/**
 * Expose ClipitUser library functions to REST API.
 */
function expose_user_functions(){
    $api_suffix = "clipit.user.";
    $namespace = "\\clipit\\user\\";
    expose_function(
        $api_suffix."list_properties",
        $namespace."list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $namespace."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $namespace."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."create",
        $namespace."create",
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
        $api_suffix."delete",
        $namespace."delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."get_all",
        $namespace."get_all",
        null, "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $namespace."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_login",
        $namespace."get_by_login",
        array(
             "login_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_email",
        $namespace."get_by_email",
        array(
             "email_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_role",
        $namespace."get_by_role",
        array(
             "role_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
}

/**
 * Expose ClipitQuiz library functions to REST API.
 */
function expose_quiz_functions(){
    $api_suffix = "clipit.quiz.";
    $namespace = "\\clipit\\quiz\\";
    expose_function(
        $api_suffix."list_properties",
        $namespace."list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $namespace."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $namespace."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."create",
        $namespace."create",
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
        $api_suffix."delete",
        $namespace."delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_all",
        $namespace."get_all",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $namespace."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."add_questions",
        $namespace."add_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."remove_questions",
        $namespace."remove_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_questions",
        $namespace."get_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Expose ClipitQuizQuestionlibrary functions to REST API.
 */
function expose_quiz_question_functions(){
    $api_suffix = "clipit.quiz.question.";
    $namespace = "\\clipit\\quiz\\question\\";
    expose_function(
        $api_suffix."list_properties",
        $namespace."list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $namespace."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $namespace."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."create",
        $namespace."create",
        array(
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "description" => array(
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
        $api_suffix."delete",
        $namespace."delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_all",
        $namespace."get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $namespace."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_results",
        $namespace."get_results",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."add_taxonomy_tags",
        $namespace."add_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."remove_taxonomy_tags",
        $namespace."remove_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_taxonomy_tags",
        $namespace."get_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", "GET", false, true);
}

/**
 * Expose ClipitQuizResult library functions to REST API.
 */
function expose_quiz_result_functions(){
    $api_suffix = "clipit.quiz.result.";
    $namespace = "\\clipit\\quiz\\result\\";
    expose_function(
        $api_suffix."list_properties",
        $namespace."list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $namespace."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $namespace."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."create",
        $namespace."create",
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
        $api_suffix."delete",
        $namespace."delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_all",
        $namespace."get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $namespace."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_from_question",
        $namespace."get_from_question",
        array(
             "quiz_question_id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Expose ClipitVideo library functions to REST API.
 */
function expose_video_functions(){
    $api_suffix = "clipit.video.";
    $namespace = "\\clipit\\video\\";
    expose_function(
        $api_suffix."list_properties",
        $namespace."list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_properties",
        $namespace."get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."set_properties",
        $namespace."set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        $api_suffix."create",
        $namespace."create",
        array(
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "description" => array(
                 "type" => "string",
                 "required" => false),
             "comment_array" => array(
                 "type" => "array",
                 "required" => false),
             "content" => array(
                 "type" => "int",
                 "required" => false),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."delete",
        $namespace."delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_all",
        $namespace."get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."get_by_id",
        $namespace."get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        $api_suffix."add_comments",
        $namespace."add_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "comment_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", "GET", false, true);
    expose_function(
        $api_suffix."remove_comments",
        $namespace."remove_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "comment_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", "GET", false, true);
    expose_function(
        $api_suffix."get_comments",
        $namespace."get_comments",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", "GET", false, true);
}