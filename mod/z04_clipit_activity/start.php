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
elgg_register_event_handler('init', 'system', 'clipit_activity_init');

function clipit_activity_init() {
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    /**
     * Register clipit libraries
     */
    elgg_register_library('clipit:activities', elgg_get_plugins_path() . 'z04_clipit_activity/lib/activities.php');
    elgg_register_library('clipit:activity:functions', elgg_get_plugins_path() . 'z04_clipit_activity/lib/functions.php');
    elgg_load_library('clipit:activity:functions');
    // Publications
    elgg_register_library('clipit:activity:publications', elgg_get_plugins_path() . 'z04_clipit_activity/lib/publications.php');
    elgg_load_library('clipit:activity:publications');
    // Discussions
    elgg_register_library('clipit:activity:discussions', elgg_get_plugins_path() . 'z04_clipit_activity/lib/discussions.php');
    elgg_load_library('clipit:activity:discussions');
    // Multimedia
    elgg_register_library('clipit:activity:multimedia', elgg_get_plugins_path() . 'z04_clipit_activity/lib/multimedia.php');
    elgg_load_library('clipit:activity:multimedia');

    // Special views for role = teacher
    if($user->role == 'teacher'){
        // Create activity
        elgg_extend_view("navigation/menu/top", "navigation/menu/create_activity", 50);
        elgg_register_page_handler('create_activity', 'create_activity_page_handler');
    }
    // My activities list (top header)
    elgg_extend_view("navigation/menu/top", "navigation/menu/my_activities", 100);

    // Register "/my_activities" page handler
    elgg_register_page_handler('my_activities', 'my_activities_page_handler');
    // Register "/file" page handler
    elgg_register_page_handler('file', 'file_page_handler');
    // Register "/z04_clipit_activity" page handler
    elgg_register_page_handler('clipit_activity', 'activity_page_handler');
//    elgg_register_entity_url_handler('object', 'z04_clipit_activity', 'activity_url');

    // Register actions & ajax views
    $actions_dir = elgg_get_plugins_path() . "z04_clipit_activity/actions";
    // Create Activity
    elgg_register_action("activity/create/add_users", "{$actions_dir}/activity/add_users.php");
    elgg_register_action("activity/create/add_users_upload", "{$actions_dir}/activity/add_users_upload.php");
    elgg_register_action("activity/create", "{$actions_dir}/activity/create.php");
    elgg_register_ajax_view('activity/create/task_list');
    elgg_register_ajax_view('activity/create/groups/create');
    // Admin activity
    elgg_register_action("activity/admin/setup", "{$actions_dir}/activity/admin/setup.php");
    elgg_register_action("activity/admin/teachers", "{$actions_dir}/activity/admin/teachers.php");
    elgg_register_action("activity/admin/groups_setup", "{$actions_dir}/activity/admin/groups_setup.php");
    elgg_register_action("activity/admin/groups_create", "{$actions_dir}/activity/admin/groups_create.php");
    elgg_register_action("activity/admin/group_mode", "{$actions_dir}/activity/admin/group_mode.php");
    elgg_register_action("task/edit", "{$actions_dir}/task/edit.php");
    elgg_register_action("task/remove", "{$actions_dir}/task/remove.php");
    elgg_register_action("task/create", "{$actions_dir}/task/create.php");

    elgg_register_ajax_view('activity/admin/groups/users_list');
    elgg_register_ajax_view('activity/admin/group_info');
    elgg_register_ajax_view('publications/admin/user_ratings');
    elgg_register_ajax_view('modal/activity/admin/user_stats');
    elgg_register_ajax_view('modal/activity/admin/users_task');
    elgg_register_ajax_view('modal/task/edit');

    // Group
    elgg_register_action("group/join", "{$actions_dir}/group/join.php");
    elgg_register_action("group/leave", "{$actions_dir}/group/leave.php");
    elgg_register_action("group/create", "{$actions_dir}/group/create.php");
    elgg_register_action("group/remove_member", "{$actions_dir}/group/remove_member.php");
    elgg_register_ajax_view('modal/group/view');
    elgg_register_ajax_view('multimedia/attach/videos');
    elgg_register_ajax_view('multimedia/attach/storyboards');
    elgg_register_ajax_view('multimedia/attach/files');
    // Tricky Topic
    elgg_register_ajax_view('modal/tricky_topic/view');
    elgg_register_ajax_view('tricky_topic/list');
    // Multimedia
    /* Videos */
    elgg_register_action("multimedia/videos/add", "{$actions_dir}/multimedia/videos/add.php");
    elgg_register_action("multimedia/videos/remove", "{$actions_dir}/multimedia/videos/remove.php");
    elgg_register_action("multimedia/videos/edit", "{$actions_dir}/multimedia/videos/edit.php");
    elgg_register_action("multimedia/videos/publish", "{$actions_dir}/multimedia/videos/publish.php");
    elgg_register_ajax_view('modal/multimedia/video/edit');
    elgg_register_ajax_view('modal/multimedia/video/publish');
    /* Files */
    elgg_register_action("multimedia/files/upload", "{$actions_dir}/multimedia/files/upload.php");
    elgg_register_action("multimedia/files/remove", "{$actions_dir}/multimedia/files/remove.php");
    elgg_register_action("multimedia/files/edit", "{$actions_dir}/multimedia/files/edit.php");
    elgg_register_action("multimedia/files/set_options", "{$actions_dir}/multimedia/files/set_options.php");
    elgg_register_ajax_view('modal/multimedia/file/edit');
    elgg_register_ajax_view('multimedia/file/viewer');
    elgg_register_ajax_view('multimedia/file/upload');
    elgg_register_ajax_view('multimedia/file/attach_action');
    elgg_register_action("multimedia/videos/extract_data", "{$actions_dir}/multimedia/videos/extract_data.php");
    elgg_register_action("multimedia/files/upload", "{$actions_dir}/multimedia/files/upload.php");
    /* Storyboards */
    elgg_register_action("storyboards/upload", "{$actions_dir}/storyboards/upload.php");
    elgg_register_action("multimedia/storyboards/edit", "{$actions_dir}/multimedia/storyboards/edit.php");
    elgg_register_action("multimedia/storyboards/set_options", "{$actions_dir}/multimedia/storyboards/set_options.php");
    elgg_register_action("multimedia/storyboards/remove", "{$actions_dir}/multimedia/storyboards/remove.php");
    elgg_register_ajax_view('modal/multimedia/storyboard/edit');
    // Publications
    elgg_register_action("publications/evaluate", "{$actions_dir}/publications/evaluate.php");
    elgg_register_action("publications/publish", "{$actions_dir}/publications/publish.php");
    elgg_register_action("publications/labels/add", "{$actions_dir}/publications/labels/add.php");
    elgg_register_ajax_view('modal/publications/rating');
    elgg_register_ajax_view('publications/labels/search');
    // Discussion
    elgg_register_action("discussion/create", "{$actions_dir}/discussion/create.php");
    elgg_register_action("discussion/create_from_multimedia", "{$actions_dir}/discussion/create_from_multimedia.php");
    elgg_register_action("discussion/remove", "{$actions_dir}/discussion/remove.php");
    elgg_register_action("discussion/edit", "{$actions_dir}/discussion/edit.php");
    elgg_register_ajax_view('modal/discussion/edit');
    elgg_register_action("discussion/reply/create", "{$actions_dir}/discussion/reply/create.php");
    elgg_register_action("discussion/reply/remove", "{$actions_dir}/discussion/reply/remove.php");
    elgg_register_action("discussion/reply/edit", "{$actions_dir}/discussion/reply/edit.php");
    elgg_register_ajax_view('modal/discussion/reply/edit');
    elgg_register_ajax_view('discussion/quote');

    // Register javascript files
    $vendors_dir = elgg_get_site_url() . "mod/z04_clipit_activity/vendors";
    $files_upload_js = elgg_get_simplecache_url('js', 'upload');
    elgg_register_simplecache_view('js/upload');
    elgg_register_js('file:upload', $files_upload_js);
    // Raty js modified by clipit
    elgg_register_js('jquery:raty', "{$vendors_dir}/jquery.raty.js");
    elgg_load_js("jquery:raty");
    // Tag-it
    elgg_register_js('jquery:tag_it', "{$vendors_dir}/jquery.tag-it.min.js");
    elgg_load_js("jquery:tag_it");
    // Activity javascript libraries
    $activity_js = elgg_get_simplecache_url('js', 'activity');
    elgg_register_simplecache_view('js/activity');
    elgg_register_js('clipit:activity', $activity_js);
    elgg_load_js('clipit:activity');
    // Attach files
    $files_attach_js = elgg_get_simplecache_url('js', 'attach');
    elgg_register_simplecache_view('js/attach');
    elgg_register_js('file:attach', $files_attach_js);
    // jQuery file upload
    elgg_register_js("jquery:fileupload:tmpl", "{$vendors_dir}/fileupload/tmpl.min.js");
    elgg_register_js("jquery:fileupload:load_image", "{$vendors_dir}/fileupload/load-image.min.js");
    elgg_register_js("jquery:fileupload:iframe_transport", "{$vendors_dir}/fileupload/iframe-transport.js");
    elgg_register_js("jquery:fileupload", "{$vendors_dir}/fileupload/fileupload.js");
    elgg_register_js("jquery:fileupload:process", "{$vendors_dir}/fileupload/fileupload-process.js");
    elgg_register_js("jquery:fileupload:image", "{$vendors_dir}/fileupload/fileupload-image.js");
    elgg_register_js("jquery:fileupload:validate", "{$vendors_dir}/fileupload/fileupload-validate.js");
    elgg_register_js("jquery:fileupload:ui", "{$vendors_dir}/fileupload/fileupload-ui.js");
    elgg_load_js("jquery:fileupload:tmpl");
    elgg_load_js("jquery:fileupload:load_image");
    elgg_load_js("jquery:fileupload:iframe_transport");
    elgg_load_js("jquery:fileupload");
    elgg_load_js("jquery:fileupload:process");
    elgg_load_js("jquery:fileupload:image");
    elgg_load_js("jquery:fileupload:validate");
    elgg_load_js("jquery:fileupload:ui");
    // jQuery Multi-select
    elgg_register_js("jquery:multiselect", "{$vendors_dir}/jquery.multi-select.js");
    // jQuery QuickSearch
    elgg_register_js("jquery:quicksearch", "{$vendors_dir}/jquery.quicksearch.js");
    // FullCalendar
    elgg_register_js("fullcalendar:moment", "{$vendors_dir}/fullcalendar/moment.min.js");
    elgg_register_js("fullcalendar", "{$vendors_dir}/fullcalendar/fullcalendar.min.js");
    elgg_register_css("fullcalendar", "{$vendors_dir}/fullcalendar/fullcalendar.css");
}
function activity_setup_sidebar_menus(){
    $activity_id =  elgg_get_page_owner_guid();
    $user_id = elgg_get_logged_in_user_guid();
    $hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity_id);
    if (elgg_in_context('activity_page')) {
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $isTeacher = in_array($user_id, $activity->teacher_array);
        if(!$hasGroup && !$isTeacher){
            return false;
        }
        $params = array(
            'name' => 'activity_aprofile',
            'text' => elgg_echo('activity:profile'),
            'href' => "clipit_activity/".$activity->id,
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_sta',
            'text' => elgg_echo('activity:stas'),
            'href' => "clipit_activity/".$activity->id."/resources",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_groups',
            'text' => elgg_echo('activity:groups'),
            'href' => "clipit_activity/".$activity->id."/groups",
        );
        elgg_register_menu_item('page', $params);

        $total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($activity_id), $user_id, true));
        $params = array(
            'name' => 'activity_discussion',
            'text' => elgg_echo('activity:discussion'),
            'href' => "clipit_activity/".$activity->id."/discussion",
            'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_publications',
            'text' => elgg_echo('activity:publications'),
            'href' => "clipit_activity/".$activity->id."/publications",
        );
        elgg_register_menu_item('page', $params);
    }

}

