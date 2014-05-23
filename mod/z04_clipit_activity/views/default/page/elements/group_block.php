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

$header = "<h3 class='text-truncate' title='{$group->name}'>
            <a class='group-menu toggle-menu-link' id='group-menu' data-toggle='dropdown' href='javascript:;'>
                <i class='fa fa-bars' title='".elgg_echo("group:menu")."'></i>
            </a>
            {$group->name}
           </h3>";
// Group menu settings
$params = array(
    'name' => 'group_edit',
    'text' => elgg_echo('group:edit'),
    'href' => "clipit_activity/{$activity_id}/group/edit",
);
elgg_register_menu_item('group_menu', $params);
$params = array(
    'name' => 'group_members',
    'text' => elgg_echo('group:members'),
    'href' => "clipit_activity/{$activity_id}/group/members",
);
elgg_register_menu_item('group_menu', $params);

$header .= elgg_view_menu('group_menu', array(
    'sort_by' => 'name',
    'class' => 'toggle-menu',
));

$body .= "<small>Progress</small>";
$params_progress = array(
    'value' => 30,
    'width' => '100%',
);
$body .= elgg_view("page/components/progressbar", $params_progress);
$body .= elgg_view("page/components/next_deadline", array('entity' => $group));
// Module view
echo elgg_view('page/components/module', array(
    'header' => $header,
    'body' => $body,
    'class' => 'activity-group-block',
));
?>
