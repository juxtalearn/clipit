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
    elgg_register_library('clipit:activities', elgg_get_plugins_path() . 'z04_clipit_activity/lib/activities.php');
    elgg_register_library('clipit:activity:functions', elgg_get_plugins_path() . 'z04_clipit_activity/lib/functions.php');
    elgg_load_library('clipit:activity:functions');

    // Register "/my_activities" page handler
    elgg_register_page_handler('my_activities', 'my_activities_page_handler');
    // Register "/explore" page handler
    elgg_register_page_handler('explore', 'explore_page_handler');
    // Register "/file" page handler
    elgg_register_page_handler('file', 'file_page_handler');
    // Register "/z04_clipit_activity" page handler
    elgg_register_page_handler('clipit_activity', 'activity_page_handler');
//    elgg_register_entity_url_handler('object', 'z04_clipit_activity', 'activity_url');
    elgg_register_event_handler('pagesetup', 'system', 'activity_setup_sidebar_menus');
    elgg_register_event_handler('pagesetup', 'system', 'group_details_setup_menus');

    // Register actions, ajax views
    // File
    elgg_register_action("files/upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/files/upload.php");
    // Storyboard
    elgg_register_action("storyboards/upload", elgg_get_plugins_path() . "z04_clipit_activity/actions/storyboards/upload.php");
    // Group
    elgg_register_action("group/join", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/join.php");
    elgg_register_action("group/leave", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/leave.php");
    elgg_register_action("group/create", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/create.php");
    elgg_register_action("group/remove_member", elgg_get_plugins_path() . "z04_clipit_activity/actions/group/remove_member.php");
    // Tricky Topic
    elgg_register_ajax_view('modal/tricky_topic/view');
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
    if (elgg_in_context('activity_page') && $hasGroup) {
        $activities = ClipitActivity::get_by_id(array($activity_id));
        $activity = array_pop($activities);
        $params = array(
            'name' => 'activity_aprofile',
            'text' => elgg_echo('activity:profile'),
            'href' => "clipit_activity/".$activity->id,
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'activity_sta',
            'text' => elgg_echo('activity:stas'),
            'href' => "clipit_activity/".$activity->id."/materials",
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
    $activities = ClipitActivity::get_by_id(array($page[0]));
    $activity = array_pop($activities);
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $isCalled = ClipitActivity::get_called_users($activity->id);
    $hasGroup = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    // Default status
    $activity_status = ClipitActivity::get_status($activity->id);
    // Check if activity exists
    if (!$activity ) {
        return false;
    }
    elgg_set_page_owner_guid($activity->id);

    // Activity profile
    if(!isset($page[1])){
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
                    $content =  elgg_view('discussion/list',
                        array(
                            'entity' => $activity,
                            'messages' => $messages,
                            'href'   => $href,
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
                                    'activity'   => $activity,
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
//                    $date = time()+(60*60*24*8);
//                    $date_2 = time()+(60*60*24*12);
//                    $task_id_1 = ClipitTask::create(array(
//                        'name' => 'Video upload',
//                        'start' => time(),
//                        'end' => $date,
//                        'task_type' => 'video_upload'
//                    ));
//                    // Video feedback
//                    $task_id_2 = ClipitTask::create(array(
//                        'name' => 'Video feedback',
//                        'task_type' => 'video_feedback',
//                        'start' => $date,
//                        'end' => $date_2,
//                        'parent_task' => $task_id_1
//                    ));
                    //ClipitActivity::add_tasks(74,array($task_id_1, $task_id_2));
                    $title = elgg_echo("activity:tasks");
                    elgg_push_breadcrumb($title);
                    $tasks = ClipitActivity::get_tasks($activity->id);
                    $href = "clipit_activity/{$activity->id}/tasks";
                    $content = elgg_view('tasks/list', array('tasks' => $tasks, 'href' => $href));
                    if($page[2] == 'view' && $page[3]){
                        $entity_id = (int)$page[3];
                        $task = array_pop(ClipitTask::get_by_id(array($entity_id)));
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
                                        'videos'    => $videos,
                                        'href'      => "clipit_activity/{$activity->id}/group/multimedia",
                                        'task_id'   => $task->id,
                                        'rating'    => false,
                                        'actions'   => true,
                                        'publish'   => true,
                                        'total_comments' => false,
                                    ));

                                    if($status['status'] === true || $task->end <= time()){
                                        $video = array($status['result']);
                                        $body = elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:my_video"),
                                        ));
                                        // Task is completed, show my video
                                        if($status['status'] === true){
                                            $body .= elgg_view('multimedia/video/list', array(
                                                'videos'    => $video,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                        }
                                        // View other videos
                                        $body .= elgg_view("page/components/title_block", array(
                                            'title' => elgg_echo("task:other_videos"),
                                        ));
                                        if(($key = array_search($status['result'], $task->video_array)) !== false) {
                                            unset($task->video_array[$key]);
                                        }
                                        if($task->video_array){
                                            $body .= elgg_view('multimedia/video/list', array(
                                                'videos'    => $task->video_array,
                                                'href'      => $href_publications,
                                                'task_id'   => $task->id,
                                            ));
                                        } else {
                                            $body .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                                        }
                                    }
                                    break;
                                case "quiz_answer":
                                    $body = elgg_view('quizzes/view', array('quiz' => $quiz));
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
                                default:
                                    return false;
                                    break;
                            }
                            $content = elgg_view('tasks/view', array('entity' => $task, 'body' => $body, 'status' => $status));
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

                    switch($selected_tab){
                        case 'videos':
                            // Get last task [type: video_upload]
                            $video_task = array();
                            $tasks = ClipitActivity::get_tasks($activity->id);
                            foreach($tasks as $task_id){
                                $task = array_pop(ClipitTask::get_by_id(array($task_id)));
                                if($task->task_type == 'video_upload'){
                                    $task_video[] = $task;
                                    $video_task[$task->id] = $task->name;
                                }
                            }
                            $last_task = reset($task_video);
                            $get_task = get_input('task_id', $last_task->id);

                            $task = array_pop(ClipitTask::get_by_id(array($get_task)));
                            $videos = $task->video_array;
                            $content = elgg_view('input/dropdown', array(
                                'name' => 'task_id',
                                'id' => 'task_id',
                                'class' => 'form-control',
                                'style' => 'height: auto;margin-bottom: 20px;width: auto;padding: 0;font-weight: bold;',
                                'value' => get_input('task_id'),
                                'onchange' => "location.href='?task_id='+this.value",
                                'options_values' => $video_task
                            ));
                            $content .= elgg_view('multimedia/video/list', array(
                                'videos'    => $videos,
                                'href'      => $href,
                                'rating'    => true,
                                'actions'   => false,
                                'total_comments' => true,
                            ));
                            if (!$videos) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                            }
                            break;
                    }


                    if($page[2] == 'view' && $page[3]){
                        $entity_id = (int)$page[3];
                        $filter = "";
                        elgg_pop_breadcrumb($title);
                        elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/publications");
                        $object = ClipitSite::lookup($entity_id);
                        switch($object['subtype']){
                            // Clipit Video publication
                            case 'ClipitVideo':
                                $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
                                $task_id = ClipitVideo::get_task($entity_id);
                                $videos = ClipitTask::get_videos($task_id);
                                if(!$entity || !in_array($entity_id, $videos)){
                                    return false;
                                }
                                $body = elgg_view("multimedia/video/body", array('entity'  => $entity));
                                $content = elgg_view('publications/view', array('entity' => $entity, 'type' => 'video', 'body' => $body));
                                break;
                            // Clipit Storyboard publication
                            case 'ClipitStoryboard':
                                $entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
                                $sbs = ClipitActivity::get_storyboards($activity->id);
                                if(!$entity || !in_array($entity_id, $sbs)){
                                    return false;
                                }
                                $body = elgg_view("multimedia/storyboard/body", array('entity'  => $entity));
                                $content = elgg_view('publications/view', array('entity' => $entity, 'type' => 'storyboard', 'body' => $body));
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
                case 'materials':
                    $title = elgg_echo("activity:stas");
                    elgg_push_breadcrumb($title);
                    $selected_tab = get_input('filter', 'files');
                    $href = "clipit_activity/{$activity->id}/materials";
                    switch ($selected_tab) {
                        case 'files':
                            $files = ClipitActivity::get_files($activity->id);
                            $add_files = false;
                            // Add files button for teacher
                            if($user->role == 'teacher'){
                                $add_files = true;
                            }
                            $content = elgg_view('multimedia/file/list', array('entity' => $activity, 'add_files' => $add_files, 'files' => $files, 'href' => $href));
                            if (!$files) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                            }
                            break;
                        case 'videos':
                            $teacher = false;
                            // Add files button for teacher
                            if($user->role == 'teacher'){
                                $teacher = true;
                            }
                            $videos = ClipitActivity::get_videos($activity->id);
                            $content = elgg_view('multimedia/video/list', array(
                                'entity' => $activity,
                                'add_video' => $teacher,
                                'actions'   => $teacher,
                                'videos' => $videos,
                                'href' => $href
                            ));
                            if (!$videos) {
                                $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                            }
                            break;
                        case 'storyboards':
                            $sbs = "";
                            $add_sbs = false;
                            if($user->role == 'teacher'){
                                $add_sbs = true;
                            }
                            $content = elgg_view('multimedia/storyboard/list', array(
                                'entity' => $activity,
                                'add_sb' => $add_sbs,
                                'storyboards' => $sbs,
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
                        elgg_pop_breadcrumb($entity->name);
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

    $teachers = ClipitActivity::get_teachers($activity->id);
    $teacher_sidebar = "";
    if(!empty($teachers)){
        $teacher_sidebar = elgg_view('activity/sidebar/teacher', array('teachers' => $teachers));
    }

    $params['sidebar'] = $group_tools_sidebar . $teacher_sidebar;
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
    $group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    if(!$group){
        return false;
    }
    elgg_push_breadcrumb($group->name, "clipit_activity/{$activity->id}/group");
    // set group icon status from activity status
    $activity_status = ClipitActivity::get_status($activity->id);
    $icon_status = "lock";
    if($activity_status == 'enroll'){
        $icon_status = "unlock";
    }
    $group_name = '<i class="fa fa-'.$icon_status.'"></i> '.$group->name;
    $filter = "";
    switch ($page[2]) {
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
            $href = "clipit_activity/{$activity->id}/group/multimedia";
            switch ($selected_tab) {
                case 'files':
                    $files = ClipitGroup::get_files($group->id);
                    $content = elgg_view('multimedia/file/list', array(
                        'entity' => $group,
                        'add_files' => true,
                        'files' => $files,
                        'href' => $href
                    ));
                    if (!$files) {
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                    }
                    break;
                case 'videos':
                    $videos = ClipitGroup::get_videos($group->id);
                    $content = elgg_view('multimedia/video/list', array(
                        'entity' => $group,
                        'add_video' => true,
                        'videos' => $videos,
                        'actions'   => true,
                        'href' => $href
                    ));
                    if (!$videos) {
                        $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                    }
                    break;
                case 'storyboards':
                    $sbs = ClipitGroup::get_storyboards($group->id);
                    $content = elgg_view('multimedia/storyboard/list', array(
                        'entity' => $group,
                        'add_sb' => true,
                        'storyboards' => $sbs,
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
            $filter = elgg_view('multimedia/filter', array('selected' => $selected_tab, 'entity' => $group, 'href' => $href));
            if($page[3] == 'download' && $page[4]){
                $file_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/file';
                set_input('id', $page[4]);
                include "$file_dir/download.php";
            }
            if($page[4]){
                $entity_id = (int)$page[4];
                switch($page[3]){
                    case "view":
                        elgg_pop_breadcrumb($entity->name);
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
                            default:
                                return false;
                                break;
                        }
                        break;
                    case "publish":
                        $entity_id = (int)$page[4];
                        elgg_pop_breadcrumb($entity->name);
                        $object = ClipitSite::lookup($entity_id);
                        switch($object['subtype']){
                            // Clipit Video
                            case 'ClipitVideo':
                                $subtitle = elgg_echo("video");
                                elgg_push_breadcrumb(elgg_echo("videos"), $href."?filter=videos");
                                $entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));
                                break;
                            // Clipit StoryBoard
                            case 'ClipitStoryBoard':
                                $subtitle = elgg_echo("storyboard");
                                elgg_push_breadcrumb(elgg_echo("storyboards"), $href."?filter=storyboards");
                                $entity = array_pop(ClipitStoryboard::get_by_id(array($entity_id)));
                                break;
                            default:
                                return false;
                                break;
                        }
                        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
                        $tags = $tricky_topic->tag_array;
                        $content = elgg_view_form('publications/publish', array('data-validate'=> "true" ),
                            array(
                                'entity'  => $entity,
                                'parent_id' => $group->id,
                                'activity' => $activity,
                                'tags' => $tags,
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
            $href = "clipit_activity/{$activity->id}/group/discussion";
            elgg_push_breadcrumb($title);
            $messages = array_pop(ClipitPost::get_by_destination(array($group->id)));
            $content =  elgg_view('discussion/list',
                    array(
                        'entity' => $group,
                        'messages' => $messages,
                        'href'   => $href,
                    ));
            if(!$messages){
                $content .= elgg_view('output/empty', array('value' => elgg_echo('discussions:none')));
            }
            if($page[3] == 'view' && $page[4]){
                $message_id = (int)$page[4];
                $message = array_pop(ClipitPost::get_by_id(array($message_id)));
                elgg_pop_breadcrumb($title);
                elgg_push_breadcrumb($title, $href);
                elgg_push_breadcrumb($message->name);
                if($message && $message->destination == $group->id){
                    $content = elgg_view('discussion/view', array('entity' => $message));
                } else {
                    return false;
                }
            }
            break;
        default:
            return false;
    }
    // Default group params
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
 * Explore page handler
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function explore_page_handler($page) {
    $current_user = elgg_get_logged_in_user_entity();

    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }

    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    $vars = array();
    $vars['page'] = $page[0];

    require_once "$base_dir/explore.php";

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