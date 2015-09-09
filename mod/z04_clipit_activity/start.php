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

    $plugin_dir = elgg_get_plugins_path() . "z04_clipit_activity";
    /**
     * Register clipit libraries
     */
    elgg_register_library('clipit:activities', "{$plugin_dir}/lib/activities.php");
    elgg_register_library('clipit:activity:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:activity:functions');
    // Publications
    elgg_register_library('clipit:activity:publications', "{$plugin_dir}/lib/publications.php");
    elgg_load_library('clipit:activity:publications');
    // Multimedia
    elgg_register_library('clipit:activity:multimedia', "{$plugin_dir}/lib/multimedia.php");
    elgg_load_library('clipit:activity:multimedia');

    // Special views for role = teacher

    if($user->role == ClipitUser::ROLE_STUDENT) {
        // My activities list (top header)
        elgg_extend_view("navigation/menu/top", "navigation/menu/my_activities", 100);
    }

    // Register "/my_activities" page handler
    elgg_register_page_handler('my_activities', 'my_activities_page_handler');
    if($user->role == ClipitUser::ROLE_TEACHER || $user->role == ClipitUser::ROLE_ADMIN) {
        // Register "/create_activity" page handler
        elgg_register_page_handler('create_activity', 'create_activity_page_handler');
        // Register "/activities" page handler
        elgg_register_page_handler('activities', 'activities_page_handler');
        elgg_extend_view("navigation/menu/top", "navigation/menu/activities", 200);
    }
    // Register "/file" page handler
    elgg_register_page_handler('file', 'file_page_handler');
    // Register "/clipit_activity" page handler
    elgg_register_page_handler('clipit_activity', 'activity_page_handler');

    // Register actions & ajax views

    // Create Activity
    elgg_register_action("activity/create/add_users", "{$plugin_dir}/actions/activity/add_users.php");
    elgg_register_action("activity/create/add_users_upload", "{$plugin_dir}/actions/activity/add_users_upload.php");
    elgg_register_action("activity/remove", "{$plugin_dir}/actions/activity/remove.php");
    elgg_register_action("activity/create", "{$plugin_dir}/actions/activity/create.php");
    elgg_register_ajax_view('activity/create/task_list');
    elgg_register_ajax_view('activity/create/groups/create');
    // Admin activity
    elgg_register_action("activity/admin/users", "{$plugin_dir}/actions/activity/admin/users.php");
    elgg_register_action("activity/admin/setup", "{$plugin_dir}/actions/activity/admin/setup.php");
    elgg_register_action("activity/admin/options", "{$plugin_dir}/actions/activity/admin/options.php");
    elgg_register_action("activity/admin/teachers", "{$plugin_dir}/actions/activity/admin/teachers.php");
    elgg_register_action("activity/admin/groups_setup", "{$plugin_dir}/actions/activity/admin/groups_setup.php");
    elgg_register_action("activity/admin/groups_create", "{$plugin_dir}/actions/activity/admin/groups_create.php");
    elgg_register_action("activity/admin/group_mode", "{$plugin_dir}/actions/activity/admin/group_mode.php");
    elgg_register_action("activity/admin/assign_sb", "{$plugin_dir}/actions/activity/admin/assign_sb.php");
    elgg_register_action("task/edit", "{$plugin_dir}/actions/task/edit.php");
    elgg_register_action("task/remove", "{$plugin_dir}/actions/task/remove.php");
    elgg_register_action("task/create", "{$plugin_dir}/actions/task/create.php");
    elgg_register_action("task/save", "{$plugin_dir}/actions/task/save.php");
    elgg_register_ajax_view('tasks/admin/feedback_data');

    elgg_register_ajax_view('activity/admin/tasks/quiz/add_type');
    elgg_register_ajax_view('activity/admin/tasks/quiz/quiz');
    elgg_register_ajax_view('quizzes/admin/results');
    elgg_register_action("quiz/take", "{$plugin_dir}/actions/quiz/take.php");
    elgg_register_action("quiz/question_annotate", "{$plugin_dir}/actions/quiz/question_annotate.php");

    elgg_register_ajax_view('activity/admin/groups/users_list');
    elgg_register_ajax_view('activity/admin/groups/info');
    elgg_register_ajax_view('publications/admin/user_ratings');
    elgg_register_ajax_view('modal/activity/admin/user_stats');
    elgg_register_ajax_view('modal/activity/admin/users_task');
    elgg_register_ajax_view('modal/group/assign_sb');
    elgg_register_ajax_view('modal/task/edit');
    elgg_register_ajax_view('user/add');
    // Load Task javascript templates
    elgg_extend_view('js/task_templates', 'js/task_templates/complete');
    elgg_extend_view('js/task_templates', 'js/task_templates/videos');
    elgg_extend_view('js/task_templates', 'js/task_templates/files');

    // Group
    elgg_register_action("group/join", "{$plugin_dir}/actions/group/join.php");
    elgg_register_action("group/leave", "{$plugin_dir}/actions/group/leave.php");
    elgg_register_action("group/create", "{$plugin_dir}/actions/group/create.php");
    elgg_register_action("group/remove_member", "{$plugin_dir}/actions/group/remove_member.php");
    elgg_register_ajax_view('modal/group/view');

    elgg_register_ajax_view('multimedia/attach/videos');
    elgg_register_ajax_view('multimedia/attach/files');
    // Assessment rubric
    elgg_register_ajax_view('modal/assessment_rubric/view');
    // Tricky Topic
    elgg_register_ajax_view('modal/tricky_topic/view');
    elgg_register_ajax_view('tricky_topic/list');
    // Multimedia
    /* Videos */
    elgg_register_action("multimedia/videos/add", "{$plugin_dir}/actions/multimedia/videos/add.php");
    elgg_register_action("multimedia/videos/remove", "{$plugin_dir}/actions/multimedia/videos/remove.php");
    elgg_register_action("multimedia/videos/edit", "{$plugin_dir}/actions/multimedia/videos/edit.php");
    elgg_register_action("multimedia/videos/save", "{$plugin_dir}/actions/multimedia/videos/save.php");
    elgg_register_action("multimedia/videos/publish", "{$plugin_dir}/actions/multimedia/videos/publish.php");
    elgg_register_ajax_view('modal/multimedia/video/edit');
    elgg_register_ajax_view('modal/multimedia/video/publish');
    /* Files */
    elgg_register_action("multimedia/files/save", "{$plugin_dir}/actions/multimedia/files/save.php");
    elgg_register_action("multimedia/files/remove", "{$plugin_dir}/actions/multimedia/files/remove.php");
    elgg_register_action("multimedia/files/set_options", "{$plugin_dir}/actions/multimedia/files/set_options.php");
    elgg_register_ajax_view('modal/multimedia/file/edit');
    elgg_register_ajax_view('multimedia/file/viewer');
    elgg_register_ajax_view('multimedia/file/upload');
    elgg_register_ajax_view('multimedia/file/attach_action');
    /* Multimedia */
    elgg_register_action("multimedia/resources/add", "{$plugin_dir}/actions/multimedia/resources/add.php");
    elgg_register_action("multimedia/resources/remove", "{$plugin_dir}/actions/multimedia/resources/remove.php");
    elgg_register_action("multimedia/resources/edit", "{$plugin_dir}/actions/multimedia/resources/edit.php");
    elgg_register_ajax_view('modal/multimedia/resource/edit');
    elgg_register_ajax_view('multimedia/viewer');
    elgg_register_ajax_view('multimedia/attach/list');

    // Publications
    elgg_register_action("publications/evaluate", "{$plugin_dir}/actions/publications/evaluate.php");
    elgg_register_action("publications/publish", "{$plugin_dir}/actions/publications/publish.php");
    elgg_register_action("publications/publish/site", "{$plugin_dir}/actions/publications/publish.php");
    elgg_register_action("publications/labels/add", "{$plugin_dir}/actions/publications/labels/add.php");
    elgg_register_ajax_view('modal/publications/publish');
    elgg_register_ajax_view('modal/publications/rating');
    elgg_register_ajax_view('publications/labels/search');
    // Discussion
    elgg_register_action("discussion/create", "{$plugin_dir}/actions/discussion/create.php");
    elgg_register_action("discussion/create_from_multimedia", "{$plugin_dir}/actions/discussion/create_from_multimedia.php");
    elgg_register_action("discussion/remove", "{$plugin_dir}/actions/discussion/remove.php");
    elgg_register_action("discussion/edit", "{$plugin_dir}/actions/discussion/edit.php");
    elgg_register_ajax_view('modal/discussion/edit');
    elgg_register_action("discussion/reply/create", "{$plugin_dir}/actions/discussion/reply/create.php");
    elgg_register_action("discussion/reply/remove", "{$plugin_dir}/actions/discussion/reply/remove.php");
    elgg_register_action("discussion/reply/edit", "{$plugin_dir}/actions/discussion/reply/edit.php");
    elgg_register_ajax_view('modal/discussion/reply/edit');
    elgg_register_ajax_view('discussion/quote');


    // Register javascript files
    $vendors_dir = elgg_get_site_url() . "mod/z04_clipit_activity/vendors";
    $files_upload_js = elgg_get_simplecache_url('js', 'upload');
    elgg_register_simplecache_view('js/upload');
    elgg_register_js('file:upload', $files_upload_js);
    // Raty js modified by clipit
    elgg_register_js('jquery:raty', "{$vendors_dir}/jquery.raty.js", "footer");
    // Tag-it
    elgg_register_js('jquery:tag_it', "{$vendors_dir}/jquery.tag-it.min.js");
    elgg_load_js("jquery:tag_it");
    // Activity javascript libraries
    $activity_js = elgg_get_simplecache_url('js', 'activity');
    elgg_register_simplecache_view('js/activity');
    elgg_register_js('clipit:activity', $activity_js);
