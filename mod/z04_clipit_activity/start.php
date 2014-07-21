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

    // Create Activity
    elgg_register_action("activity/create/add_users", elgg_get_plugins_path() . "z04_clipit_activity/actions/activity/add_users.php");
    elgg_register_action("activity/create/add_users_upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/activity/add_users_upload.php");
    elgg_register_action("activity/create", elgg_get_plugins_path() . "z04_clipit_activity/actions/activity/create.php");
    elgg_register_ajax_view('activity/create/task_list');
    elgg_register_ajax_view('activity/create/groups/create');
    // Admin activity
    elgg_register_action("activity/admin/setup", elgg_get_plugins_path() . "z04_clipit_activity/actions/activity/admin/setup.php");
    elgg_register_ajax_view('activity/admin/dashboard/group_info');
    elgg_register_ajax_view('modal/activity/admin/user_stats');
    elgg_register_ajax_view('modal/activity/admin/users_task');

    // Group
    elgg_register_action("group/join", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/join.php");
    elgg_register_action("group/leave", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/leave.php");
    elgg_register_action("group/create", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/create.php");
    elgg_register_action("group/remove_member", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/remove_member.php");
    elgg_register_ajax_view('modal/group/view');
    elgg_register_ajax_view('multimedia/attach/videos');
    elgg_register_ajax_view('multimedia/attach/storyboards');
    elgg_register_ajax_view('multimedia/attach/files');
    // Tricky Topic
    elgg_register_ajax_view('modal/tricky_topic/view');
    elgg_register_ajax_view('tricky_topic/list');
    // Multimedia
    /* Videos */
    elgg_register_action("multimedia/videos/add", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/videos/add.php");
    elgg_register_action("multimedia/videos/remove", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/videos/remove.php");
    elgg_register_action("multimedia/videos/edit", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/videos/edit.php");
    elgg_register_action("multimedia/videos/publish", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/videos/publish.php");
    elgg_register_ajax_view('modal/multimedia/video/edit');
    elgg_register_ajax_view('modal/multimedia/video/publish');
    /* Files */
    elgg_register_action("multimedia/files/upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/files/upload.php");
    elgg_register_action("multimedia/files/remove", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/files/remove.php");
    elgg_register_action("multimedia/files/edit", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/files/edit.php");
    elgg_register_action("multimedia/files/set_options", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/files/set_options.php");
    elgg_register_ajax_view('modal/multimedia/file/edit');
    elgg_register_ajax_view('multimedia/file/viewer');
    elgg_register_ajax_view('multimedia/file/upload');
    elgg_register_ajax_view('multimedia/file/attach_action');
    elgg_register_action("multimedia/videos/extract_data", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/videos/extract_data.php");
    elgg_register_action("multimedia/files/upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/files/upload.php");
    /* Storyboards */
    elgg_register_action("storyboards/upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/storyboards/upload.php");
    elgg_register_action("multimedia/storyboards/edit", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/storyboards/edit.php");
    elgg_register_action("multimedia/storyboards/remove", elgg_get_plugins_path() . "z04_clipit_activity/actions/multimedia/storyboards/remove.php");
    elgg_register_ajax_view('modal/multimedia/storyboard/edit');
    // Publications
    elgg_register_action("publications/evaluate", elgg_get_plugins_path() . "z04_clipit_activity/actions/publications/evaluate.php");
    elgg_register_action("publications/publish", elgg_get_plugins_path() . "z04_clipit_activity/actions/publications/publish.php");
    elgg_register_action("publications/labels/add", elgg_get_plugins_path() . "z04_clipit_activity/actions/publications/labels/add.php");
    elgg_register_ajax_view('modal/publications/rating');
    elgg_register_ajax_view('publications/labels/search');
    // Discussion
    elgg_register_action("discussion/create", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/create.php");
    elgg_register_action("discussion/remove", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/remove.php");
    elgg_register_action("discussion/edit", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/edit.php");
    elgg_register_ajax_view('modal/discussion/edit');
    elgg_register_action("discussion/reply/create", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/reply/create.php");
    elgg_register_action("discussion/reply/remove", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/reply/remove.php");
    elgg_register_action("discussion/reply/edit", elgg_get_plugins_path() . "z04_clipit_activity/actions/discussion/reply/edit.php");
    elgg_register_ajax_view('modal/discussion/reply/edit');
    elgg_register_ajax_view('discussion/quote');

    // Register javascript files
    $files_upload_js = elgg_get_simplecache_url('js', 'upload');
    elgg_register_simplecache_view('js/upload');
    elgg_register_js('file:upload', $files_upload_js);
    // Raty js modified by clipit
    elgg_register_js('jquery:raty', elgg_get_site_url() . "mod/z04_clipit_activity/vendors/jquery.raty.js");
    elgg_load_js("jquery:raty");
    // Tag-it
    elgg_register_js('jquery:tag_it', elgg_get_site_url() . "mod/z04_clipit_activity/vendors/jquery.tag-it.min.js");
    elgg_load_js("jquery:tag_it");

    $files_attach_js = elgg_get_simplecache_url('js', 'attach');
    elgg_register_simplecache_view('js/attach');
    elgg_register_js('file:attach', $files_attach_js);
    // jQuery file upload
    elgg_register_js("jquery:fileupload:tmpl", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/tmpl.min.js");
    elgg_register_js("jquery:fileupload:load_image", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/load-image.min.js");
    elgg_register_js("jquery:fileupload:iframe_transport", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/iframe-transport.js");
    elgg_register_js("jquery:fileupload", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/fileupload.js");
    elgg_register_js("jquery:fileupload:process", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/fileupload-process.js");
    elgg_register_js("jquery:fileupload:image", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/fileupload-image.js");
    elgg_register_js("jquery:fileupload:validate", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/fileupload-validate.js");
    elgg_register_js("jquery:fileupload:ui", elgg_get_site_url() . "mod/z04_clipit_activity/vendors/fileupload/fileupload-ui.js");
    elgg_load_js("jquery:fileupload:tmpl");
    elgg_load_js("jquery:fileupload:load_image");
    elgg_load_js("jquery:fileupload:iframe_transport");
    elgg_load_js("jquery:fileupload");
    elgg_load_js("jquery:fileupload:process");
    elgg_load_js("jquery:fileupload:image");
    elgg_load_js("jquery:fileupload:validate");
    elgg_load_js("jquery:fileupload:ui");

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
    $called_users = ClipitActivity::get_called_users($activity->id);
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
                case 'quiz':
                    if($page[2] == 'view' && $page[3]){
                        $title = elgg_echo("activity:quiz");
                        elgg_push_breadcrumb($title);
                        $params = array(
                            'content'   => elgg_view('quizzes/view', array('entity' => $activity)),
                            'filter'    => '',
                            'title'     => $title,
                            'sub-title' => $activity->name,
                            'title_style' => "background: #". $activity->color,
                        );
                    }
                    break;
                case 'admin':
                    if($user->role == 'student' || $access != 'ACCESS_TEACHER'){
                        return false;
                    }
                    $title = elgg_echo('activity:admin');
                    $href = "clipit_activity/{$activity->id}/admin";
                    $selected_tab = get_input('filter', 'dashboard');
                    $filter = elgg_view('activity/admin/filter', array('selected' => $selected_tab, 'href' => $href));
                    // dashboard, default admin view
                    $content = elgg_view('activity/admin/dashboard/view', array('entity' => $activity));
                    switch($selected_tab){
                        case 'tasks':
                            $content = elgg_view('activity/admin/tasks/view', array('entity' => $activity));
                            break;
                        case 'setup':
                            $content = elgg_view_form('activity/admin/setup', array(), array('entity' => $activity));
                            break;
                        case 'groups':
                            $content = elgg_view('activity/admin/groups/view', array('entity' => $activity));
                            break;
                    }
                    $params = array(
                        'content'   => $content,
                        'filter'    => $filter,
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
                case 'discussion':
                    $title = elgg_echo("activity:discussion");
                    $href = "clipit_activity/{$activity->id}/discussion";
                    elgg_push_breadcrumb($title);
                    $messages = array_pop(ClipitPost::get_by_destination(array($activity->id)));
                    $canCreate = false;
                    if( ($access == 'ACCESS_TEACHER' || $access == 'ACCESS_MEMBER') && $activity_status != 'closed'){
                        $canCreate = true;
                    }
                    $content =  elgg_view('discussion/list',
                        array(
                            'entity' => $activity,
                            'messages' => $messages,
                            'href'   => $href,
                            'create' => $canCreate
                        ));
                    if(!$messages){
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('discussions:none')));
                    }
                    if($page[2] == 'view' && $page[3]){
                        $message_id = (int)$page[3];
                        $message = array_pop(ClipitPost::get_by_id(array($message_id)));
                        elgg_pop_breadcrumb($title);
                        elgg_push_breadcrumb($title, $href);
                        elgg_push_breadcrumb($message->name);
                        if($message && $message->destination == $activity->id){
                            $content = elgg_view('discussion/view',
                                array(
                                    'entity'     => $message,
                                    'activity_id'   => $activity->id,
                                    'show_group' => true,
                                ));
                        } else {
                            return false;
                        }
                    }
                    $params = array(
                        'content'   => $content,
                        'filter'    => '',
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );

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
                                        'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/multimedia",
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
                                                'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/multimedia",
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
                                    break;
                                case "storyboard_upload":
                                    $storyboards = ClipitGroup::get_storyboards($hasGroup);
                                    $href_publications = "clipit_activity/{$activity->id}/publications";
                                    $body = elgg_view('multimedia/storyboard/list', array(
                                        'entities'    => $storyboards,
                                        'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/multimedia",
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
                                                'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/multimedia",
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

                                    break;
                                case "quiz_answer":
                                    $href = "clipit_activity/{$activity->id}/quizzes";
                                    $quizzes = ClipitTask::get_quizzes($task->id);
                                    $body = elgg_view('quizzes/list', array('quizzes' => $quizzes, 'href' => $href));
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
                                        $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                    }
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
                    $selected_tab = get_input('filter', 'videos');
                    $title = elgg_echo("activity:publications");
                    elgg_push_breadcrumb($title);
                    $href = "clipit_activity/{$activity->id}/publications";
                    $filter = elgg_view('publications/filter', array('selected' => $selected_tab, 'entity' => $activity, 'href' => $href));
                    $tasks = ClipitActivity::get_tasks($activity->id);
                    switch($selected_tab){
                        case 'videos':
                            // Get last task [type: video_upload]
                            $content = publications_get_page_content_list('video_upload', $tasks, $href);
                            break;
                        case 'storyboards':
                            // Get last task [type: storyboard_upload]
                            $content = publications_get_page_content_list('storyboard_upload', $tasks, $href);
                            break;
                    }

                    if($page[2] == 'view' && $page[3]){
                        $entity_id = (int)$page[3];
                        $filter = "";
                        elgg_pop_breadcrumb($title);
                        elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/publications");
                        $object = ClipitSite::lookup($entity_id);
                        $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
                        // Check if user can evaluate own group video
                        $hasRating = ClipitRating::get_from_user_for_target($user_id, $entity_id);
                        $owner_group_id = $entity->get_group($entity->id);
                        $my_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
                        $canEvaluate = false;
                        if(!$hasRating && ($my_group != $owner_group_id)){
                            $canEvaluate = true;
                        }
                        $owner_group = array_pop(ClipitGroup::get_by_id(array($owner_group_id)));
                        switch($object['subtype']){
                            // Clipit Video publication
                            case 'ClipitVideo':
                                $task_id = ClipitVideo::get_task($entity_id);
                                $videos = ClipitTask::get_videos($task_id);
                                if(!$entity || !in_array($entity_id, $videos)){
                                    return false;
                                }
                                $body = elgg_view("multimedia/video/body", array('entity'  => $entity));
                                $content = elgg_view('publications/view', array(
                                    'entity' => $entity,
                                    'body' => $body,
                                    'canEvaluate' => $canEvaluate,
                                    'activity' => $activity,
                                    'group' => $owner_group
                                ));
                                break;
                            // Clipit Storyboard publication
                            case 'ClipitStoryboard':
                                $task_id = ClipitStoryboard::get_task($entity_id);
                                $sbs = ClipitTask::get_storyboards($task_id);
                                if(!$entity || !in_array($entity_id, $sbs)){
                                    return false;
                                }
                                $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
                                $body = elgg_view("multimedia/storyboard/body", array(
                                    'entity' => $entity,
                                    'file'  => $file,
                                    'preview' => true
                                ));
                                $content = elgg_view('publications/view', array(
                                    'entity' => $entity,
                                    'type' => 'storyboard',
                                    'body' => $body,
                                    'canEvaluate' => $canEvaluate,
                                    'activity' => $activity,
                                    'group' => $owner_group
                                ));
                                break;
                            default:
                                return false;
                                break;
                        }
                        elgg_push_breadcrumb($entity->name);
                    }
                    $params = array(
                        'content'   => $content,
                        'filter'    => $filter,
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
                    break;
                case 'resources':
                    $title = elgg_echo("activity:stas");
                    elgg_push_breadcrumb($title);
                    $selected_tab = get_input('filter', 'files');
                    $href = "clipit_activity/{$activity->id}/resources";
                    switch ($selected_tab) {
                        case 'files':
                            $files = ClipitActivity::get_files($activity->id);
                            // Search items
                            if($search_term = stripslashes(get_input("search"))){
                                $items_search = array_keys(ClipitFile::get_from_search($search_term));
                                $files = array_uintersect($items_search, $files, "strcasecmp");
                            }
                            elgg_extend_view("files/search", "search/search");

                            $canCreate = false;
                            // Add files button for teacher
                            if($access == 'ACCESS_TEACHER' && $activity_status != 'closed'){
                                $canCreate = true;
                            }
                            $content = elgg_view('multimedia/file/list', array(
                                'entity' => $activity,
                                'create' => $canCreate,
                                'files' => $files,
                                'href' => $href
                            ));
                            if (!$files) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                            }
                            break;
                        case 'videos':
                            $videos = ClipitActivity::get_videos($activity->id);
                            // Search items
                            if($search_term = stripslashes(get_input("search"))){
                                $items_search = array_keys(ClipitVideo::get_from_search($search_term));
                                $videos = array_uintersect($items_search, $videos, "strcasecmp");
                            }
                            elgg_extend_view("videos/search", "search/search");

                            $canCreate = false;
                            // Add files button for teacher
                            if($access == 'ACCESS_TEACHER' && $activity_status != 'closed'){
                                $canCreate = true;
                            }
                            $content = elgg_view('multimedia/video/list', array(
                                'entity' => $activity,
                                'create' => $canCreate,
                                'actions'   => true,
                                'entities' => $videos,
                                'href' => $href
                            ));
                            if (!$videos) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                            }
                            break;
                        case 'storyboards':
                            $sbs = ClipitActivity::get_storyboards($activity->id);
                            // Search items
                            if($search_term = stripslashes(get_input("search"))){
                                $items_search = array_keys(ClipitStoryboard::get_from_search($search_term));
                                $sbs = array_uintersect($items_search, $sbs, "strcasecmp");
                            }
                            elgg_extend_view("storyboards/search", "search/search");

                            $canCreate = false;
                            // Add sbs button for teacher
                            if($access == 'ACCESS_TEACHER' && $activity_status != 'closed'){
                                $canCreate = true;
                            }
                            $content = elgg_view('multimedia/storyboard/list', array(
                                'entity' => $activity,
                                'create' => $canCreate,
                                'entities' => $sbs,
                                'actions' => true,
                                'href' => $href
                            ));
                            if (!$sbs) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                            }
                            if($page[3] == 'view' && $page[4]){
                                $entity_id = (int)$page[4];
                                $entity = ClipitVideo::get_by_id(array($entity_id));
                                $entities = ClipitGroup::get_videos($entity->id);
                            }
                            break;
                        default:
                            return false;
                            break;
                    }
                    $filter = elgg_view('multimedia/filter', array('selected' => $selected_tab, 'entity' => $activity, 'href' => $href));
                    if($page[2] == 'download' && $page[3]){
                        $file_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/file';
                        set_input('id', $page[4]);
                        include "$file_dir/download.php";
                    }
                    if($page[2] == 'view' && $page[3]){
                        $entity_id = (int)$page[3];
                        elgg_pop_breadcrumb($title);
                        elgg_push_breadcrumb($title, $href);
                        $filter = "";
                        $object = ClipitSite::lookup($entity_id);
                        switch($object['subtype']){
                            // Clipit File
                            case 'ClipitFile':
                                elgg_push_breadcrumb(elgg_echo("files"), $href."?filter=files");
                                $title = elgg_echo("file");
                                $entity = array_pop(ClipitFile::get_by_id(array($entity_id)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'file',
                                    'preview' => elgg_view("multimedia/file/preview", array('file'  => $entity)),
                                    'body' => elgg_view("multimedia/file/body", array('entity'  => $entity))
                                ));
                                break;
                            // Clipit Video
                            case 'ClipitVideo':
                                elgg_push_breadcrumb(elgg_echo("videos"), $href."?filter=videos");
                                $title = elgg_echo("video");
                                $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'video',
                                    'preview' => elgg_view("multimedia/video/preview", array('entity'  => $entity)),
                                    'body' => elgg_view("multimedia/video/body", array('entity'  => $entity))
                                ));
                                break;
                            // Clipit Storyboard
                            case 'ClipitStoryboard':
                                elgg_push_breadcrumb(elgg_echo("storyboards"), $href."?filter=storyboards");
                                $title = elgg_echo("storyboard");
                                $entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
                                $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'storyboard',
                                    'preview' => elgg_view("multimedia/file/preview", array('file'  => $file)),
                                    'body' => elgg_view("multimedia/storyboard/body", array('entity'  => $entity, 'file'  => $file))
                                ));
                                break;
                            default:
                                return false;
                                break;
                        }
                        elgg_push_breadcrumb($entity->name);
                    }
                    $params = array(
                        'content'   => $content,
                        'filter'    => $filter,
                        'title'     => $title,
                        'sub-title' => $activity->name,
                        'title_style' => "background: #". $activity->color,
                    );
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

    if($hasGroup || $access == 'ACCESS_TEACHER'){
        $activity_menu = elgg_view("activity/sidebar/activity_menu", array('entity' => $activity));
        $activity_menu_sidebar = elgg_view_module('aside', elgg_echo('activity'), $activity_menu);
    }
    // Group sidebar components (group block info + group tools)
    if($hasGroup && $activity_status == 'active'){
        $pending_tasks = elgg_view("page/components/pending_tasks", array('entity' => $activity));
        $pending_tasks_sidebar = elgg_view_module('aside', elgg_echo('activity:pending_tasks'), $pending_tasks, array('class' => 'aside-block'));

        elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
        $group_menu_sidebar = elgg_view('group/sidebar/group_menu', array('entity' => $activity));
    }
    if(!$hasGroup && ($isCalled && $activity_status == 'enroll')) {
        // Join to activity button
        elgg_extend_view("page/elements/owner_block", "page/components/button_join_activity");
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
        $teacher_sidebar .= elgg_view('activity/sidebar/teacher', array('teachers' => $teachers));
    }
    $params['sidebar'] = $pending_tasks_sidebar . $activity_menu_sidebar . $group_menu_sidebar . $teacher_sidebar;
    if(!$params['class']){
        $params['class'] = "activity-section activity-layout";
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
    if($activity->status == 'enroll'){
        return false;
    }
    $canCreate = false;
    if($my_group == $group_id && $activity->status == 'active'){
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
    $group_name = '<i class="fa fa-'.$icon_status.'"></i> '.$group->name;
    $filter = "";
    switch ($page[3]) {
        case '':
            $title = elgg_echo("group:home");
            elgg_pop_breadcrumb($group->name);
            elgg_push_breadcrumb($group->name);
            $content = elgg_view('group/dashboard', array('entity' => $group));
            break;
        case 'multimedia':
            $title = elgg_echo("group:files");
            elgg_push_breadcrumb($title);
            $selected_tab = get_input('filter', 'files');
            $href = "clipit_activity/{$activity->id}/group/{$group->id}/multimedia";
            switch ($selected_tab) {
                case 'files':
                    $files = ClipitGroup::get_files($group->id);
                    // Search items
                    if($search_term = stripslashes(get_input("search"))){
                        $items_search = array_keys(ClipitFile::get_from_search($search_term));
                        $files = array_uintersect($items_search, $files, "strcasecmp");
                    }
                    elgg_extend_view("files/search", "search/search");

                    $content = elgg_view('multimedia/file/list', array(
                        'entity' => $group,
                        'add_files' => true,
                        'files' => $files,
                        'href' => $href,
                        'create' => $canCreate
                    ));
                    if (!$files) {
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                    }
                    break;
                case 'videos':
                    $videos = ClipitGroup::get_videos($group->id);
                    // Search items
                    if($search_term = stripslashes(get_input("search"))){
                        $items_search = array_keys(ClipitVideo::get_from_search($search_term));
                        $videos = array_uintersect($items_search, $videos, "strcasecmp");
                    }
                    elgg_extend_view("videos/search", "search/search");

                    $content = elgg_view('multimedia/video/list', array(
                        'entity' => $group,
                        'add_video' => true,
                        'entities' => $videos,
                        'actions'   => true,
                        'href' => $href,
                        'create' => $canCreate
                    ));
                    if (!$videos) {
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                    }
                    break;
                case 'storyboards':
                    $sbs = ClipitGroup::get_storyboards($group->id);
                    // Search items
                    if($search_term = stripslashes(get_input("search"))){
                        $items_search = array_keys(ClipitStoryboard::get_from_search($search_term));
                        $sbs = array_uintersect($items_search, $sbs, "strcasecmp");
                    }
                    elgg_extend_view("storyboards/search", "search/search");

                    $content = elgg_view('multimedia/storyboard/list', array(
                        'entity' => $group,
                        'add_sb' => true,
                        'entities' => $sbs,
                        'href' => $href,
                        'create' => $canCreate,
                        'actions' => true
                    ));
                    if (!$sbs) {
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                    }
                    if($page[3] == 'view' && $page[4]){
                        $entity_id = (int)$page[4];
                        $entity = ClipitVideo::get_by_id(array($entity_id));
                        $entities = ClipitGroup::get_videos($entity->id);
                    }
                    break;
                default:
                    return false;
                    break;
            }
            $filter = elgg_view('multimedia/filter', array('selected' => $selected_tab, 'entity' => $group, 'href' => $href));
            if($page[4] == 'download' && $page[5]){
                $file_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/file';
                set_input('id', $page[4]);
                include "$file_dir/download.php";
            }
            if($page[4]){
                $entity_id = (int)$page[5];
                switch($page[4]){
                    case "view":
                        elgg_pop_breadcrumb($title);
                        elgg_push_breadcrumb($title, $href);
                        $object = ClipitSite::lookup($entity_id);
                        switch($object['subtype']){
                            // Clipit File
                            case 'ClipitFile':
                                elgg_push_breadcrumb(elgg_echo("files"), $href."?filter=files");
                                $title = elgg_echo("file");
                                $entity = array_pop(ClipitFile::get_by_id(array($entity_id)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'file',
                                    'preview' => elgg_view("multimedia/file/preview", array('file'  => $entity)),
                                    'body' => elgg_view("multimedia/file/body", array('entity'  => $entity))
                                ));
                                break;
                            // Clipit Video
                            case 'ClipitVideo':
                                elgg_push_breadcrumb(elgg_echo("videos"), $href."?filter=videos");
                                $title = elgg_echo("video");
                                $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'video',
                                    'preview' => elgg_view("multimedia/video/preview", array('entity'  => $entity)),
                                    'body' => elgg_view("multimedia/video/body", array('entity'  => $entity))
                                ));
                                break;
                            // Clipit Storyboard
                            case 'ClipitStoryboard':
                                elgg_push_breadcrumb(elgg_echo("storyboards"), $href."?filter=storyboards");
                                $title = elgg_echo("storyboard");
                                $entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
                                $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
                                $content = elgg_view('multimedia/view', array(
                                    'entity' => $entity,
                                    'type' => 'storyboard',
                                    'preview' => elgg_view("multimedia/file/preview", array('file'  => $file)),
                                    'body' => elgg_view("multimedia/storyboard/body", array('entity'  => $entity, 'file' => $file))
                                ));
                                break;
                            default:
                                return false;
                                break;
                        }
                        break;
                    case "publish":
                        $entity_id = (int)$page[5];
                        elgg_pop_breadcrumb($entity->name);
                        $object = ClipitSite::lookup($entity_id);
                        switch($object['subtype']){
                            // Clipit Video
                            case 'ClipitVideo':
                                $subtitle = elgg_echo("video");
                                elgg_push_breadcrumb(elgg_echo("videos"), $href."?filter=videos");
                                $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
                                $entity_preview = '<img src="'.$entity->preview.'" class="img-responsive">';
                                break;
                            // Clipit StoryBoard
                            case 'ClipitStoryboard':
                                $subtitle = elgg_echo("storyboard");
                                elgg_push_breadcrumb(elgg_echo("storyboards"), $href."?filter=storyboards");
                                $entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
                                $entity_preview = elgg_view("multimedia/file/view_summary", array(
                                    'file' => array_pop(ClipitFile::get_by_id(array($entity->file))),
                                    'title' => false
                                ));
                                break;
                            default:
                                return false;
                                break;
                        }
                        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
                        $tags = $tricky_topic->tag_array;
                        if(isset($entity_preview)){
                            $entity_preview = elgg_view('output/url', array(
                                'href'  => "{$href}/view/{$entity->id}",
                                'target' => "_blank",
                                'title' => $entity->name,
                                'text'  => $entity_preview
                            ));
                        }
                        $content = elgg_view_form('publications/publish', array('data-validate'=> "true" ),
                            array(
                                'entity'  => $entity,
                                'parent_id' => $group->id,
                                'activity' => $activity,
                                'tags' => $tags,
                                'entity_preview' => $entity_preview
                            ));
                        $title =  elgg_echo("publish:to_activity", array($subtitle, $activity->name));
                        break;
                }
                elgg_push_breadcrumb($entity->name);
                $filter = "";
            }
            break;
        case 'discussion':
            $title = elgg_echo("group:discussion");
            $href = "clipit_activity/{$activity->id}/group/{$group->id}/discussion";
            elgg_push_breadcrumb($title);
            $messages = array_pop(ClipitPost::get_by_destination(array($group->id)));

            $content =  elgg_view('discussion/list',
                    array(
                        'entity' => $group,
                        'messages' => $messages,
                        'attach_multimedia_group' => true,
                        'href'   => $href,
                        'create' => $canCreate
                    ));
            if(!$messages){
                $content .= elgg_view('output/empty', array('value' => elgg_echo('discussions:none')));
            }
            if($page[4] == 'view' && $page[5]){
                $message_id = (int)$page[5];
                $message = array_pop(ClipitPost::get_by_id(array($message_id)));
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($title, $href);
                elgg_push_breadcrumb($message->name);
                if($message && $message->destination == $group->id){
                    $content = elgg_view('discussion/view', array('entity' => $message, 'group' => $group));
                } else {
                    return false;
                }
            }
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
function get_filter_evaluations($entities, $activity_id){
    $user_id = elgg_get_logged_in_user_guid();
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