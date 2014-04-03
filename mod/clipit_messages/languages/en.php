<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
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
$english = array(
    'message' => 'Message',
    'messages' => 'Messages',
    'messages:compose' => 'Compose a message',
    'messages:subject' => 'Subject',

    'messages:inbox' => 'Inbox',
    'messages:drafts' => 'Drafts',
    'messages:sent_email' => 'Sent mail',
    'messages:trash' => 'Trash',
    'messages:contactmembersgroup' => 'Contact group members',
    // Message
    'message:from'  => "From",
    'message:to'  => "To",
    'message:last_reply'  => "Last reply",
    'message:unread'  => "Unread",
    'message:notfound' => "Message not found",
    'message:options'  => "Options",
    'message:created' => "Your message was successfully sent.",
    'message:cantcreate' => "Could not send the message",
    'reply:created' => "Your reply was successfully sent.",
    'message:movetotrash' => "Move to trash",
    'message:movetoinbox' => "Move to inbox",
    'message:markasread' => "Mark as read",
    'message:markasunread' => "Mark as unread",
    'messages:read:marked' => "Messages marked as read",
    'messages:unread:marked' => "Messages marked as unread",
    'messages:removed' => "Messages removed",
    'messages:inbox:moved' => "Messages moved to inbox",
    'messages:error' => 'There was a problem with your message. Please try again.',
    'messages:error:messages_not_selected' => 'No messages selected',

    // Error pages: empty folders
    'messages:inbox:none' => "There are no messages in your inbox.",
    'messages:sent:none' => "There are no messages sent.",
    'messages:trash:none' => "There are no messages in your trash.",


    // Search
    'messages:search' => 'Search: %s',
    // Filter
    'messages:all' => 'All',
    'messages:private_msg' => 'Private messages',
    'messages:my_activities' => 'My activities',
    // Reply
    'reply:edit' => "Edit reply",
    'reply:create' => 'Create reply',
    'reply' => 'Reply',
    'reply:total' => '%s total replies',
    'reply:unreads' => '%s unread replies',
);

add_translation('en', $english);