//    elgg_register_js('clipit:activity', elgg_get_site_url()."js/activity.js");
    elgg_load_js('clipit:activity');
    // Attach files
    $files_attach_js = elgg_get_simplecache_url('js', 'attach');
    elgg_register_simplecache_view('js/attach');
    elgg_register_js('file:attach', $files_attach_js);
    // jQuery file upload

    $fileupload_js = elgg_get_simplecache_url('js', 'fileupload');
    elgg_register_simplecache_view('js/fileupload');
    elgg_register_js('clipit:fileupload', $fileupload_js, 'footer');
    elgg_load_js('clipit:fileupload');
    // jQuery Multi-select
    elgg_register_js("jquery:multiselect", "{$vendors_dir}/jquery.multi-select.js");
    // jQuery QuickSearch
    elgg_register_js("jquery:quicksearch", "{$vendors_dir}/jquery.quicksearch.js");
    // jQuery QuickSearch
    elgg_register_js("jquery:dynatable", "{$vendors_dir}/jquery.dynatable.min.js");
    // jQuery Chosen
    elgg_register_js("jquery:chosen", "{$vendors_dir}/jquery.chosen.min.js");
    elgg_load_js("jquery:chosen");
    // FullCalendar
    elgg_register_js("fullcalendar:moment", "{$vendors_dir}/fullcalendar/moment.min.js");
    elgg_register_js("fullcalendar", "{$vendors_dir}/fullcalendar/fullcalendar.min.js");
    elgg_register_css("fullcalendar", "{$vendors_dir}/fullcalendar/fullcalendar.css");
    // Timepicker
    elgg_register_js("jquery:timepicker", "{$vendors_dir}/jquery.timepicker.min.js");
    // ChartJS
    elgg_register_js("jquery:chartjs", "{$vendors_dir}/chartjs.min.js");

    elgg_register_plugin_hook_handler("clipit:view:task:resource", "all", "clipit_task_view_videos", 1);
    elgg_register_plugin_hook_handler("clipit:view:task:resource", "all", "clipit_task_view_files", 200);

    // hook action: Task type resource download
    elgg_register_plugin_hook_handler("task:save", "task", "task_upload_save");
    elgg_register_plugin_hook_handler("task:save", "task", "task_resources_save");
    elgg_register_plugin_hook_handler("task:save", "task", "task_other_save");
    // Task extends type Quiz
    elgg_extend_view('tasks/menu', 'tasks/menu/video_upload', 1);
    elgg_extend_view('tasks/menu', 'tasks/menu/file_upload', 2);
    elgg_extend_view('tasks/menu', 'tasks/menu/resource_download', 50);
    elgg_extend_view('tasks/menu', 'tasks/menu/other', 100);

    elgg_extend_view('tasks/container', 'tasks/container/resource_download');
}

