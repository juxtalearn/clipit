<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 6/03/14
 * Time: 13:10
 */


$message_id = (int)get_input('message-id');
$message = array_pop(ClipitMessage::get_by_id(array($message_id)));
$user_groups = ClipitUser::get_groups($user_id);
$message_reply = get_input('message-reply');

if(count($message)==0 || trim($message_reply) == "" ){
    register_error(elgg_echo("discussion:reply:cantcreate"));
} else{
    ClipitMessage::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $message->id,
    ));
    system_message(elgg_echo('discussion:reply:created'));
}

forward(REFERER);