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
 * Expose all functions for the ClipIt REST API
 */
function expose_clipit_api(){
    expose_activity_functions();
    expose_chat_functions();
    expose_comment_functions();
    expose_event_functions();
    expose_example_functions();
    expose_file_functions();
    expose_group_functions();
    expose_la_functions();
    expose_label_functions();
    expose_performance_item_functions();
    expose_performance_rating_functions();
    expose_post_functions();
    expose_quiz_functions();
    expose_quiz_question_functions();
    expose_quiz_result_functions();
    expose_rating_functions();
    expose_site_functions();
    expose_sta_functions();
    expose_storyboard_functions();
    expose_tag_functions();
    expose_tag_rating_functions();
    expose_task_functions();
    expose_tricky_topic_functions();
    expose_user_functions();
    expose_video_functions();
}

function expose_common_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix . "list_properties",
        $class_suffix . "list_properties",
        null,
        "Get class properties",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_properties",
        $class_suffix . "get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => false)),
        "Get property=>value array",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_properties",
        $class_suffix . "set_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_value_array" => array(
                "type" => "array",
                "required" => true)),
        "Set property=>value array and save into the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "create",
        $class_suffix . "create",
        array(
            "prop_value_array" => array(
                "type" => "array",
                "required" => true)),
        "Create a new instance, set property=>value array and save into the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "create_clone",
        $class_suffix . "create_clone",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Create a clone copy of an instance",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_clones",
        $class_suffix . "get_clones",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get all Item IDs which were cloned from the one given",
        "GET", false, true);
    expose_function(
        $api_suffix . "delete_by_id",
        $class_suffix . "delete_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "Delete instances by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "delete_all",
        $class_suffix . "delete_all",
        null,
        "Delete all instances of this class",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_all",
        $class_suffix . "get_all",
        array(
            "limit" => array(
                "type" => "int",
                "required" => false)),
        "Get all instances",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_id",
        $class_suffix . "get_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "Get instances by Id",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_events",
        $class_suffix . "get_events",
        array(
            "offset" => array(
                "type" => "int",
                "required" => false),
            "limit" => array(
                "type" => "int",
                "required" => false)),
        "Get object-type associated events.",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_by_owner",
        $class_suffix . "get_by_owner",
        array(
            "owner_array" => array(
                "type" => "array",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => false)),
        "Get instances from an Owner",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_from_search",
        $class_suffix . "get_from_search",
        array(
            "search_string" => array(
                "type" => "string",
                "required" => true),
            "name_only" => array(
                "type" => "bool",
                "required" => false),
            "strict" => array(
                "type" => "bool",
                "required" => false)),
        "Get instances from searching inside the object name and description for a string.",
        'GET', false, true);
}

function expose_common_message_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix . "get_destination",
        $class_suffix . "get_destination",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Destination Id of a Message",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_destination",
        $class_suffix . "set_destination",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "destination_id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Destination Id of a Message",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_sender",
        $class_suffix . "get_sender",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Sender Id of a Message",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_sender",
        $class_suffix . "get_by_sender",
        array(
            "sender_array" => array(
                "type" => "array",
                "required" => true)),
        "Get Messages by Sender",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_destination",
        $class_suffix . "get_by_destination",
        array(
            "destination_array" => array(
                "type" => "array",
                "required" => true),
            "recursive" => array(
                "type" => "bool",
                "required" => false)),
        "Get Messages by Destination",
        'GET', false, true);
    expose_function(
        $api_suffix . "count_by_sender",
        $class_suffix . "count_by_sender",
        array(
            "sender_array" => array(
                "type" => "array",
                "required" => true)),
        "Count Messages by Sender",
        'GET', false, true);
    expose_function(
        $api_suffix . "count_by_destination",
        $class_suffix . "count_by_destination",
        array(
            "destination_array" => array(
                "type" => "array",
                "required" => true),
            "recursive" => array(
                "type" => "bool",
                "required" => false)),
        "Count Messages by Destination",
        'GET', false, true);
    expose_function(
        $api_suffix . "unread_by_sender",
        $class_suffix . "unread_by_sender",
        array(
            "sender_array" => array(
                "type" => "array",
                "required" => true),
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Count unread Messages by Sender",
        'GET', false, true);
    expose_function(
        $api_suffix . "unread_by_destination",
        $class_suffix . "unread_by_destination",
        array(
            "destination_array" => array(
                "type" => "array",
                "required" => true),
            "user_id" => array(
                "type" => "int",
                "required" => true),
            "recursive" => array(
                "type" => "bool",
                "required" => false)),
        "Count unread Messages by Destination",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_read_status",
        $class_suffix . "get_read_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => false)),
        "Get Message read status. If user_array is specified, get read status by user.
        Else, return the list of users who have read the Post/Message.",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_read_status",
        $class_suffix . "set_read_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "read_value" => array(
                "type" => "bool",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Message read status per user.",
        'POST', false, true);
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
        "Attach files to a Message.",
        'POST', false, true);
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
        "Remove attached files from a Message.",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_files",
        $class_suffix . "get_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get attached files from a Message.",
        'GET', false, true);
}

function expose_common_material_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix . "get_publish_level",
        $class_suffix . "get_publish_level",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Publish level for a Material ('group', 'activity' or 'site').",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_group",
        $class_suffix . "get_group",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Group this Material is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Activity this Material is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_site",
        $class_suffix . "get_site",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the Site this Material is inside of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_tags",
        $class_suffix . "add_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Tags by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_tags",
        $class_suffix . "set_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Tags by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_tags",
        $class_suffix . "remove_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Tags by Id from a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_tags",
        $class_suffix . "get_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Tags from a Material",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_labels",
        $class_suffix . "add_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Labels by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_labels",
        $class_suffix . "set_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Labels by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_labels",
        $class_suffix . "remove_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "label_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Tags by Id from a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_labels",
        $class_suffix . "get_labels",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Labels from a Material",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_comments",
        $class_suffix . "add_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Comments by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_comments",
        $class_suffix . "set_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Comments by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_comments",
        $class_suffix . "remove_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "comment_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Comments by Id from a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_comments",
        $class_suffix . "get_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Comments from a Material",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_performance_items",
        $class_suffix . "add_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Performance Items by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_performance_items",
        $class_suffix . "set_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Performance Items by Id to a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_performance_items",
        $class_suffix . "remove_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "performance_item_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Performance Items by Id from a Material",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_performance_items",
        $class_suffix . "get_performance_items",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Performance Items from a Material",
        'GET', false, true);
}