function task_resources_save($hook, $entity_type, $returnvalue, $params){
    $activity_id = $params['activity_id'];
    $task = $params['task'];
    $files = array_filter($task['attach_files']);
    $videos = array_filter($task['attach_videos']);

    if($task['type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD) {
        // New task, attach resources
        $task_properties = array_merge(get_task_properties_action($task), array(
            'task_type' => $task['type'],
        ));
        $task_id = ClipitTask::create($task_properties);
        if($params['activity_create']) {
            $new_files_id = array();
            foreach ($files as $file_id) {
                $new_files_id[] = ClipitFile::create_clone($file_id);
            }
            $files = $new_files_id;
            ClipitActivity::add_files($activity_id, $new_files_id);

            $new_videos_id = array();
            foreach ($videos as $video_id) {
                $new_videos_id[] = ClipitVideo::create_clone($video_id);
            }
            $videos = $new_videos_id;
            ClipitActivity::add_videos($activity_id, $new_videos_id);
        }
        ClipitTask::set_files($task_id, $files);
        ClipitTask::set_videos($task_id, $videos);
        // Add task to activity
        ClipitActivity::add_tasks($activity_id, array($task_id));

    } elseif(get_input('task-id') && $task['entity_type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD){
        $task_id = get_input('task-id');
        // Set resources
        ClipitTask::set_files($task_id, $files);
        ClipitTask::set_videos($task_id, $videos);
        // Save task
        ClipitTask::set_properties($task_id, get_task_properties_action($task));
    }
}
function task_upload_save($hook, $entity_type, $returnvalue, $params){
    $activity_id = $params['activity_id'];
    $task = $params['task'];

    if($task['type'] == ClipitTask::TYPE_VIDEO_UPLOAD ||
        $task['type'] == ClipitTask::TYPE_FILE_UPLOAD
    ) {
        $task_properties = array_merge(get_task_properties_action($task), array(
            'task_type' => $task['type'],
        ));
        $task_id = ClipitTask::create($task_properties);
        // Add task to activity
        ClipitActivity::add_tasks($activity_id, array($task_id));
    } elseif(get_input('task-id') &&
        ($task['entity_type'] == ClipitTask::TYPE_VIDEO_UPLOAD ||  $task['entity_type'] == ClipitTask::TYPE_FILE_UPLOAD) ){
        $task_id = get_input('task-id');
        // Save task
        ClipitTask::set_properties($task_id, get_task_properties_action($task));
    }
    if($task['feedback']){
        $task_entity = array_pop(ClipitTask::get_by_id(array($task_id)));
        // Trigger tasks which parent is a upload task
        elgg_trigger_plugin_hook('task:save:upload', 'feedback',
            array(
                'parent_id' => $task_id,
                'activity_id' => $task_entity->activity,
                'feedback_form' => $task['feedback-form']
            ), null);
    }
}
function task_other_save($hook, $entity_type, $returnvalue, $params){
    $task = $params['task'];
    $activity_id = $params['activity_id'];

    if($task['type'] == ClipitTask::TYPE_OTHER){
        $task_properties = array_merge(get_task_properties_action($task), array(
            'task_type' => $task['type'],
        ));
        $task_id = ClipitTask::create($task_properties);
        // Add task to activity
        ClipitActivity::add_tasks($activity_id, array($task_id));
    } elseif(get_input('task-id') && $task['entity_type'] == ClipitTask::TYPE_OTHER){
        $task_id = get_input('task-id');
        // Save task
        ClipitTask::set_properties($task_id, get_task_properties_action($task));
    }
}

function clipit_task_resource_view($task, $view_type, $role){
    $activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
    $href = "clipit_activity/{$activity->id}/resources";
    return elgg_trigger_plugin_hook('clipit:view:task:resource', $view_type,
        array(
            'task' => $task,
            'activity' => $activity,
            'role' => $role,
            'href' => $href
        ), null);
}
function clipit_task_view_files($hook, $view_type, $returnvalue, $params){
    $task = $params['task'];
    $files = ClipitTask::get_files($task->id);
    if ($files) {
        $returnvalue .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("files"),
        ));
        $options = array(
            'entity' => $params['activity'],
            'create' => false,
            'options' => false,
            'entities' => $files,
            'href' => $params['href'],
            'task_id' => $params['role'] == ClipitUser::ROLE_STUDENT ? $task->id : false,
            'task_type' => $task->task_type
        );
        $returnvalue .= elgg_view('multimedia/file/list', $options);
    }

    return $returnvalue;
}
function clipit_task_view_videos($hook, $view_type, $returnvalue, $params){
    $task = $params['task'];
    $videos = ClipitTask::get_videos($task->id);
    if ($videos) {
        $returnvalue .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("videos"),
        ));
        $options = array(
            'entity' => $params['activity'],
            'create' => false,
            'options' => false,
            'entities' => $videos,
            'href' => $params['href'],
            'task_id' => $params['role'] == ClipitUser::ROLE_STUDENT ? $task->id : false,
            'task_type' => $task->task_type
        );
        $returnvalue .= elgg_view('multimedia/video/list', $options);
    }

    return $returnvalue;
}

