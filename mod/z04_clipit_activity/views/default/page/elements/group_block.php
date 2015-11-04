<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 26/02/14
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */

$activity_id = elgg_get_page_owner_guid();
$user_id = elgg_get_logged_in_user_guid();
$group_id = ClipitGroup::get_from_user_activity($user_id, $activity_id);
$group = array_pop(ClipitGroup::get_by_id(array($group_id)));
$activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));

if($activity->status == ClipitActivity::STATUS_ENROLL && $activity->group_mode == ClipitActivity::GROUP_MODE_STUDENT){
    $header = elgg_view_form('group/leave',
        array('class'   => 'pull-right'),
        array('entity'  => $group)
    );
}
$header .= elgg_view('output/url', array(
    'href'  => "clipit_activity/{$activity_id}/group/{$group->id}",
    'text'  => "<h3>{$group->name}</h3>",
    'title' => $group->name,
    'class' => 'text-truncate',
));

$body .= "<small>".elgg_echo('group:progress')."</small>";
$params_progress = array(
    'value' => get_group_progress($group->id),
    'width' => '100%',
);
$body .= elgg_view("page/components/progressbar", $params_progress);
$bodyd .= '
<ul class="nav nav-pills nav-stacked elgg-menu-group-tools elgg-menu-group-tools-default" role="menu" aria-label="group-tools" style="
    margin-top: 20px;
"><li class="elgg-menu-item-group-discussion" role="presentation" tabindex="-1"><span class="badge pull-right"></span><a href="http://clipit.es/dev/clipit_activity/16062/group/16076/discussion" badge="">Discusiones del grupo</a></li><li class="elgg-menu-item-group-files" role="presentation" tabindex="-1"><a href="http://clipit.es/dev/clipit_activity/16062/group/16076/repository">Materiales del grupo</a></li></ul>
';
// Group tools sidebar
if($group_id) {
    $total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($group_id), $user_id, true));
    elgg_register_menu_item('group:tools', array(
        'name' => 'group_discussion',
        'text' => elgg_echo('group:discussion'),
        'href' => "clipit_activity/" . $activity->id . "/group/{$group_id}/discussion",
        'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
        'priority' => 100,
    ));
    elgg_register_menu_item('group:tools', array(
        'name' => 'group_files',
        'text' => elgg_echo('group:files'),
        'href' => "clipit_activity/" . $activity->id . "/group/{$group_id}/repository",
        'priority' => 200,
    ));
    $tools = elgg_view_menu('group:tools', array(
        'sort_by' => 'priority',
    ));

    $body .= elgg_view_module('aside', false, $tools, array('class' => 'margin-top-20'));
}
// Module view
echo elgg_view('page/components/module', array(
    'header' => $header,
    'body' => $body,
    'class' => 'activity-group-block',
));
?>
