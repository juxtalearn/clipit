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
function clipit_expose_api(){
    expose_activity_functions();
    expose_chat_functions();
    expose_comment_functions();
    expose_event_functions();
    expose_file_functions();
    expose_group_functions();
    expose_la_functions();
    expose_post_functions();
    expose_quiz_functions();
    expose_quiz_question_functions();
    expose_quiz_result_functions();
    expose_site_functions();
    expose_sta_functions();
    expose_storyboard_functions();
    expose_tag_functions();
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
                "required" => true)),
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
        $api_suffix . "delete_by_id",
        $class_suffix . "delete_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "Delete instances by Id",
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

function expose_activity_functions(){
    $api_suffix = "clipit.activity.";
    $class_suffix = "ClipitActivity::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_user",
        $class_suffix . "get_from_user",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Get an array of Activity Ids in which a User is involved",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_status",
        $class_suffix . "get_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Activity Status",
        "GET", false, true);
    expose_function(
        $api_suffix . "set_status_enroll",
        $class_suffix . "set_status_enroll",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Enroll",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_status_active",
        $class_suffix . "set_status_active",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Active",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_status_closed",
        $class_suffix . "set_status_closed",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set Activity Status to Closed",
        "POST", false, true);
    expose_function(
        $api_suffix . "add_called_users",
        $class_suffix . "add_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Called Users by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_called_users",
        $class_suffix . "remove_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Called Users by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_called_users",
        $class_suffix . "get_called_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Called Users from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_groups",
        $class_suffix . "add_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "group_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Group by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_groups",
        $class_suffix . "remove_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "group_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Groups by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_groups",
        $class_suffix . "get_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Groups from an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_videos",
        $class_suffix . "add_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Videos by Id to an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_videos",
        $class_suffix . "remove_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Videos by Id from an Activity",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_videos",
        $class_suffix . "get_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Videos from an Activity",
        "GET", false, true);
}

function expose_chat_functions(){
    $api_suffix = "clipit.chat.";
    $class_suffix = "ClipitChat::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_inbox",
        $class_suffix . "get_inbox",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Returns Inbox messages for a given User, grouped by Sender",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_inbox_count",
        $class_suffix . "get_inbox_count",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts Inbox messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_inbox_unread",
        $class_suffix . "get_inbox_unread",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts unread Inbox messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_sent",
        $class_suffix . "get_sent",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Returns Sent messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_sent_count",
        $class_suffix . "get_sent_count",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts Sent messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_archived",
        $class_suffix . "get_archived",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Returns Archived messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_archived_count",
        $class_suffix . "get_archived_count",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts Archived messages for a given User",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_conversation",
        $class_suffix . "get_conversation",
        array(
            "user1_id" => array(
                "type" => "int",
                "required" => true),
            "user2_id" => array(
                "type" => "int",
                "required" => true)),
        "Returns all Chat messages interchanged between two users",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_conversation_count",
        $class_suffix . "get_conversation_count",
        array(
            "user1_id" => array(
                "type" => "int",
                "required" => true),
            "user2_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts all Chat messages interchanged between two users",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_conversation_unread",
        $class_suffix . "get_conversation_unread",
        array(
            "user1_id" => array(
                "type" => "int",
                "required" => true),
            "user2_id" => array(
                "type" => "int",
                "required" => true)),
        "Counts all unread Chat messages interchanged between two users",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_archived_status",
        $class_suffix . "get_archived_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => false)),
        "Get Chat message archived status. If user_array is specified, get archived status by user.
        Else, return the list of users who have archived the Post/Message.",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_archived_status",
        $class_suffix . "set_archived_status",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "archived_value" => array(
                "type" => "bool",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Set Chat message archived status per user.",
        'POST', false, true);
}

function expose_comment_functions(){
    $api_suffix = "clipit.comment.";
    $class_suffix = "ClipitComment::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
}

function expose_event_functions(){
    $api_suffix = "clipit.event.";
    $class_suffix = "ClipitEvent::";
    expose_function(
        $api_suffix . "get_latest",
        $class_suffix . "get_latest",
        array(
            "offset" => array(
                "type" => "int",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => true)),
        "Get the latest events without filtering.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_user",
        $class_suffix . "get_by_user",
        array(
            "user_array" => array(
                "type" => "array",
                "required" => true),
            "offset" => array(
                "type" => "int",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => true)),
        "Get events filtered by User.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_object",
        $class_suffix . "get_by_object",
        array(
            "object_array" => array(
                "type" => "array",
                "required" => true),
            "offset" => array(
                "type" => "int",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => true)),
        "Get events filtered by Object.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_recommended_events",
        $class_suffix . "get_recommended_events",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true),
            "offset" => array(
                "type" => "int",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => true)),
        "Get events which may interest a User.",
        'GET', false, true);
}

