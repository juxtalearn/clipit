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
function expose_chat_functions() {
    $api_suffix = "clipit.chat.";
    $class_suffix = "ClipitChat::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_inbox", $class_suffix . "get_inbox",
        array("user_id" => array("type" => "int", "required" => true)),
        "Returns Inbox messages for a given User, grouped by Sender", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_inbox_count", $class_suffix . "get_inbox_count",
        array("user_id" => array("type" => "int", "required" => true)), "Counts Inbox messages for a given User", "GET",
        false, true
    );
    expose_function(
        $api_suffix . "get_inbox_unread", $class_suffix . "get_inbox_unread",
        array("user_id" => array("type" => "int", "required" => true)), "Counts unread Inbox messages for a given User",
        "GET", false, true
    );
    expose_function(
        $api_suffix . "get_sent", $class_suffix . "get_sent",
        array("user_id" => array("type" => "int", "required" => true)), "Returns Sent messages for a given User", "GET",
        false, true
    );
    expose_function(
        $api_suffix . "get_sent_count", $class_suffix . "get_sent_count",
        array("user_id" => array("type" => "int", "required" => true)), "Counts Sent messages for a given User", "GET",
        false, true
    );
    expose_function(
        $api_suffix . "get_archived", $class_suffix . "get_archived",
        array("user_id" => array("type" => "int", "required" => true)), "Returns Archived messages for a given User",
        "GET", false, true
    );
    expose_function(
        $api_suffix . "get_archived_count", $class_suffix . "get_archived_count",
        array("user_id" => array("type" => "int", "required" => true)), "Counts Archived messages for a given User",
        "GET", false, true
    );
    expose_function(
        $api_suffix . "get_conversation", $class_suffix . "get_conversation", array(
            "user1_id" => array("type" => "int", "required" => true),
            "user2_id" => array("type" => "int", "required" => true)
        ), "Returns all Chat messages interchanged between two users", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_conversation_count", $class_suffix . "get_conversation_count", array(
            "user1_id" => array("type" => "int", "required" => true),
            "user2_id" => array("type" => "int", "required" => true)
        ), "Counts all Chat messages interchanged between two users", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_conversation_unread", $class_suffix . "get_conversation_unread", array(
            "user1_id" => array("type" => "int", "required" => true),
            "user2_id" => array("type" => "int", "required" => true)
        ), "Counts all unread Chat messages interchanged between two users", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_archived_status", $class_suffix . "get_archived_status", array(
            "id" => array("type" => "int", "required" => true),
            "user_array" => array("type" => "array", "required" => false)
        ), "Get Chat message archived status. If user_array is specified, get archived status by user.
        Else, return the list of users who have archived the Post/Message.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "set_archived_status", $class_suffix . "set_archived_status", array(
            "id" => array("type" => "int", "required" => true),
            "archived_value" => array("type" => "bool", "required" => true),
            "user_array" => array("type" => "array", "required" => true)
        ), "Set Chat message archived status per user.", 'POST', false, true
    );
}