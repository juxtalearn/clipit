<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$user_id = elgg_get_logged_in_user_guid();
$group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($group_id), $user_id, true));

elgg_register_menu_item('group:tools', array(
    'name' => 'group_dashboard',
    'text' => elgg_echo('group:home'),
    'href' => "clipit_activity/{$activity->id}/group/{$group_id}",
    'priority' => 100,
));
elgg_register_menu_item('group:tools', array(
    'name' => 'group_discussion',
    'text' => elgg_echo('group:discussion'),
    'href' => "clipit_activity/".$activity->id."/group/{$group_id}/discussion",
    'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
    'priority' => 200,
));
elgg_register_menu_item('group:tools', array(
    'name' => 'group_files',
    'text' => elgg_echo('group:files'),
    'href' => "clipit_activity/".$activity->id."/group/{$group_id}/repository",
    'priority' => 300,
));
$body = elgg_view_menu('group:tools', array(
    'sort_by' => 'priority',
));

echo elgg_view_module('aside', elgg_echo('group:tools'), $body, array('class' => 'group-tools-aside') );