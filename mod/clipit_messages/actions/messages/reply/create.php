<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 6/03/14
 * Time: 13:10
 */


$user_id = (int)get_input('user-id');
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$message_reply = get_input('message-reply');

if(!$user || trim($message_reply) == "" ){
    register_error(elgg_echo("reply:cantcreate"));
} else{
    ClipitChat::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $user->id,
    ));
    system_message(elgg_echo('reply:created'));
}

forward(REFERER);