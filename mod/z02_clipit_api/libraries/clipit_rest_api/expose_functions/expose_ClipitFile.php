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
function expose_file_functions() {
    $api_suffix = "clipit.file.";
    $class_suffix = "ClipitFile::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_by_labels", $class_suffix . "get_by_labels",
        array("label_array" => array("type" => "array", "required" => true)),
        "Get the Files containing at least one of the specified labels", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_tags", $class_suffix . "get_by_tags",
        array("tag_array" => array("type" => "array", "required" => true)),
        "Get the Files containing at least one of the specified tags", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_scope", $class_suffix . "get_scope",
        array("id" => array("type" => "int", "required" => true)),
        "Get Resource scope for a File ('group', 'activity', 'task' or 'site')", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_group", $class_suffix . "get_group",
        array("id" => array("type" => "int", "required" => true)), "Get the Group this File is inside of.", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_task", $class_suffix . "get_task", array("id" => array("type" => "int", "required" => true)),
        "Get the Task this File is inside of.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_activity", $class_suffix . "get_activity",
        array("id" => array("type" => "int", "required" => true)), "Get the Activity this File is inside of.", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_site", $class_suffix . "get_site", array("id" => array("type" => "int", "required" => true)),
        "Get the Site this File is inside of.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Tags from a File", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_labels", $class_suffix . "add_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Add Labels by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_labels", $class_suffix . "set_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Set Labels by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_labels", $class_suffix . "remove_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_labels", $class_suffix . "get_labels",
        array("id" => array("type" => "int", "required" => true)), "Get Labels from a File", 'GET', false, true
    );
}