function create_activity_page_handler($page) {

    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    $vars = array();
    $vars['page'] = $page[0];
    set_input('step', $page);
    elgg_extend_view('forms/activity/create', 'activity/create/step_1', 100);
    elgg_extend_view('forms/activity/create', 'activity/create/step_2', 100);
    elgg_extend_view('forms/activity/create', 'activity/create/step_3', 100);
//    elgg_extend_view('forms/activity/create', 'activity/create/groups/create', 100);
    require_once "$base_dir/create.php";

    return true;
}

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
    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    elgg_load_library('clipit:activities');
    elgg_set_context("activity_page");
    $activity = array_pop(ClipitActivity::get_by_id(array($page[0])));
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $called_users = ClipitActivity::get_students($activity->id);
    $isCalled = in_array($user_id, $called_users);
    // Default status
    $activity_status = $activity->status;
    // Check if activity exists
    if (!$activity ) {
        return false;
    }
    elgg_set_page_owner_guid($activity->id);
    /**
     * Set access
     * ACCESS_PUBLIC, ACCESS_TEACHER, ACCESS_MEMBER
     */
    if($hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity->id)){
        $access = 'ACCESS_MEMBER';
    }
    elseif(in_array($user_id, $activity->teacher_array)){
        $access = 'ACCESS_TEACHER';
    } else{
        $access = 'ACCESS_PUBLIC';
    }
    // Activity profile
    if(!isset($page[1])){
        $content = elgg_view('activity/profile/layout', array('entity' => $activity, 'access' => $access));
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
            $activity_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
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

                case 'admin':
                    if($user->role == 'student' || $access != 'ACCESS_TEACHER'){
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
                            $content = elgg_view_form('activity/admin/setup', array('body' => $setup_view));
                            break;
                        case 'groups':
                            $content = elgg_view('activity/admin/groups/view', array('entity' => $activity));
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
                    break;
                case 'join':
                    if($activity_status == 'active' || !$isCalled || $activity->group_mode != ClipitActivity::GROUP_MODE_STUDENT){
                        return false;
                    }
                    $title = elgg_echo("activity:group:join");
                    elgg_push_breadcrumb($title);
                    $params = array(
                        'content'   => elgg_view('activity/join', array('entity' => $activity)),
                        'filter'    => '',
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'discussion':
                    include("{$activity_dir}/discussion.php");
                    break;
                case 'tasks':
                    $title = elgg_echo("activity:tasks");
                    elgg_push_breadcrumb($title);
                    $tasks = ClipitActivity::get_tasks($activity->id);
                    $href = "clipit_activity/{$activity->id}/tasks";
                    $group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
                    $content = elgg_view('tasks/list', array('tasks' => $tasks, 'href' => $href));
                    if($page[2] == 'view' && $page[3]){
                        $entity_id = (int)$page[3];
                        $task = array_pop(ClipitTask::get_by_id(array($entity_id)));
                        $super_title = false;
                        if($task){
                            elgg_pop_breadcrumb($title);
                            elgg_push_breadcrumb($title, $href);
                            elgg_push_breadcrumb($task->name);
                            $filter = "";
                            $title = elgg_echo('activity:task');
                            $status = get_task_status($task);
                            switch($task->task_type){
                                case "video_upload":
                                    $videos = ClipitGroup::get_videos($hasGroup);
                                    $href_publications = "clipit_activity/{$activity->id}/publications";
                                    $body = elgg_view('multimedia/video/list', array(
                                        'entities'    => $videos,
                                        'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                                        'task_id'   => $task->id,
                                        'rating'    => false,
                                        'actions'   => false,
                                        'publish'   => true,
                                        'total_comments' => false,
                                    ));
                                    // Group id get parameter
                                    if($group_id = get_input('group_id')){
                                        $object = ClipitSite::lookup($group_id);
                                        $status = get_task_status($task, $group_id);
                                        $video = array($status['result']);
                                        $super_title = $object['name'];
                                        if($status['status']){
                                            $body .= elgg_view('multimedia/video/list', array(
                                                'entities'    => $video,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                        }
                                    }
                                    if($status['status'] === true || $task->end <= time()){
                                        $video = array($status['result']);
                                        $body = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:my_video"),
                                        ));
                                        // Task is completed, show my video
                                        if($status['status'] === true){
                                            $body .= elgg_view('multimedia/video/list', array(
                                                'entities'    => $video,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body = elgg_view('multimedia/video/list', array(
                                                'entities'    => $videos,
                                                'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                                                'task_id'   => $task->id,
                                                'rating'    => false,
                                                'actions'   => true,
                                                'publish'   => true,
                                                'total_comments' => false,
                                            ));
                                        }
                                        // View other videos
                                        $body .= elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:other_videos"),
                                        ));
                                        if(($key = array_search($status['result'], $task->video_array)) !== false) {
                                            unset($task->video_array[$key]);
                                        }
                                        if($task->video_array){
                                            $body .= elgg_view('multimedia/video/list_summary', array(
                                                'videos'    => $task->video_array,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                        }
                                    }
                                    // Teacher view
                                    if($user->role == ClipitUser::ROLE_TEACHER){
                                        $videos = ClipitVideo::get_by_id($task->video_array);
                                        //if($videos){
                                            $body = elgg_view('tasks/admin/task_upload', array(
                                                'entities'    => $videos,
                                                'activity'      => $activity,
                                                'task'      => $task,
                                                'list_view' => 'multimedia/video/list'
                                            ));
//                                        } else {
//                                            $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
//                                        }
                                    }
                                    break;
                                case "storyboard_upload":
                                    $storyboards = ClipitGroup::get_storyboards($hasGroup);
                                    $href_publications = "clipit_activity/{$activity->id}/publications";
                                    $body = elgg_view('multimedia/storyboard/list', array(
                                        'entities'    => $storyboards,
                                        'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                                        'task_id'   => $task->id,
                                        'publish'   => true,
                                    ));
                                  // Group id get parameter
                                    if($group_id = get_input('group_id')){
                                        $object = ClipitSite::lookup($group_id);
                                        $status = get_task_status($task, $group_id);
                                        $storyboard = array($status['result']);
                                        $super_title = $object['name'];
                                        if($status['status']){
                                            $body .= elgg_view('multimedia/storyboard/list', array(
                                                'entities'    => $storyboard,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                                        }
                                    }
                                    if($status['status'] === true || $task->end <= time()){
                                        $storyboard = array($status['result']);
                                        $body = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:my_storyboard"),
                                        ));
                                        // Task is completed, show my sb
                                        if($status['status'] === true){
                                            $body .= elgg_view('multimedia/storyboard/list', array(
                                                'entities'    => $storyboard,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body = elgg_view('multimedia/storyboard/list', array(
                                                'entities'    => $storyboards,
                                                'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                                                'task_id'   => $task->id,
                                                'rating'    => false,
                                                'actions'   => true,
                                                'publish'   => true,
                                                'total_comments' => false,
                                            ));
                                        }
                                        // View other storyboards
                                        $body .= elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:other_storyboards"),
                                        ));
                                        if(($key = array_search($status['result'], $task->storyboard_array)) !== false) {
                                            unset($task->storyboard_array[$key]);
                                        }
                                        if($task->storyboard_array){
                                            $body .= elgg_view('multimedia/storyboard/list_summary', array(
                                                'entities'    => $task->storyboard_array,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body .= elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                                        }
                                    }
                                    // Teacher view
                                    if($user->role == ClipitUser::ROLE_TEACHER){
                                        $storyboards = ClipitStoryboard::get_by_id($task->storyboard_array);
                                        if($storyboards){
                                            $body = elgg_view('tasks/admin/task_upload', array(
                                                'entities'    => $storyboards,
                                                'activity'      => $activity,
                                                'task'      => $task,
                                                'list_view' => 'multimedia/storyboard/list'
                                            ));
                                        } else {
                                            $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                                        }
                                    }
                                    break;
                                case "quiz_take":
                                    $href = "clipit_activity/{$activity->id}/quizzes";
                                    $quiz = $task->quiz;
                                    $body = elgg_view('quizzes/list', array('quiz' => $quiz, 'href' => $href));
                                    break;
                                case "video_feedback":
                                    $href = "clipit_activity/{$activity->id}/publications";
                                    $body = "";
                                    $entities = ClipitTask::get_videos($task->parent_task);
                                    $evaluation_list = get_filter_evaluations($entities, $activity->id);
                                    $list_no_evaluated = elgg_view('multimedia/video/list_summary', array(
                                        'videos'    => $evaluation_list["no_evaluated"],
                                        'href'      => $href,
                                        'rating'    => true,
                                        'total_comments' => true,
                                    ));
                                    $list_evaluated = elgg_view('multimedia/video/list_summary', array(
                                        'videos'    => $evaluation_list["evaluated"],
                                        'href'      => $href,
                                        'rating'    => true,
                                        'actions'   => false,
                                        'total_comments' => true,
                                    ));

                                    // No Evaluated section
                                    if(count($evaluation_list["no_evaluated"]) > 0){
                                        $title_block_no_evaluated = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("publications:no_evaluated")
                                        ));
                                        $body .= $title_block_no_evaluated.$list_no_evaluated;
                                    }
                                    // Evaluated section
                                    if(count($evaluation_list["evaluated"]) > 0){
                                        $title_block_evaluated = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("publications:evaluated")
                                        ));
                                        $body .= $title_block_evaluated.$list_evaluated;
                                    }
                                    if (!$entities) {
                                        $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                    }
                                    // Teacher view
                                    if($user->role == ClipitUser::ROLE_TEACHER){
                                        $task_parent = array_pop(ClipitTask::get_by_id(array($task->parent_task)));
                                        $videos = ClipitVideo::get_by_id($task_parent->video_array);
                                        if($videos){
                                            $body = elgg_view('tasks/admin/task_feedback', array(
                                                'entities'    => $videos,
                                                'activity'      => $activity,
                                                'task'      => $task,
                                            ));
                                        } else {
                                            $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                        }
                                    }
                                    break;
                                case "storyboard_feedback":
                                    $href = "clipit_activity/{$activity->id}/publications";
                                    $body = "";
                                    $entities = ClipitTask::get_storyboards($task->parent_task);
                                    $evaluation_list = get_filter_evaluations($entities, $activity->id);
                                    $list_no_evaluated = elgg_view('multimedia/storyboard/list_summary', array(
                                        'entities'    => $evaluation_list["no_evaluated"],
                                        'href'      => $href,
                                        'rating'    => true,
                                        'total_comments' => true,
                                    ));
                                    $list_evaluated = elgg_view('multimedia/storyboard/list_summary', array(
                                        'entities'    => $evaluation_list["evaluated"],
                                        'href'      => $href,
                                        'rating'    => true,
                                        'actions'   => false,
                                        'total_comments' => true,
                                    ));
                                    // No Evaluated section
                                    if(count($evaluation_list["no_evaluated"]) > 0){
                                        $title_block_no_evaluated = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("publications:no_evaluated")
                                        ));
                                        $body .= $title_block_no_evaluated.$list_no_evaluated;
                                    }
                                    // Evaluated section
                                    if(count($evaluation_list["evaluated"]) > 0){
                                        $title_block_evaluated = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("publications:evaluated")
                                        ));
                                        $body .= $title_block_evaluated.$list_evaluated;
                                    }
                                    if (!$entities) {
                                        $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                                    }
                                    // Teacher view
                                    if($user->role == ClipitUser::ROLE_TEACHER){
                                        $task_parent = array_pop(ClipitTask::get_by_id(array($task->parent_task)));
                                        $storyboards = ClipitStoryboard::get_by_id($task_parent->storyboard_array);
                                        if($storyboards){
                                            $body = elgg_view('tasks/admin/task_feedback', array(
                                                'entities'    => $storyboards,
                                                'activity'      => $activity,
                                                'task'      => $task,
                                            ));
                                        } else {
                                            $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                                        }
                                    }
                                    break;
                                case "other":
                                    // $body empty
                                    break;
                                default:
                                    return false;
                                    break;
                            }
                            $content = elgg_view('tasks/view', array(
                                'entity' => $task,
                                'body' => $body,
                                'super_title' => $super_title,
                                'status' => $status
                            ));
                        }
                    }
                    $params = array(
                        'content'   => $content,
                        'filter'    => $filter,
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'publications':

                    include("{$activity_dir}/publications.php");
                    break;
                case 'resources':
                    include("{$activity_dir}/resources.php");
                    break;
                case 'group':
                    if($page[2]){ // group/{$group_id}
                        $params = group_tools_page_handler($page, $activity);
                    }
                    break;
                default:
                    return false;
            }
        }
    }
    if(!$params){
        return false;
    }
    $group_menu_sidebar = "";
    $pending_tasks_sidebar = "";
    $activity_menu_sidebar = "";

    if($hasGroup || $isCalled || $access == 'ACCESS_TEACHER'){
        $activity_menu = elgg_view("activity/sidebar/activity_menu", array('entity' => $activity));
        $activity_menu_sidebar = elgg_view_module('aside', elgg_echo('activity'), $activity_menu);
    }
    // Group sidebar components (group block info + group tools)
    if($hasGroup && ($activity_status == 'active' || $activity_status == 'closed')){
        $pending_tasks = elgg_view("page/components/pending_tasks", array('entity' => $activity));
        $pending_tasks_sidebar = elgg_view_module('aside', elgg_echo('activity:pending_tasks'), $pending_tasks, array('class' => 'aside-block'));
        elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
        $group_menu_sidebar = elgg_view('group/sidebar/group_menu', array('entity' => $activity));
    }
    if($activity_status == 'enroll' && $hasGroup){
        elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
    }