function activity_setup_sidebar_menus(){
    $activity_id =  elgg_get_page_owner_guid();
    $user_id = elgg_get_logged_in_user_guid();
    if (elgg_in_context('activity_page')) {
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity_id);
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
    elgg_extend_view('forms/activity/create', 'activity/create/step_info', 100);
    elgg_extend_view('forms/activity/create', 'activity/create/step_1', 100);
    elgg_extend_view('forms/activity/create', 'activity/create/step_2', 100);
    elgg_extend_view('forms/activity/create', 'activity/create/step_3', 100);
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
    // Ensure that only logged-in users can see this page
    gatekeeper();
    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    elgg_load_library('clipit:activities');
    elgg_set_context("activity_page");

    $activity = array_pop(ClipitActivity::get_by_id(array($page[0])));
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $called_users = ClipitActivity::get_students($activity->id);
    $isCalled = in_array($user_id, $called_users);
    $isOpen = $activity->public;
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
    $cache = elgg_get_metadata_cache();
    $hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    if($hasGroup || in_array($user_id, $called_users)){
        $access = 'ACCESS_MEMBER';
    } elseif(in_array($user_id, $activity->teacher_array) || $cache->load(elgg_get_logged_in_user_guid(), 'role') == ClipitUser::ROLE_ADMIN) {
        $access = 'ACCESS_TEACHER';
    } elseif($activity->public && $user->role == ClipitUser::ROLE_STUDENT){
        $access = 'ACCESS_MEMBER';
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
                    include("{$activity_dir}/groups.php");
                    break;
                case 'admin':
                    include("{$activity_dir}/admin.php");
                    break;
                case 'join':
                    if($activity->public && ($activity->max_students > count($activity->student_array)) || $activity->max_students == 0) {
                        $groups = ClipitGroup::get_by_id($activity->group_array);
                        natural_sort_properties($groups, 'name');
                        $user_joined = false;
                        ClipitActivity::add_students($activity->id, array($user_id));
                        foreach($groups as $group){
                            if(!$user_joined){
                                if(count($group->user_array) < $activity->max_group_size) {
                                    ClipitActivity::add_students($activity->id, array($user_id));
                                    ClipitGroup::add_users($group->id, array($user_id));
                                    $user_joined = true;
                                }
                            }
                        }
                        if(!$user_joined) {
                            $group_id = ClipitGroup::create(array(
                                'name' => elgg_echo('group') . ' ' . (count($groups) + 1),
                                'user_array' => array($user_id)
                            ));
                            ClipitActivity::add_groups($activity->id, array($group_id));
                        }
//                        include("{$activity_dir}/join.php");
                        forward('clipit_activity/'.$activity->id);
                    }
                    break;
                case 'discussion':
                    include("{$activity_dir}/discussion.php");
                    break;
                case 'tasks':
                    include("{$activity_dir}/tasks.php");
                    break;
                case 'publications':
                    include("{$activity_dir}/publications.php");
                    break;
                case 'resources':
                    include("{$activity_dir}/resources.php");
                    break;
                // Group tools
                case 'group':
                    if($page[2]){ // group/{$group_id}
                        set_input('group_id', (int)$page[2]);
                        include elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity/group.php';
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

    if($hasGroup || $isCalled || $isOpen || $access == 'ACCESS_TEACHER'){
        $activity_menu = elgg_view("activity/sidebar/activity_menu", array('entity' => $activity));
        $activity_menu_sidebar = elgg_view_module('aside', elgg_echo('activity'), $activity_menu);
    }
    // Group sidebar components (group block info + group tools)
    if($isCalled && ($activity_status == ClipitActivity::STATUS_ACTIVE || $activity_status == ClipitActivity::STATUS_CLOSED)){
        $pending_tasks = elgg_view("page/components/pending_tasks", array('entity' => $activity));
        $pending_tasks_sidebar = elgg_view_module('aside', elgg_echo('activity:pending_tasks'), $pending_tasks, array('class' => 'aside-block'));
        if($hasGroup) {
            elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
            $group_menu_sidebar = elgg_view('group/sidebar/group_menu', array('entity' => $activity));
        }
    }
    if($activity_status == ClipitActivity::STATUS_ENROLL && $hasGroup){
        elgg_extend_view("page/elements/owner_block", "page/elements/group_block");
    }
    if(!$hasGroup && $activity->group_mode == ClipitActivity::GROUP_MODE_STUDENT &&
        $activity_status == ClipitActivity::STATUS_ENROLL &&
        $user->role == ClipitUser::ROLE_STUDENT
    ) {
        if($isCalled) {
            // Join to group button
            elgg_extend_view("page/elements/owner_block", "page/components/button_join_group");
        }elseif($isOpen){
            // Join to activity button
            elgg_extend_view("page/elements/owner_block", "page/components/button_join_activity");
        }
    }
    $teachers = ClipitActivity::get_teachers($activity->id);
    $teacher_sidebar = "";
    if(!empty($teachers)){
        // Teacher admin
        if($access == 'ACCESS_TEACHER'){
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
 * My activities page handler, student view
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
 * Activities page handler, only for teacher and admin
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function activities_page_handler($page) {
    $title = elgg_echo('activities');
    $order_by = get_input('order_by');
    $sort = get_input('sort');
    $selected_tab = get_input('filter', 'all');
    $filter = elgg_view('navigation/tabs', array('selected' => $selected_tab, 'href' => $page[0]));
    $sidebar = elgg_view_module('aside', elgg_echo('filter'),
        elgg_view_form(
            'filter_search',
            array(
                'id' => 'add_labels',
                'style' => 'background: #fff;padding: 15px;',
                'body' => elgg_view('activities/sidebar/filter')
            )
        ));
    // Filter search
    if($search = get_input('s')) {
        $all_entities = activity_filter_search($search);
        if($order_by){
            $all_entities = get_entities_order(
                'ClipitActivity',
                $all_entities,
                clipit_get_limit(10),
                clipit_get_offset(),
                $order_by,
                $sort
            );
        } else {
            $all_entities = ClipitActivity::get_by_id($all_entities);
        }
        $count = count($all_entities);
        $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
    } else {
        switch($selected_tab){
            case 'mine':
                $all_entities = ClipitActivity::get_by_id(ClipitUser::get_activities(elgg_get_logged_in_user_guid()));
                break;
            default:
                $all_entities = ClipitActivity::get_all(0, 0, '', true, true);
                if($order_by) {
                    $all_entities = get_entities_order(
                        'ClipitActivity',
                        $all_entities,
                        clipit_get_limit(10),
                        clipit_get_offset(),
                        $order_by,
                        $sort
                    );
                } else {
                    $all_entities = ClipitActivity::get_by_id($all_entities);
                }

                break;
        }
        $count = count($all_entities);
        $entities = array_slice($all_entities, clipit_get_offset(), clipit_get_limit(10));
    }
    $to_order = array(
        'name' => elgg_echo('activity:title'),
        'tricky_topic' => elgg_echo('tricky_topic'),
        'status' => elgg_echo('status'),
    );
    $table_orders = table_order($to_order, $order_by, $sort);
    $content = elgg_view('activities/list', array(
        'entities' => $entities,
        'count' => $count,
        'table_orders' => $table_orders
    ));
    $params = array(
        'content' => $content,
        'title' => $title,
        'filter' => $filter,
        'sidebar' => $sidebar,
    );
    $body = elgg_view_layout('one_sidebar', $params);

    echo elgg_view_page($title, $body);

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
        //$entity = array_pop($entity_class::get_by_id(array($entity_id)));
        $rating = ClipitRating::get_user_rating_for_target($user_id, $entity_id);
        if($group_id != $entity_class::get_group($entity_id)){
            if(!$rating){
                $output["no_evaluated"][] = $entity_id;
            } else {
                $output["evaluated"][] = $entity_id;
            }
        }
    }
    return $output;
}