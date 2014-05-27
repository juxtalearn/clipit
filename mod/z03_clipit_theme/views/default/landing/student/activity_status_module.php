<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:30
 * To change this template use File | Settings | File Templates.
 */
$user = elgg_get_logged_in_user_entity();
$my_groups_ids = ClipitUser::get_groups($user->guid);

$id_activities_array = array();
foreach($my_groups_ids as $group_id){
    $id_activities_array[] = ClipitGroup::get_activity($group_id);
}

$my_activities = ClipitActivity::get_by_id($id_activities_array);
$content = '<div class="wrapper separator">';

if(is_array($my_activities)){
    foreach($my_activities as $activity){
        $activity->progress = mt_rand(1,100);
        $activity_link = elgg_view('output/url', array(
            'href' => "clipit_activity/{$activity->id}",
            'text' => $activity->name,
            'is_trusted' => true,
        ));
        $content .='<div class="bar" style="width:'.$activity->progress.'%;background: #'.$activity->color.';">
                        <h3>'.$activity_link.'</a></h3>
                    </div>';
    }
}
$content .= '</div>';

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "activity_status",
    'title'     => "Activity status",
    'content'   => $content,
    'all_link'  => $all_link,
));
