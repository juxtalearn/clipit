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
$content = '<div class="wrapper separator">';
foreach($my_groups_ids as $group_id){
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    $activity_id = ClipitGroup::get_activity($group_id);
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    $activity_link = elgg_view('output/url', array(
        'href' => "clipit_activity/{$activity->id}",
        'text' => $activity->name,
        'is_trusted' => true,
    ));
    $progress = get_group_progress($group_id);
    if($progress == 0){
        $progress = 5;
    }
    if($activity_id){
    $content .='<div class="bar" style="width:'.$progress.'%;background: #'.$activity->color.';">
                    <div>
                        <h4>'.$activity_link.'</a>
                            <small class="show">'.$group->name.'</small>
                        </h4>
                    </div>
                </div>';
    }
}
$content .= '</div>';


/*$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));*/
echo elgg_view('landing/module', array(
    'name'      => "activity_status",
    'title'     => elgg_echo('my_group:progress'),
    'content'   => $content,
    'all_link'  => $all_link,
));
