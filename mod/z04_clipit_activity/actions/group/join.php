<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 12:43
 * To change this template use File | Settings | File Templates.
 */

$user_id = elgg_get_logged_in_user_guid();
$group_id = get_input('group-id');
$activity_id = ClipitGroup::get_activity($group_id);
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
$hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity_id);
$user_groups = ClipitUser::get_groups($user_id);

$total_users = count(ClipitGroup::get_users($group_id));
if(($total_users + 1) > $activity->max_group_size){
    register_error(elgg_echo("group:max_group_size:exceeded"));
    forward(REFERER);
}
if(!in_array($group_id, $user_groups) || !$hasGroup){
    ClipitGroup::add_users($group_id, array($user_id));
    system_message(elgg_echo('group:joined'));
} else {
    register_error(elgg_echo("group:cantjoin"));
}
forward(REFERER);