function expose_file_functions(){
    $api_suffix = "clipit.file.";
    $class_suffix = "ClipitFile::";
    expose_common_functions($api_suffix, $class_suffix);
}

function expose_group_functions(){
    $api_suffix = "clipit.group.";
    $class_suffix = "ClipitGroup::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_user_activity",
        $class_suffix . "get_from_user_activity",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true),
            "activity_id" => array(
                "type" => "int",
                "required" => true)),
        "Gets the Group in which a User is performing an Activity",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets the Activity this group is taking part in",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_users",
        $class_suffix . "add_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Adds Users (by Id) to a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_users",
        $class_suffix . "set_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Sets Users (by Id) to a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_users",
        $class_suffix . "remove_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "user_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Users (by Id) from a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_users",
        $class_suffix . "get_users",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Users (by Id) from a Group",
        "GET", false, true);
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
        "Adds Files (by Id) to a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_files",
        $class_suffix . "set_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "file_array" => array(
                "type" => "array",
                "required" => true)),
        "Sets Files (by Id) to a Group",
        "POST", false, true);
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
        "Removes Files (by Id) from a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_files",
        $class_suffix . "get_files",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Files (by Id) from a Group",
        "GET", false, true);
    expose_function(
        $api_suffix . "add_videos",
        $class_suffix . "add_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Videos (by Id) to a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "set_videos",
        $class_suffix . "set_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Sets Videos (by Id) to a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "remove_videos",
        $class_suffix . "remove_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "video_array" => array(
                "type" => "array",
                "required" => true)),
        "Removes Videos (by Id) from a Group",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_videos",
        $class_suffix . "get_videos",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Gets Videos (by Id) from a Group",
        "GET", false, true);
}

function expose_la_functions(){
    $api_suffix = "clipit.la.";
    $class_suffix = "ClipitLA::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "send_metrics",
        $class_suffix . "send_metrics",
        array(
            "returnId" => array(
                "type" => "int",
                "required" => true),
            "data" => array(
                "type" => "string",
                "required" => true),
            "statuscode" => array(
                "type" => "int",
                "required" => true)),
        "Send Learning Analytics Metrics to ClipIt",
        "POST", false, true);
}

function expose_post_functions(){
    $api_suffix = "clipit.post.";
    $class_suffix = "ClipitPost::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
}

function expose_quiz_functions(){
    $api_suffix = "clipit.quiz.";
    $class_suffix = "ClipitQuiz::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_questions",
        $class_suffix . "add_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "question_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_questions",
        $class_suffix . "remove_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "question_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Quiz Questions by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_questions",
        $class_suffix . "get_questions",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Quiz Questions",
        'GET', false, true);
}

function expose_quiz_question_functions(){
    $api_suffix = "clipit.quiz.question.";
    $class_suffix = "ClipitQuizQuestion::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_results",
        $class_suffix . "get_results",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Quiz Results for the specified Quiz",
        'GET', false, true);
    expose_function(
        $api_suffix . "add_taxonomy_tags",
        $class_suffix . "add_taxonomy_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "taxonomy_tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Add Taxonomy Tags by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "remove_taxonomy_tags",
        $class_suffix . "remove_taxonomy_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "taxonomy_tag_array" => array(
                "type" => "array",
                "required" => true)),
        "Remove Taxonomy Tags by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_taxonomy_tags",
        $class_suffix . "get_taxonomy_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Taxonomy Tags from a Quiz",
        'GET', false, true);
}

