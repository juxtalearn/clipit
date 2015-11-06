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
function expose_task_functions() {
    $api_suffix = "clipit.task.";
    $class_suffix = "ClipitTask::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_activity", $class_suffix . "get_activity",
        array("id" => array("type" => "int", "required" => true)), "Get Task Activity", 'GET', false, true
    );
    expose_function(
        $api_suffix . "set_activity", $class_suffix . "set_activity", array(
            "id" => array("type" => "int", "required" => true),
            "activity_id" => array("type" => "int", "required" => true)
        ), "Set Task Activity", 'POST', false, true
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
    expose_function(
        $api_suffix . "get_child_task", $class_suffix . "get_child_task",
        array("id" => array("type" => "int", "required" => true)),
        "Get the Child Task (if any)", "GET", false, true
    );
    expose_function(
        $api_suffix . "set_child_task", $class_suffix . "set_child_task",
        array(
            "id" => array("type" => "int", "required" => true),
            "child_task" => array("type" => "int", "required" => true)),
        "Set the Child Task", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_parent_task", $class_suffix . "get_parent_task",
        array("id" => array("type" => "int", "required" => true)),
        "Get the Parent Task (if any)", "GET", false, true
    );
    expose_function(
        $api_suffix . "set_parent_task", $class_suffix . "set_parent_task",
        array(
            "id" => array("type" => "int", "required" => true),
            "parent_task" => array("type" => "int", "required" => true)),
        "Set the Parent Task", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_status", $class_suffix . "get_status",
        array("id" => array("type" => "int", "required" => true)), "Get Task Status", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_completed_status", $class_suffix . "get_completed_status", array(
            "id" => array("type" => "int", "required" => true),
            "entity_id" => array("type" => "int", "required" => true)
        ), "Returns whether a Task has been completed by an Entity (User or Group)", "GET", false, true
    );
}
