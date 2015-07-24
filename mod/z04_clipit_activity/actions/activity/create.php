<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/07/14
 * Last update:     16/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

// Activity setup
$activity_name = get_input('activity-title');
$activity_description = get_input('activity-description');
$activity_start = get_input('activity-start');
$activity_end = get_input('activity-end');
$activity_tt = get_input('tricky-topic');
$advanced_options = get_input('activity');
// Grouping mode
$groups_creation = get_input('groups_creation');
$max_users = get_input('max-users');

$activity_data = array(
    'name' => $activity_name,
    'description' => $activity_description,
    'start' => get_timestamp_from_string($activity_start)+(60*1),
    'end' => get_timestamp_from_string($activity_end)+(60*60*24)-(60*1),
    'tricky_topic' => $activity_tt
);
if($advanced_options['is_open']){
    $groups_creation = 3; // Random groups
    $max_users[3] = $advanced_options['max_group_size'];
    $activity_data = array_merge($activity_data, array(
        'is_open' => $advanced_options['is_open'],
        'group_mode' => ClipitActivity::GROUP_MODE_STUDENT,
        'max_group_size' => $advanced_options['max_group_size'],
        'max_students' => $advanced_options['max_students'],
    ));
}

$activity_id = ClipitActivity::create($activity_data);
// Tasks
$tasks = get_input('task');
foreach($tasks as $task){

    if($task['title']) {
        elgg_trigger_plugin_hook('task:save', 'task', array(
            'task' => $task,
            'activity_id' => $activity_id,
            'activity_create' => true
        ), true);
    }
}
// Called users
$called_users = get_input('called_users');
ClipitActivity::add_students($activity_id, $called_users);
/**
 * Groups creation
 */
$filter = false;

$groups = array();
$group_array = json_decode(get_input('groups_default'));
if(!empty($group_array)) {
    $users_loaded = array();
    $i = 0;
    foreach ($group_array as $group_name => $users) {
        if ($group_name != "0") {
            $groups[$group_name] = array(
                'name' => $group_name,
            );
            $users_array = array();
            foreach ($users as $user) {
                if (in_array($user->id, $called_users)) {
                    $users_array[] = $user->id;
                    $users_loaded[] = $user->id;
                }
            }
            $groups[$group_name]['users'] = implode(",", $users_array);
        }
        $i++;
    }
    $called_users = array_diff($called_users, $users_loaded);
}

switch($groups_creation){
    // Teacher make groups
    case 1:
        $group_mode = ClipitActivity::GROUP_MODE_TEACHER;

        $filter = "?filter=groups";
        break;
    // Students make groups
    case 2:
        $group_mode = ClipitActivity::GROUP_MODE_STUDENT;
        shuffle($called_users);
        $total_groups = ceil(count($called_users)/$max_users[2]);
        $chunks = split_chunks($called_users, $total_groups);
        $num = 1;
        foreach($chunks as $users_array){
            $groups[] = array(
                'name' => elgg_echo('group'). " ". $num,
            );
            $num++;
        }
        ClipitActivity::set_properties($activity_id, array('max_group_size' => $max_users[2]));
        break;
    // Random
    case 3:
        shuffle($called_users);
        $total_groups = ceil(count($called_users)/$max_users[3]);
        $chunks = split_chunks($called_users, $total_groups);
        $num = 1;
        foreach($chunks as $users_array){
            $groups[] = array(
                'name' => elgg_echo('group'). " ". $num,
                'users' => implode(",", $users_array)
            );
            $num++;
        }
        ClipitActivity::set_properties($activity_id, array('max_group_size' => $max_users[3]));
        $group_mode = ClipitActivity::GROUP_MODE_SYSTEM;
        break;
}
ClipitActivity::set_properties($activity_id, array('group_mode' => $group_mode));
if($groups_creation){
    foreach($groups as $group){
        $group_id = ClipitGroup::create(array(
            'name' => $group['name'],
        ));
        if($group['users']){
            $users = explode(",", $group['users']);
            ClipitGroup::add_users($group_id, $users);
        }
        ClipitActivity::add_groups($activity_id, array($group_id));
    }
}
// Add me as teacher
$user_id = elgg_get_logged_in_user_guid();
ClipitActivity::add_teachers($activity_id, array($user_id));

$object = ClipitSite::lookup($activity_id);
system_message(elgg_echo("activity:created", array($object['name'])));
forward("clipit_activity/{$activity_id}/admin".$filter);