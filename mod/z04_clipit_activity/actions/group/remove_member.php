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
$user_id = get_input('user-id');
$group_id = get_input('group-id');
$activity_id = ClipitGroup::get_activity($group_id);

$hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity_id);

if($hasGroup){
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    ClipitGroup::remove_users($group_id, array($user_id));
    // delete group when group have 1 user
    if(count(ClipitGroup::get_users($group_id)) == 0){
        ClipitGroup::delete_by_id(array($group_id));
    }
    system_message(elgg_echo("group:member:removed", array($user->name)));
} else{
    register_error(elgg_echo("group:member:cantremove"));
}


forward(REFERER);