//    ClipitActivity::set_properties($activity->id, array('group_mode' => ClipitActivity::GROUP_MODE_STUDENT));
    if(!$hasGroup && $isCalled && $activity->group_mode == ClipitActivity::GROUP_MODE_STUDENT && $activity_status == 'enroll') {
        // Join to activity button
        elgg_extend_view("page/elements/owner_block", "page/components/button_join_group");
    }
    $teachers = ClipitActivity::get_teachers($activity->id);
    $teacher_sidebar = "";
    if(!empty($teachers)){
        // Teacher admin
        if($isTeacher = in_array($user_id, $teachers)){
            elgg_extend_view("page/elements/owner_block", "activity/admin/button");
            $groups = ClipitActivity::get_groups($activity->id);
            $teacher_sidebar = elgg_view('activity/sidebar/groups', array(
                'entities' => $groups,
                'activity_id' => $activity->id
            ));
        }
        // Default teacher's list
        $teacher_sidebar .= elgg_view('activity/sidebar/teacher',
            array('teachers' => $teachers, 'access' => $access, 'activity_id' => $activity->id)
        );
    }
    $params['sidebar'] = $pending_tasks_sidebar . $activity_menu_sidebar . $group_menu_sidebar . $teacher_sidebar;
    if(!$params['class']){
        $params['class'] = "activity-section activity-layout";
    }
    if($activity_status != 'enrol'){
    $params['special_header_content'] = elgg_view('activity/status', array('entity' => $activity));
    }
    $body = elgg_view_layout('one_sidebar', $params);
    echo elgg_view_page($params['title'], $body);

    return true;
}

