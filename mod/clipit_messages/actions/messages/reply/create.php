<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 6/03/14
 * Time: 13:10
 */


$message_id = (int)get_input('message-id');
$message = array_pop(ClipitMessage::get_by_id(array($message_id)));
$message_reply = get_input('message-reply');
$category = get_input('message-category');

$categories_accepted = array('pm', 'discussion');

if(count($message)==0 || trim($message_reply) == "" || !in_array($category, $categories_accepted)){
    register_error(elgg_echo("reply:cantcreate"));
} else{
    ClipitMessage::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $message->id,
        'category'  => $category
    ));
    system_message(elgg_echo('reply:created'));
}

forward(REFERER);