<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

/**
 * Options list
 * - Mark as read
 * - Mark as unread
 * - Delete
 */
$option = get_input("set-option");
$users_sender = get_input("check-msg");
$user_id = elgg_get_logged_in_user_guid();
if(empty($users_sender)){
    register_error(elgg_echo("messages:error:messages_not_selected"));
}
switch($option){
    case "read":
        foreach($users_sender as $user_sender){
            $messages_conversation = ClipitChat::get_conversation($user_id, $user_sender);
            foreach($messages_conversation as $message_conversation){
                ClipitChat::set_read_status($message_conversation->id, true, array($user_id));
            }
            system_message(elgg_echo('messages:read:marked'));
        }
        break;
    case "unread":
        foreach($users_sender as $user_sender){
            $messages_conversation = ClipitChat::get_conversation($user_id, $user_sender);
            foreach($messages_conversation as $message_conversation){
                ClipitChat::set_read_status($message_conversation->id, false, array($user_id));
            }
        }
        system_message(elgg_echo('messages:unread:marked'));
        break;
    case "remove":
        foreach($users_sender as $user_sender){
            $messages_conversation = ClipitChat::get_conversation($user_id, $user_sender);
            foreach($messages_conversation as $message_conversation){
                ClipitChat::set_archived_status($message_conversation->id, true, array($user_id));
            }
        }
        system_message(elgg_echo('messages:removed'));
        break;
    case "to_inbox":
        $messages_id = $users_sender;
//        foreach($messages_id as $message_id){
//            // Main message
//            $message = array_pop(ClipitMessage::get_by_id(array($message_id)));
//            ClipitMessage::set_archived_status($message->id, false, array($user_id));
//            // Replies message
//            $replies = ClipitMessage::get_replies($message_id);
//            foreach($replies as $reply_id){
//                $reply = array_pop(ClipitMessage::get_by_id(array($reply_id)));
//                ClipitMessage::set_archived_status($reply->id, false, array($user_id));
//            }
//            system_message(elgg_echo('messages:inbox:moved'));
//        }
        foreach($messages_id as $message_id){
            ClipitChat::set_archived_status((int)$message_id, false, array($user_id));
        }
        system_message(elgg_echo('messages:inbox:moved'));
        break;
    default:
        register_error(elgg_echo("messages:error"));
        break;
}
forward(REFERER);