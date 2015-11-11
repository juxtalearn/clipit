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

$message_id = (int)get_input('message-id');
$message = array_pop(ClipitPost::get_by_id(array($message_id)));
$message_reply = get_input('message-reply');
$file_ids = get_input('file-id');
$user_id = elgg_get_logged_in_user_guid();

if(count($message)==0 || trim($message_reply) == ""){
    register_error(elgg_echo("reply:cantcreate"));
} else{

    $new_message_id = ClipitPost::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $message->id,
    ));
    if($file_ids){
        ClipitPost::add_files($new_message_id, $file_ids);
    }
    // set read status true to the owner's message
    ClipitPost::set_read_status($new_message_id, true, array($user_id));
    system_message(elgg_echo('reply:created'));
}

forward(REFERER);