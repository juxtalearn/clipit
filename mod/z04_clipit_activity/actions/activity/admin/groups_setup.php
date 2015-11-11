<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

$groups = get_input('group');
$activity_id = get_input('entity-id');
$group_array = json_decode(get_input('groups_default'));

if(!empty($group_array)) {

    $i = 0;
    foreach ($group_array as $group_name => $users) {
        if ($group_name != "0") {
            $groups[$group_name] = array(
                'name' => $group_name,
            );
            $users_array = array();
            foreach ($users as $user) {
                if (!ClipitGroup::get_from_user_activity($user->id, $activity_id)) {
                    $users_array[] = $user->id;
                    $users_loaded[] = $user->id;
                }
            }
            $groups[$group_name]['users'] = implode(",", $users_array);
            if(empty($users_array)){
                unset($groups[$group_name]);
            }
        }
        $i++;
    }
}

foreach($groups as $group){
    $group_id = $group['id'];
    // check if group exists from excel file load
    if($groups[$group['name']] && $group_id){
        $group['users'] = $group['users'].",".$groups[$group['name']]['users'];
        unset($groups[$group['name']]);
    }elseif($groups[$group['name']] && !$group_id){
        $group_id = ClipitGroup::create(array(
            'name' => $group['name'],
        ));
    }
    if(ClipitSite::lookup($group_id)){
        if($group['remove']){
            ClipitGroup::delete_by_id(array($group_id));
        } elseif($group_id) {
            $groups_ids[] = $group_id;
            $users = explode(",", $group['users']);
            $users = array_filter($users);
            ClipitGroup::set_users($group_id, $users);
            ClipitGroup::set_properties($group_id, array('name' => $group['name']));
            ClipitActivity::add_students($activity_id, $users);
        }
    }

}
ClipitActivity::set_groups($activity_id, $groups_ids);

forward(REFERRER);
