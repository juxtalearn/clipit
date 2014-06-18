<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:03
 */

function expose_task_functions(){
    $api_suffix = "clipit.task.";
    $class_suffix = "ClipitTask::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Task Activity",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_storyboards",
        $class_suffix . "add_storyboards",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "storyboard_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Storyboards by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_storyboards",
        $class_suffix . "set_storyboards",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "storyboard_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Storyboards by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_storyboards",
        $class_suffix . "remove_storyboards",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "storyboard_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Storyboards by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_storyboards",
        $class_suffix . "get_storyboards",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Storyboards from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_videos",
        $class_suffix . "add_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Videos by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_videos",
        $class_suffix . "set_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Videos by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_videos",
        $class_suffix . "remove_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Videos by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_videos",
        $class_suffix . "get_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Videos from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_files",
        $class_suffix . "add_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "file_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Files by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_files",
        $class_suffix . "set_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "file_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Files by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_files",
        $class_suffix . "remove_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "file_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Files by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_files",
        $class_suffix . "get_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Files from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_quizzes",
        $class_suffix . "add_quizzes",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Quizzes by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_quizzes",
        $class_suffix . "set_quizzes",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Quizzes by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_quizzes",
        $class_suffix . "remove_quizzes",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "quiz_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Quizzes by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_quizzes",
        $class_suffix . "get_quizzes",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Quizzes from an Activity",
        "GET", false, true);
}
