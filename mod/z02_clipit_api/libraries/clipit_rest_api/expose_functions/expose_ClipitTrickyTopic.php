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
function expose_tricky_topic_functions() {
    $api_suffix = "clipit.tricky_topic.";
    $class_suffix = "ClipitTrickyTopic::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id to a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id to a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Tags from a Tricky Topic", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_videos", $class_suffix . "add_videos", array(
        "id" => array("type" => "int", "required" => true),
        "video_array" => array("type" => "array", "required" => true)
    ), "Add Videos by ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_videos", $class_suffix . "set_videos", array(
        "id" => array("type" => "int", "required" => true),
        "video_array" => array("type" => "array", "required" => true)
    ), "Set Videos by ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_videos", $class_suffix . "remove_videos", array(
        "id" => array("type" => "int", "required" => true),
        "video_array" => array("type" => "array", "required" => true)
    ), "Removes Videos ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_videos", $class_suffix . "get_videos",
        array("id" => array("type" => "int", "required" => true)), "Gets Videos from a TT", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_files", $class_suffix . "add_files", array(
        "id" => array("type" => "int", "required" => true),
        "file_array" => array("type" => "array", "required" => true)
    ), "Add Files by ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_files", $class_suffix . "set_files", array(
        "id" => array("type" => "int", "required" => true),
        "file_array" => array("type" => "array", "required" => true)
    ), "Set Files by ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_files", $class_suffix . "remove_files", array(
        "id" => array("type" => "int", "required" => true),
        "file_array" => array("type" => "array", "required" => true)
    ), "Removes Files by ID array to a TT", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_files", $class_suffix . "get_files",
        array("id" => array("type" => "int", "required" => true)), "Gets Files from a TT", "GET", false, true
    );
}
