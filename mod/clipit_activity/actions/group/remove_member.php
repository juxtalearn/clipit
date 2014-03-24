<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/03/14
 * Last update:     24/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
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