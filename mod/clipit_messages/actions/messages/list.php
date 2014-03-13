<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/03/14
 * Last update:     12/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Options list
 * - Mark as read
 * - Mark as unread
 * - Delete
 */
$option = get_input("set-option");
$messages_id = get_input("check-msg");
$user_id = elgg_get_logged_in_user_guid();
switch($option){
    case "read":
        foreach($messages_id as $message_id){
            // Main message
            $message = array_pop(ClipitMessage::get_by_id(array($message_id)));
            if($message->destination == $user_id){
                ClipitMessage::set_read_status($message->id, true);
            }
            // Replies message
            $replies = ClipitMessage::get_replies($message_id);
            foreach($replies as $reply_id){
                $reply = array_pop(ClipitMessage::get_by_id(array($reply_id)));
                if($reply->owner_id != $user_id){
                    ClipitMessage::set_read_status($reply->id, true);
                }
            }
        }
        break;
    case "unread":
        foreach($messages_id as $message_id){
            // Main message
            $message = array_pop(ClipitMessage::get_by_id(array($message_id)));
            if($message->destination == $user_id){
                ClipitMessage::set_read_status($message->id, false);
            }
            // Replies message
            $replies = ClipitMessage::get_replies($message_id);
            foreach($replies as $reply_id){
                $reply = array_pop(ClipitMessage::get_by_id(array($reply_id)));
                if($reply->owner_id != $user_id){
                    ClipitMessage::set_read_status($reply->id, false);
                }
            }
        }
        break;
    case "remove":
        break;
    default:
        forward(REFERER);
        break;
}
forward(REFERER);