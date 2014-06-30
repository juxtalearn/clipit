<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$user_id = elgg_get_logged_in_user_guid();

$params = array(
    'name' => 'activity_aprofile',
    'text' => elgg_echo('activity:profile'),
    'href' => "clipit_activity/".$activity->id,
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_sta',
    'text' => elgg_echo('activity:stas'),
    'href' => "clipit_activity/".$activity->id."/resources",
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_groups',
    'text' => elgg_echo('activity:groups'),
    'href' => "clipit_activity/".$activity->id."/groups",
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_tasks',
    'text' => elgg_echo('activity:tasks'),
    'href' => "clipit_activity/".$activity->id."/tasks",
);
elgg_register_menu_item('activity:menu', $params);

$total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($activity->id), $user_id, true));
$params = array(
    'name' => 'activity_discussion',
    'text' => elgg_echo('activity:discussion'),
    'href' => "clipit_activity/".$activity->id."/discussion",
    'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
);
elgg_register_menu_item('activity:menu', $params);
$params = array(
    'name' => 'activity_publications',
    'text' => elgg_echo('activity:publications'),
    'href' => "clipit_activity/".$activity->id."/publications",
);
elgg_register_menu_item('activity:menu', $params);

echo elgg_view_menu('activity:menu', array(
    'sort_by' => 'register',
));