/**
 *
 */
function file_page_handler($page){
    if(isset($page[0]) && isset($page[1])){
        $action = (string)$page[0];
        $file_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/file';
        switch($action){
            case "download":
                $id = (int)$page[1];
                set_input("id", $id);
                include($file_dir . "/download.php");
                break;
            case "thumbnail":
                if(!isset($page[2])){
                    return false;
                }
                $id = (int)$page[2];
                set_input("id", $id);
                set_input("size", (string)$page[1]);
                include($file_dir . "/thumbnail.php");
                break;
            default:
                return false;
        }
    }
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
    $my_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    $isTeacher = in_array($user_id, $activity->teacher_array);
    $group_id = (int)$page[2];
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    if($activity->status == 'enroll' && !$isTeacher ){
        return false;
    }
    $canCreate = false;
    if(($my_group == $group_id && $activity->status == 'active') || $isTeacher){
        $canCreate = true;
    }
    if($group &&
        ((!$isTeacher && $my_group == $group_id) // I am group member
            ||
        ($isTeacher && $my_group != $group_id)) // I am a teacher from activity
    ){
        $access_group = true;
    }
    if(!$access_group){
        return false;
    }
    elgg_push_breadcrumb($group->name, "clipit_activity/{$activity->id}/group/{$group->id}");
    // set group icon status from activity status
    $activity_status = $activity->status;
    $icon_status = "lock";
    if($activity_status == 'enroll'){
        $icon_status = "unlock";
    }
    $filter = "";
    $group_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/group';
    switch ($page[3]) {
        case '':
            include("{$group_dir}/dashboard.php");
            break;
        case 'repository':
            include("{$group_dir}/repository.php");
            break;
        case 'discussion':
            include("{$group_dir}/discussion.php");
            break;
        default:
            return false;
    }
    // Default group params
//    $defaults_params = array(
//        'content' => $content,
//        'filter' => $filter,
//        'title' => $title,
//        'sub-title' => $group_name,
//        'title_style' => "background: #". $activity->color
//    );
    $params['content'] = $content;
    $params['filter'] = $filter;
    $params['title'] = $title;
    $params['sub-title'] = $group->name;
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

    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    $vars = array();
	$vars['page'] = $page[0];

    require_once "$base_dir/my_activities.php";

    return true;

}


/**
 * Get evaluations by filter (no evaluated | evaluated)
 *
 * @param $entities
 * @return array
 */
function get_filter_evaluations($entities, $activity_id, $user_id = null){
    if(!$user_id){
        $user_id = elgg_get_logged_in_user_guid();
    }
    $group_id = ClipitGroup::get_from_user_activity($user_id, $activity_id);
    $output = array();
    foreach($entities as $entity_id){
        $object = ClipitSite::lookup($entity_id);
        $entity_class = $object['subtype'];
        $entity = array_pop($entity_class::get_by_id(array($entity_id)));
        $rating = ClipitRating::get_from_user_for_target($user_id, $entity->id);
        if($group_id != $entity_class::get_group($entity->id)){
            if(!$rating){
                $output["no_evaluated"][] = $entity->id;
            } else {
                $output["evaluated"][] = $entity->id;
            }
        }
    }
    return $output;
}