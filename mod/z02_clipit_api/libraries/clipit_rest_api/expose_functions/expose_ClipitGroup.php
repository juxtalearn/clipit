<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */

/**
 * Expose class functions for the ClipIt REST API
 */
function expose_group_functions() {
    $api_suffix = "clipit.group.";
    $class_suffix = "ClipitGroup::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_user_activity", $class_suffix . "get_from_user_activity", array(
            "user_id" => array("type" => "int", "required" => true),
            "activity_id" => array("type" => "int", "required" => true)
        ), "Gets the Group in which a User is performing an Activity", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_activity", $class_suffix . "get_activity",
        array("id" => array("type" => "int", "required" => true)), "Gets the Activity this group is taking part in",
        "GET", false, true
    );
    expose_function(
        $api_suffix . "add_users", $class_suffix . "add_users", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Adds Users (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_users", $class_suffix . "set_users", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Sets Users (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_users", $class_suffix . "remove_users", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Removes Users (by Id) from a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_users", $class_suffix . "get_users",
        array("id" => array("type" => "int", "required" => true)), "Gets Users (by Id) from a Group", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_files", $class_suffix . "add_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Adds Files (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_files", $class_suffix . "set_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Sets Files (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_files", $class_suffix . "remove_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Removes Files (by Id) from a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_files", $class_suffix . "get_files",
        array("id" => array("type" => "int", "required" => true)), "Gets Files (by Id) from a Group", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_videos", $class_suffix . "add_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Add Videos (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_videos", $class_suffix . "set_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Sets Videos (by Id) to a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_videos", $class_suffix . "remove_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Removes Videos (by Id) from a Group", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_videos", $class_suffix . "get_videos",
        array("id" => array("type" => "int", "required" => true)), "Gets Videos (by Id) from a Group", "GET", false,
        true
    );
}
