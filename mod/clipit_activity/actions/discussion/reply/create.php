<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$message_id = (int)get_input('message-id');
$message = array_pop(ClipitPost::get_by_id(array($message_id)));
$message_reply = get_input('message-reply');
$user_id = elgg_get_logged_in_user_guid();

if(count($message)==0 || trim($message_reply) == ""){
    register_error(elgg_echo("reply:cantcreate"));
} else{
    $new_message_id = ClipitPost::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $message->id,
    ));
    // set read status true to the owner's message
    ClipitPost::set_read_status($new_message_id, true, array($user_id));

    system_message(elgg_echo('reply:created'));
}

forward(REFERER);