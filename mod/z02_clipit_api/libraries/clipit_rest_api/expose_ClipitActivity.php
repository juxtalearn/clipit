<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 15:58
 */

function expose_activity_functions(){
    $api_suffix = "clipit.activity.";
    $class_suffix = "ClipitActivity::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_user",
        $class_suffix . "get_from_user",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Get an array of Activity Ids in which a User is involved",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_status",
        $class_suffix . "get_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Activity Status",
        "GET", false, true);
    expose_function(
        $api_suffix . "set_status_enroll",
        $class_suffix . "set_status_enroll",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Enroll",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_status_active",
        $class_suffix . "set_status_active",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Active",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_status_closed",
        $class_suffix . "set_status_closed",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Closed",
        "POST", false, true);
    expose_function(
        $api_suffix . "add_teachers",
        $class_suffix . "add_teachers",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "teacher_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Teachers by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_teachers",
        $class_suffix . "set_teachers",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "teacher_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Teachers by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_teachers",
        $class_suffix . "remove_teachers",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "teacher_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Teachers by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_teachers",
        $class_suffix . "get_teachers",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Teachers from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_called_users",
        $class_suffix . "add_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Called Users by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_called_users",
        $class_suffix . "set_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Called Users by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_called_users",
        $class_suffix . "remove_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Called Users by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_called_users",
        $class_suffix . "get_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Called Users from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_groups",
        $class_suffix . "add_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "group_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Groups by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_groups",
        $class_suffix . "set_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "group_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Groups by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_groups",
        $class_suffix . "remove_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "group_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Groups by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_groups",
        $class_suffix . "get_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Groups from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_tasks",
        $class_suffix . "add_tasks",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "task_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Tasks by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_tasks",
        $class_suffix . "set_tasks",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "task_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Tasks by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_tasks",
        $class_suffix . "remove_tasks",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "task_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Tasks by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_tasks",
        $class_suffix . "get_tasks",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Tasks from an Activity",
        "GET", false, true);
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
}