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
function expose_example_functions() {
    $api_suffix = "clipit.example.";
    $class_suffix = "ClipitExample::";
    expose_common_functions($api_suffix, $class_suffix);

    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id to an Example", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id to an Example", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from an Example", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Tags from an Example", 'GET', false, true
    );
}
