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
$english = array(
    'message' => 'Message',
    'messages' => 'Messages',
    'messages:compose' => 'Compose a message',
    'messages:subject' => 'Subject',
    'message:send' => 'Send a message',

    'messages:inbox' => 'Inbox',
    'messages:drafts' => 'Drafts',
    'messages:sent_email' => 'Sent mail',
    'messages:trash' => 'Trash',
    'messages:contactmembersgroup' => 'Contact group members',
    // Message
    'message:from'  => "From",
    'message:to'  => "To",
    'message:to_students' => 'To students from my activity',
    'message:last_reply'  => "Last reply",
    'message:unread'  => "unread",
    'message:notfound' => "Message not found",
    'message:options'  => "Options",
    'message:created' => "Your message was successfully sent.",
    'message:cantcreate' => "Could not send the message",
    'reply:deleted' => "Discussion reply has been deleted.",
    'reply:created' => "Your reply was successfully sent.",
    'reply:cantdelete' => 'Cannot delete message',
    'reply:cantedit' => 'Cannot edit message',
    'reply:edited' => 'Message edited',
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
    'messages:unreads' => '%s unread messages',

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