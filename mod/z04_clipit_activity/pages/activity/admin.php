<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/09/14
 * Last update:     9/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if($user->role == 'student'){
    return false;
}
$title = elgg_echo('activity:admin');
$href = "clipit_activity/{$activity->id}/admin";
$selected_tab = get_input('filter', 'setup');
$filter = elgg_view('activity/admin/filter', array('selected' => $selected_tab, 'href' => $href));
// dashboard, default admin view
switch($selected_tab){
    case 'tasks':
        $content = elgg_view('activity/admin/tasks/view', array('entity' => $activity));
        break;
    case 'setup':
        $setup_view = elgg_view('activity/admin/setup', array('entity' => $activity));
        $content = elgg_view_form('activity/admin/setup', array('body' => $setup_view, 'data-validate' => 'true'));
        break;
    case 'groups':
        $content = elgg_view('activity/admin/groups/view', array('entity' => $activity));
        break;
    case 'options':
        $content = elgg_view_form('activity/admin/options', array('data-validate' => 'true'));
        break;
}

$params = array(
    'content'   => $content,
    'filter'    => $filter,
    'class' => "activity-section activity-layout activity-admin-section",
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);