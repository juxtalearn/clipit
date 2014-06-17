<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 13/02/14
 * Time: 14:04
 * To change this template use File | Settings | File Templates.
 */
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$selected_tab = get_input('filter', 'all');

$id_activities_array = array();
// Group members
$my_groups_ids = ClipitUser::get_groups($user_id);
foreach($my_groups_ids as $group_id){
    //$id_activities_array[] = ClipitGroup::get_activity($group_id);
    $activity_id = ClipitGroup::get_activity($group_id);
    $status = ClipitActivity::get_status($activity_id);
    if($selected_tab == 'all'){
        $id_activities_array[$selected_tab][] = $activity_id;
    } else {
        $id_activities_array[$status][] = $activity_id;
    }
}
// Teacher activities
if($user->role == 'teacher'){
    $my_groups_ids = ClipitUser::get_groups($user_id);
    foreach($my_groups_ids as $group_id){
        //$id_activities_array[] = ClipitGroup::get_activity($group_id);
        $activity_id = ClipitGroup::get_activity($group_id);
        $status = ClipitActivity::get_status($activity_id);
        if($selected_tab == 'all'){
            $id_activities_array[$selected_tab][] = $activity_id;
        } else {
            $id_activities_array[$status][] = $activity_id;
        }
    }
}

$my_activities = ClipitActivity::get_by_id($id_activities_array[$selected_tab]);

$params_list = array(
    'items'         => $my_activities,
    'pagination'    => false,
    'list_class'    => 'my-activities',
    'full_view'     => false,
);
$content = elgg_view("activities/list", $params_list);


$filter = elgg_view('activities/filter', array('selected' => $selected_tab, 'entity' => $activity));

if(!$my_activities){
    $content = elgg_view('output/empty', array('value' => elgg_echo('activities:none')));
}
$params = array(
    'content' => $content,
    'title' => elgg_echo("my_activities"),
    'filter' => $filter,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);
