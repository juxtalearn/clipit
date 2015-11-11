<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/06/14
 * Last update:     16/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$groups = elgg_extract('entities', $vars);
$activity_id = elgg_extract('activity_id', $vars);
$user_id = elgg_get_logged_in_user_guid();
$groups = ClipitGroup::get_by_id($groups);
natural_sort_properties($groups, 'name');

foreach($groups as $group){
    $total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($group->id), $user_id, true));

    elgg_register_menu_item('groups:admin_'.$group->id, array(
        'name' => 'group_dashboard',
        'text' => elgg_echo('group:home'),
        'href' => "clipit_activity/{$activity_id}/group/{$group->id}",
        'priority' => 100,
        'aria-describedby' => "groupMenu",
    ));
    elgg_register_menu_item('groups:admin_'.$group->id, array(
        'name' => 'group_discussion',
        'text' => elgg_echo('group:discussion'),
        'href' => "clipit_activity/{$activity_id}/group/{$group->id}/discussion",
        'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
        'priority' => 200,
        'aria-describedby' => "groupMenu",
    ));
    elgg_register_menu_item('groups:admin_'.$group->id, array(
        'name' => 'group_files',
        'text' => elgg_echo('group:files'),
        'href' => "clipit_activity/{$activity_id}/group/{$group->id}/repository",
        'priority' => 300,
        'aria-describedby' => "groupMenu",
    ));
    $body .= '<ul class="nav nav-pills nav-stacked panel">';
    $body .= '<li>';
    $body .= elgg_view('output/url', array(
        'title' => $group->name,
        'href' => '#collapse_'.$group->id,
        'text'  => '<i class="pull-right fa fa-caret-down"></i>'. $group->name,
        'data-toggle' => 'collapse',
        'data-parent' => '#accordion',
        'aria-label' => $group->id,
        'aria-describedby' => "groupMenu",
    ));
    $body .= '</li>';
    $body .= elgg_view_menu('groups:admin_'.$group->id, array(
        'sort_by' => 'priority',
        'id' => 'collapse_'.$group->id,
        'class' => 'collapse'
    ));
    $body .= '</ul>';
}
?>

<?php echo elgg_view_module('aside',
    elgg_echo('activity:groups'),
    "<div id='accordion'>{$body}</div>", // Body
    array('class' => 'aside-tree'
    ));
?>