function expose_quiz_result_functions(){
    $api_suffix = "clipit.quiz.result.";
    $class_suffix = "ClipitQuizResult::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_by_question",
        $class_suffix . "get_by_question",
        array(
            "quiz_question_array" => array(
                "type" => "array",
                "required" => true)),
        "Get instances by Question Id",
        'GET', false, true);
}

function expose_site_functions(){
    $api_suffix = "clipit.site.";
    $class_suffix = "ClipitSite::";
    unexpose_function("system.api.list");
    expose_function(
        $api_suffix . "api_list",
        $class_suffix . "api_list",
        null,
        "Return the API method list, including description and required parameters.",
        'GET', false, false);
    unexpose_function("auth.gettoken");
    expose_function(
        $api_suffix . "get_token",
        $class_suffix . "get_token",
        array(
            "login" => array(
                "type" => "string",
                "required" => true),
            "password" => array(
                "type" => "string",
                "required" => true),
            "timeout" => array(
                "type" => "int",
                "required" => false)),
        "Obtain a user authentication token which can be used for authenticating future API calls passing it as the parameter \"auth_token\"",
        'GET', false, false);
    expose_function(
        $api_suffix . "remove_token",
        $class_suffix . "remove_token",
        array(
            "token" => array(
                "type" => "string",
                "required" => true)),
        "Remove an API user authentication token from the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "lookup",
        $class_suffix . "lookup",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Returns basic information about an unknown object based on its id",
        'GET', false, true);
}

function expose_sta_functions(){
    $api_suffix = "clipit.sta.";
    $class_suffix = "ClipitSTA::";
    expose_common_functions($api_suffix, $class_suffix);
}

function expose_storyboard_functions(){
    $api_suffix = "clipit.storyboard.";
    $class_suffix = "ClipitStoryboard::";
    expose_common_functions($api_suffix, $class_suffix);
}

function expose_tag_functions(){
    $api_suffix = "clipit.tag.";
    $class_suffix = "ClipitTag::";
    expose_common_functions($api_suffix, $class_suffix);
}

function expose_task_functions(){
    $api_suffix = "clipit.task.";
    $class_suffix = "ClipitTask::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Task Activity",
        'GET', false, true);
}

function expose_tricky_topic_functions(){
    $api_suffix = "clipit.tricky_topic.";
    $class_suffix = "ClipitTrickyTopic::";
    expose_common_functions($api_suffix, $class_suffix);
}

function expose_user_functions(){
    $api_suffix = "clipit.user.";
    $class_suffix = "ClipitUser::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_by_login",
        $class_suffix . "get_by_login",
        array(
            "login_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by Login",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_email",
        $class_suffix . "get_by_email",
        array(
            "email_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by email. The result is a nested array, with an array of users per email.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_role",
        $class_suffix . "get_by_role",
        array(
            "role_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by role. The result is a nested array, with an array of users per role.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_groups",
        $class_suffix . "get_groups",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Get all Group Ids in which this user is a member of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_role_student",
        $class_suffix . "set_role_student",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_role_teacher",
        $class_suffix . "set_role_teacher",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_role_admin",
        $class_suffix . "set_role_admin",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_last_login",
        $class_suffix . "get_last_login",
        array(
            "user_id" => array(
                "type" => "int",
                "required" => true)),
        "Get the last login time for a User.",
        "GET", false, true);
}

function expose_video_functions(){
    $api_suffix = "clipit.video.";
    $class_suffix = "ClipitVideo::";
    expose_common_functions($api_suffix, $class_suffix);
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
        "Add Comments by Id to a Video",
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
        "Remove Comments by Id from a Video",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_comments",
        $class_suffix . "get_comments",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Comments from a Video",
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
        "Add Tags by Id to a Video",
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
        "Remove Tags by Id from a Video",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_tags",
        $class_suffix . "get_tags",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Tags from a Video",
        'GET', false, true);
}
