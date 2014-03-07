<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 17:07
 * To change this template use File | Settings | File Templates.
 */
$discussion_id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$message = array_pop(ClipitMessage::get_by_id(array($discussion_id)));

if(count($message)==0 || $message->owner_id != $user_id){
    register_error(elgg_echo("discussion:reply:cantdelete"));
} else{
    ClipitMessage::delete_by_id(array($discussion_id));
    system_message(elgg_echo('discussion:reply:deleted'));
}

forward(REFERER);