<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/04/14
 * Last update:     29/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_get_logged_in_user_entity();
$my_groups_ids = ClipitUser::get_groups($user->guid);

$id_activities_array = array();
foreach($my_groups_ids as $group_id){
    $id_activities_array[] = ClipitGroup::get_activity($group_id);
}

$my_activities = ClipitActivity::get_all();
$params_progress = array(
    'value' => 30,
    'width' => '100%'
);

$params_list = array(
    'items'         => $my_activities,
    'pagination'    => false,
    'list_class'    => 'my-activities',
    'full_view'     => false,
);
$content = elgg_view("activities/list", $params_list);

$sidebar = elgg_view("activities/sidebar/feed", array('my_groups' => $my_groups_ids));
$selected_tab = 'all';
$filter = elgg_view('activities/filter', array('selected' => $selected_tab, 'entity' => $activity));
$params = array(
    'content' => $content,
    'title' => elgg_echo("explore"),
    'filter' => $filter,
    'sidebar' => $sidebar,
    'class' => 'sidebar-lg main-md'
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
