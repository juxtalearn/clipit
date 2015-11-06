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
 * Exposes functions common to Clipit messaging classes to the REST API
 *
 * @param string $api_suffix The API suffix for a certain class
 * @param string $class_suffix The PHP suffix for a certain class
 *
 * @throws InvalidParameterException
 */
function expose_common_message_functions($api_suffix, $class_suffix) {
    expose_function(
        $api_suffix . "get_destination", $class_suffix . "get_destination",
        array("id" => array("type" => "int", "required" => true)), "Get Destination Id of a Message", 'GET', false, true
    );
    expose_function(
        $api_suffix . "set_destination", $class_suffix . "set_destination", array(
            "id" => array("type" => "int", "required" => true),
            "destination_id" => array("type" => "int", "required" => true)
        ), "Set the Destination Id of a Message", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_sender", $class_suffix . "get_sender",
        array("id" => array("type" => "int", "required" => true)), "Get Sender Id of a Message", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_sender", $class_suffix . "get_by_sender",
        array("sender_array" => array("type" => "array", "required" => true)), "Get Messages by Sender", 'GET', false,
        true
    );
    expose_function(
        $api_suffix . "get_by_destination", $class_suffix . "get_by_destination", array(
            "destination_array" => array("type" => "array", "required" => true),
            "limit" => array("type" => "int", "required" => false),
            "offset" => array("type" => "int", "required" => false),
            "count_only" => array("type" => "bool", "required" => false),
            "order_by" => array("type" => "string", "required" => false),
            "ascending" => array("type" => "bool", "required" => false)
        ), "Get Messages by Destination", 'GET', false, true
    );
    expose_function(
        $api_suffix . "count_by_sender", $class_suffix . "count_by_sender",
        array("sender_array" => array("type" => "array", "required" => true)), "Count Messages by Sender", 'GET', false,
        true
    );
    expose_function(
        $api_suffix . "count_by_destination", $class_suffix . "count_by_destination", array(
            "destination_array" => array("type" => "array", "required" => true),
            "recursive" => array("type" => "bool", "required" => false)
        ), "Count Messages by Destination", 'GET', false, true
    );
    expose_function(
        $api_suffix . "unread_by_sender", $class_suffix . "unread_by_sender", array(
            "sender_array" => array("type" => "array", "required" => true),
            "user_id" => array("type" => "int", "required" => true)
        ), "Count unread Messages by Sender", 'GET', false, true
    );
    expose_function(
        $api_suffix . "unread_by_destination", $class_suffix . "unread_by_destination", array(
            "destination_array" => array("type" => "array", "required" => true),
            "user_id" => array("type" => "int", "required" => true),
            "recursive" => array("type" => "bool", "required" => false)
        ), "Count unread Messages by Destination", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_read_status", $class_suffix . "get_read_status", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => false)
        ), "Get Message read status. If user_array is specified, get read status by user.
        Else, return the list of users who have read the Post/Message.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "set_read_status", $class_suffix . "set_read_status", array(
            "id" => array("type" => "int", "required" => true),
            "read_value" => array("type" => "bool", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Set Message read status per user.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "add_files", $class_suffix . "add_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Add Attachment files to a Message.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_files", $class_suffix . "set_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Set Attachment files to a Message.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_files", $class_suffix . "remove_files", array(
            "id" => array("type" => "int", "required" => true),
            "file_array" => array("type" => "array", "required" => true)
        ), "Remove attached files from a Message.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_files", $class_suffix . "get_files",
        array("id" => array("type" => "int", "required" => true)), "Get attached files from a Message.", 'GET', false,
        true
    );
}