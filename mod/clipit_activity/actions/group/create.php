<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
$user_id = elgg_get_logged_in_user_guid();
$activity_id = get_input('activity-id');
$user_group = ClipitGroup::get_from_user_activity($user_id, $activity_id);
$group_name = get_input('group-name');
$group_description = get_input('group-description');

if($user_group ||  trim($group_name) == ""){
    register_error(elgg_echo("group:cantcreate"));
} else{
    $group_id =ClipitGroup::create(array(
        'name' => $group_name,
        'description' => $group_description
    ));
    // add owner user to group
    ClipitGroup::add_users($group_id, array($user_id));
    // add group to activity
    ClipitActivity::add_groups($activity_id, array($group_id));

    system_message(elgg_echo('group:created'));
}


forward(REFERER);