<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/06/14
 * Last update:     16/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$groups = elgg_extract('entities', $vars);
$activity_id = elgg_extract('activity_id', $vars);

foreach($groups as $group_id){
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_dashboard',
        'text' => elgg_echo('group:home'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}",
        'priority' => 100,
    ));
    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_discussion',
        'text' => elgg_echo('group:discussion'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}/discussion",
        'priority' => 200,
    ));
    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_files',
        'text' => elgg_echo('group:files'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}/multimedia",
        'priority' => 300,
    ));
    $body .= '<ul class="nav nav-pills nav-stacked panel">';
    $body .= '<li>';
    $body .= elgg_view('output/url', array(
        'title' => $group->name,
        'href' => '#collapse_'.$group->id,
        'text'  => '<i class="pull-right fa fa-caret-down"></i>'. $group->name,
        'data-toggle' => 'collapse',
        'data-parent' => '#accordion'
    ));
    $body .= '</li>';
    $body .= elgg_view_menu('groups:admin_'.$group_id, array(
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