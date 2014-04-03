<?php

/**
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 *
 * PHP version >= 5.2
 *
 * Creation date:   2013-06-19
 *
 * @category    theme
 * @package     clipit
 * @license    GNU Affero General Public License v3
 * http://www.gnu.org/licenses/agpl-3.0.txt
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3. *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details. *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */
elgg_register_event_handler('init', 'system', 'clipit_activity_init');

function clipit_activity_init() {
    elgg_register_library('clipit:activities', elgg_get_plugins_path() . 'clipit_activity/lib/activities.php');
    // Register "/my_activities" page handler
    elgg_register_page_handler('my_activities', 'my_activities_page_handler');
    // Register "/clipit_activity" page handler
    elgg_register_page_handler('clipit_activity', 'activity_page_handler');
//    elgg_register_entity_url_handler('object', 'clipit_activity', 'activity_url');
    elgg_register_event_handler('pagesetup', 'system', 'activity_setup_sidebar_menus');
    elgg_register_event_handler('pagesetup', 'system', 'group_details_setup_menus');

    // Register actions
    // File
    elgg_register_action("files/upload", elgg_get_plugins_path() . "clipit_activity/actions/files/upload.php");
    // Group
    elgg_register_action("group/join", elgg_get_plugins_path() . "clipit_activity/actions/group/join.php");
    elgg_register_action("group/leave", elgg_get_plugins_path() . "clipit_activity/actions/group/leave.php");
    elgg_register_action("group/create", elgg_get_plugins_path() . "clipit_activity/actions/group/create.php");
    elgg_register_action("group/remove_member", elgg_get_plugins_path() . "clipit_activity/actions/group/remove_member.php");
    // Discussion
    elgg_register_action("group/discussion/create", elgg_get_plugins_path() . "clipit_activity/actions/group/discussion/create.php");
    elgg_register_action("group/discussion/remove", elgg_get_plugins_path() . "clipit_activity/actions/group/discussion/remove.php");
    elgg_register_action("group/discussion/edit", elgg_get_plugins_path() . "clipit_activity/actions/group/discussion/edit.php");
    elgg_register_ajax_view('modal/discussion/edit');
}
function activity_setup_sidebar_menus(){
    $activity_id =  elgg_get_page_owner_guid();
    if (elgg_in_context('activity_page')) {
        $activities = ClipitActivity::get_by_id(array($activity_id));
        $activity = array_pop($activities);
        $params = array(
            'name' => 'activity_aprofile',
            'text' => elgg_echo('activity:profile'),
            'href' => "clipit_activity/".$activity->id,
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_groups',
            'text' => elgg_echo('activity:groups'),
            'href' => "clipit_activity/".$activity->id."/groups",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_sta',
            'text' => elgg_echo('activity:stas'),
            'href' => "clipit_activity/".$activity->id."/stas",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_publications',
            'text' => elgg_echo('activity:publications'),
            'href' => "settings/statistics/",
        );
        elgg_register_menu_item('page', $params);
    }

}


/**
 * Populates the ->getUrl() method for group objects
 *
 * @param ElggEntity $entity File entity
 * @return string File URL
 */
//function activity_url($entity) {
//    $title = elgg_get_friendly_title($entity->name);
//
//    return "activity_{$entity->id}";
//}

/**
 * Activity page handler
 *
 * URLs take the form of
 *  Activity site:    activity_<guid>
 *  List topics in forum:  discussion/owner/<guid>
 *  View discussion topic: discussion/view/<guid>
 *  Add discussion topic:  discussion/add/<guid>
 *  Edit discussion topic: discussion/edit/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function activity_page_handler($page) {
    $base_dir = elgg_get_plugins_path() . 'clipit_activity/pages/activity';
    elgg_load_library('clipit:activities');

    elgg_set_context("activity_page");
    $activities = ClipitActivity::get_by_id(array($page[0]));
    $activity = array_pop($activities);
    $user_id = elgg_get_logged_in_user_guid();
    $isCalled = ClipitActivity::get_called_users($activity->id);
    $hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    // Default status
    $activity_status = array_pop(ClipitActivity::get_status($activity->id));
    // Check if activity exists
    if (!$activity ) {
        return false;
    }
    elgg_set_page_owner_guid($activity->id);

    // Activity profile
    if(!isset($page[1])){
        elgg_push_breadcrumb($activity->name);
        $content = elgg_view('activity/profile/layout', array('entity' => $activity));
        $params = array(
            'content'   => $content,
            'title'     => $activity->name,
            'title_style' => "background: #". $activity->color,
            'filter'    => '',
            'class'     => 'activity-profile activity-layout'
        );
    } else {
    // Sections
        if(isset($page[1])){
            elgg_push_breadcrumb($activity->name, "clipit_activity/".$activity->id);
            switch ($page[1]) {
                case 'groups':
                    $title = elgg_echo("activity:groups");
                    elgg_push_breadcrumb($title);
                    $params = array(
                        'content'   => elgg_view('group/list', array('entity' => $activity)),
                        'filter'    => '',
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'join':
                    if($activity_status == 'active' || !$isCalled){
                        return false;
                    }
                    $title = elgg_echo("activity:join");
                    elgg_push_breadcrumb($title);
                    $params = array(
                        'content'   => elgg_view('activity/join', array('entity' => $activity)),
                        'filter'    => '',
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'stas':
                    $title = elgg_echo("activity:stas");
                    elgg_push_breadcrumb($title);
                    $selected_tab = get_input('filter', 'files');
                    switch ($selected_tab) {
                        case 'files':
                            $content = elgg_view('stas/files', array('entity' => $activity));
                            if (!$content) {
                                $content = elgg_echo('groups:none');
                            }
                            break;
                        case 'videos':
                            $content = elgg_view('stas/videos', array('entity' => $activity));
                            if (!$content) {
                                $content = elgg_echo('discussion:none');
                            }
                            break;
                        case 'links':
                        default:
                            $content = elgg_view('stas/links', array('entity' => $activity));
                            if (!$content) {
                                $content = elgg_echo('groups:none');
                            }
                            break;
                    }
                    $filter = elgg_view('stas/sta_types_menu', array('selected' => $selected_tab, 'entity' => $activity));
                    $params = array(
                        'content'   => $content,
                        'filter'    => $filter,
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'group':
                    $params = group_tools_page_handler($page, $activity);
                    break;
                default:
                    return false;
            }
        }
    }
    if(!$params){
        return false;
    }
    $group_tools_sidebar = "";
    // Group sidebar components (group block info + group tools)
    if($hasGroup){
        elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
        $group_tools_sidebar = elgg_view('group/sidebar/group_tools', array('entity' => $activity));
    }
    if(!$hasGroup && $isCalled && $activity_status == 'enroll') {
        // Join to activity button
        elgg_extend_view("page/elements/owner_block", "page/components/button_join_activity");
    }
    //$params['sidebar'] = elgg_view('activity/sidebar/teacher', array('entity' => $activity));
    $teacher_sidebar = elgg_view('activity/sidebar/teacher', array('entity' => $activity));

    $params['sidebar'] = $teacher_sidebar . $group_tools_sidebar;
    if(!$params['class']){
        $params['class'] = "activity-section activity-layout";
    }
    $body = elgg_view_layout('one_sidebar', $params);
    echo elgg_view_page($params['title'], $body);

    return true;
}


/**
 * Group tools sections
 *
 * @param $page
 * @param $activity
 * @return array|bool
 */
