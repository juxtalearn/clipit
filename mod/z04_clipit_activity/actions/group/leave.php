<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 13:23
 * To change this template use File | Settings | File Templates.
 */
$user_id = elgg_get_logged_in_user_guid();
$group_id = get_input('group-id');
$activity_id = ClipitGroup::get_activity($group_id);

$hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity_id);
$user_groups = ClipitUser::get_groups($user_id);

if(in_array($group_id, $user_groups) || $hasGroup){
    ClipitGroup::remove_users($group_id, array($user_id));
    // delete group when group have 1 user
    if(count(ClipitGroup::get_users($group_id)) == 0){
        ClipitGroup::delete_by_id(array($group_id));
    }
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    if($activity->public){
        ClipitActivity::remove_students($activity_id, array($user_id));
    }
} else{
    register_error(elgg_echo("group:cantleave"));
}


forward(REFERER);