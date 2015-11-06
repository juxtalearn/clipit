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
function expose_event_functions() {
    $api_suffix = "clipit.event.";
    $class_suffix = "ClipitEvent::";
    expose_function(
        $api_suffix . "get_latest", $class_suffix . "get_latest", array(
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get the latest events without filtering.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_user", $class_suffix . "get_by_user", array(
            "user_array" => array("type" => "array", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events filtered by User.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_object", $class_suffix . "get_by_object", array(
            "object_array" => array("type" => "array", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events filtered by Object.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_recommended_events", $class_suffix . "get_recommended_events", array(
            "user_id" => array("type" => "int", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events which may interest a User.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_all_events", $class_suffix . "get_all_events", array(
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get all events (merge of activity, group and task events).", 'GET', false, true
    );
}
