<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 17:07
 * To change this template use File | Settings | File Templates.
 */

$user_id = elgg_get_logged_in_user_guid();
$discussion_id = get_input('message-id');
$discussion = array_pop(ClipitMessage::get_by_id(array($discussion_id)));

$discussion_title = get_input('discussion-title');
$discussion_text = get_input('discussion-text');

if(!isset($discussion) || $discussion->owner_id != $user_id || trim($discussion_text) == ""){
    register_error(elgg_echo("discussion:reply:cantedit"));
} else{
    ClipitMessage::set_properties($discussion->id, array(
        'description' => $discussion_text
    ));
    system_message(elgg_echo('discussion:reply:edited'));
}


forward(REFERER);