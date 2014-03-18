<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 17:07
 * To change this template use File | Settings | File Templates.
 */

$user_id = elgg_get_logged_in_user_guid();
$group_id = get_input('group-id');
$group = array_pop(ClipitGroup::get_by_id(array($group_id)));
$user_groups = ClipitUser::get_groups($user_id);
$discussion_title = get_input('discussion-title');
$discussion_text = get_input('discussion-text');

if(count($group)==0 || !in_array($group->id, $user_groups) || trim($discussion_title) == "" || trim($discussion_text) == ""){
    register_error(elgg_echo("discussion:cantcreate"));
} else{
    ClipitMessage::create(array(
        'name' => $discussion_title,
        'description' => $discussion_text,
        'destination' => $group->id,
        'category'  => 'discussion'
    ));
    system_message(elgg_echo('discussion:created'));
}


forward(REFERER);