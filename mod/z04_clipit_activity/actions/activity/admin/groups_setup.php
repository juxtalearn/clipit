<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$groups = get_input('group');
$activity_id = get_input('entity-id');

foreach($groups as $group){
    $group_id = $group['id'];
    if(!$group_id){
        $group_id = ClipitGroup::create(array(
            'name' => $group['name'],
        ));
    }
    if($group['remove']){
        ClipitGroup::delete_by_id(array($group_id));
    } else {
        $groups_ids[] = $group_id;
        $users = explode(",", $group['users']);
        ClipitGroup::set_users($group_id, $users);
        ClipitGroup::set_properties($group_id, array('name' => $group['name']));
    }

}
ClipitActivity::set_groups($activity_id, $groups_ids);

forward(REFERRER);