function group_tools_page_handler($page, $activity){
    $user_id = elgg_get_logged_in_user_guid();
    $group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    if(!$group){
        return false;
    }
    elgg_push_breadcrumb($group->name);
    // set group icon status from activity status
    $activity_status = array_pop(ClipitActivity::get_status($activity->id));
    $icon_status = "lock";
    if($activity_status == 'enroll'){
        $icon_status = "unlock";
    }
    $group_name = '<i class="fa fa-'.$icon_status.'"></i> '.$group->name;

    switch ($page[2]) {
        case 'edit':
            $title = elgg_echo("group:edit");
            elgg_push_breadcrumb($title);
            $params = array(
                'content'   => elgg_view('group/edit', array('entity' => $activity)),
            );
            break;
        case 'members':
            $title = elgg_echo("group:members");
            elgg_push_breadcrumb($title);
            $params = array(
                'content'   => elgg_view('group/members', array('entity' => $group)),
            );
            break;
        case 'activity_log':
            $title = elgg_echo("group:activity_log");
            elgg_push_breadcrumb($title);
            $params = array(
                'content'   => elgg_view('group/activity_log', array('entity' => $group)),
            );
            break;
        case 'files':
            $title = elgg_echo("group:files");
            elgg_push_breadcrumb($title);
            $params = array(
                'content'   => elgg_view('group/files/list', array('entity' => $group)),
            );
            if($page[3] == 'view' && $page[4]){
                $file_id = (int)$page[4];
                $file = array_pop(ClipitFile::get_by_id(array($file_id)));
                $group_files = ClipitGroup::get_files($group->id);
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/group/files");
                elgg_push_breadcrumb($file->name);
                if($file && in_array($file_id, $group_files)){
                    $params = array(
                        'content'   => elgg_view('group/files/view', array('entity' => $file)),
                    );
                } else {
                    return false;
                }
            }
            break;
        case 'discussion':
            $title = elgg_echo("group:discussion");
            elgg_push_breadcrumb($title);
            $params = array(
                'content'   => elgg_view('group/discussion/list', array('entity' => $group)),
            );
            if($page[3] == 'view' && $page[4]){
                $message_id = (int)$page[4];
                $message = array_pop(ClipitMessage::get_by_id(array($message_id)));
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/group/discussion");
                elgg_push_breadcrumb($message->name);
                if($message && $message->destination == $group->id){
                    $params = array(
                        'content'   => elgg_view('group/discussion/view', array('entity' => $message)),
                    );
                } else {
                    return false;
                }
            }
            break;
        default:
            return false;
    }
    // Default group params
    $params['filter'] = "";
    $params['title'] = $title;
    $params['sub-title'] = $group_name;
    $params['title_style'] = "background: #". $activity->color;

    if($activity_status == 'enroll'){
        $params['special_header_content'] = elgg_view_form("group/leave",
            array('class' => 'pull-right'),
            array('entity' => $group, 'text' => elgg_echo("group:leave:me")));
    }

    return $params;
}

/**
 * My activities page handler
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function my_activities_page_handler($page) {
    $current_user = elgg_get_logged_in_user_entity();

    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }

    $base_dir = elgg_get_plugins_path() . 'clipit_activity/pages/activity';
    $vars = array();
	$vars['page'] = $page[0];

    require_once "$base_dir/my_activities.php";

    return true;

}
