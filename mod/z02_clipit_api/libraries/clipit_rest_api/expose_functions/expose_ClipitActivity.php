<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * Expose class functions for the Clipit REST API
 */
function expose_activity_functions() {
    $api_suffix = "clipit.activity.";
    $class_suffix = "ClipitActivity::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_user", $class_suffix . "get_from_user", array(
            "user_id" => array("type" => "int", "required" => true),
            "joined_only" => array("type" => "bool", "required" => false)
        ), "Get an array of Activity Ids in which a User is called, or has joined", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_from_tricky_topic", $class_suffix . "get_from_tricky_topic",
        array("tricky_topic_id" => array("type" => "int", "required" => true)),
        "Get an array of Activity Ids which treat a Tricky Topic", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_status", $class_suffix . "get_status",
        array("id" => array("type" => "int", "required" => true)), "Get Activity Status", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_all_open", $class_suffix . "get_all_open",
        array(
            "limit" => array("type" => "int", "required" => true),
            "offset" => array("type" => "int", "required" => true)),
        "Get all open activities", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_teachers", $class_suffix . "add_teachers", array(
            "id" => array("type" => "int", "required" => true),
            "teacher_array" => array("type" => "array", "required" => true)
        ), "Add Teachers by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_teachers", $class_suffix . "set_teachers", array(
            "id" => array("type" => "int", "required" => true),
            "teacher_array" => array("type" => "array", "required" => true)
        ), "Set Teachers by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_teachers", $class_suffix . "remove_teachers", array(
            "id" => array("type" => "int", "required" => true),
            "teacher_array" => array("type" => "array", "required" => true)
        ), "Removes Teachers by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_teachers", $class_suffix . "get_teachers",
        array("id" => array("type" => "int", "required" => true)), "Gets Teachers from an Activity", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_students", $class_suffix . "add_students", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Add Students to an activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_students", $class_suffix . "set_students", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Set student_array of an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_students", $class_suffix . "remove_students", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Removes students  by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_students", $class_suffix . "get_students",
        array("id" => array("type" => "int", "required" => true)), "Gets Students from an Activity", "GET", false,
        true
    );
    expose_function(
        $api_suffix . "add_groups", $class_suffix . "add_groups", array(
            "id" => array("type" => "int", "required" => true),
            "group_array" => array("type" => "array", "required" => true)
        ), "Add Groups by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_groups", $class_suffix . "set_groups", array(
            "id" => array("type" => "int", "required" => true),
            "group_array" => array("type" => "array", "required" => true)
        ), "Set Groups by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_groups", $class_suffix . "remove_groups", array(
            "id" => array("type" => "int", "required" => true),
            "group_array" => array("type" => "array", "required" => true)
        ), "Removes Groups by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_groups", $class_suffix . "get_groups",
        array("id" => array("type" => "int", "required" => true)), "Gets Groups from an Activity", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_tasks", $class_suffix . "add_tasks", array(
            "id" => array("type" => "int", "required" => true),
            "task_array" => array("type" => "array", "required" => true)
        ), "Add Tasks by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_tasks", $class_suffix . "set_tasks", array(
            "id" => array("type" => "int", "required" => true),
            "task_array" => array("type" => "array", "required" => true)
        ), "Set Tasks by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_tasks", $class_suffix . "remove_tasks", array(
            "id" => array("type" => "int", "required" => true),
            "task_array" => array("type" => "array", "required" => true)
        ), "Removes Tasks by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_tasks", $class_suffix . "get_tasks",
        array("id" => array("type" => "int", "required" => true)), "Gets Tasks from an Activity", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_videos", $class_suffix . "add_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Add Videos by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_videos", $class_suffix . "set_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Set Videos by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_videos", $class_suffix . "remove_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Removes Videos by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_videos", $class_suffix . "get_videos",
        array("id" => array("type" => "int", "required" => true)), "Gets Videos from an Activity", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_files", $class_suffix . "add_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Add Files by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_files", $class_suffix . "set_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Set Files by Id to an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_files", $class_suffix . "remove_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Removes Files by Id from an Activity", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_files", $class_suffix . "get_files",
        array("id" => array("type" => "int", "required" => true)), "Gets Files from an Activity", "GET", false, true
    );
}