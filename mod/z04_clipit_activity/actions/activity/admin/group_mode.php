<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/09/14
 * Last update:     2/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$max_users = (int)get_input('max-users');
$group_mode = get_input('group-mode');
$activity_id = get_input('entity-id');

$called_users = ClipitActivity::get_students($activity_id);

switch($group_mode){
    // Teacher make groups
    case ClipitActivity::GROUP_MODE_TEACHER:
        break;
    // Student makes groups
    case ClipitActivity::GROUP_MODE_STUDENT:
        break;
    // Random
    case ClipitActivity::GROUP_MODE_SYSTEM:
        shuffle($called_users);
        $total_groups = ceil(count($called_users)/$max_users);
        $chunks = split_chunks($called_users, $total_groups);
        $num = 1;
        $groups = array();
        foreach($chunks as $users_array){
            $groups[] = ClipitGroup::create(array(
                'name' => elgg_echo('group'). " ". $num,
                'user_array' => $users_array
            ));
            $num++;
        }
        ClipitActivity::set_groups($activity_id, $groups);
        break;
}

ClipitActivity::set_properties($activity_id, array('group_mode' => $group_mode, 'max_group_size' => $max_users));

forward(REFERRER);