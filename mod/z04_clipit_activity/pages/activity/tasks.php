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
                if(!$videos){
                    $body = elgg_view('output/empty', array('value' => elgg_echo('task:videos:none', array(elgg_view('output/url',
                        array(
                            'href'=> "clipit_activity/{$activity->id}/group/{$group_id}/repository?filter=videos",
                            'text' => elgg_echo('repository:group')
                        )
                    )))));
                }
                // Group id get parameter
                if( get_input('group_id')){
                    $group_id = get_input('group_id');
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
                            'actions'   => false,
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
                    $body = elgg_view('tasks/admin/task_upload', array(
                        'entities'    => $videos,
                        'activity'      => $activity,
                        'task'      => $task,
                        'list_view' => 'multimedia/video/list'
                    ));
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
                if(!$storyboards){
                    $body = elgg_view('output/empty', array('value' => elgg_echo('task:storyboards:none', array(elgg_view('output/url',
                        array(
                            'href'=> "clipit_activity/{$activity->id}/group/{$group_id}/repository?filter=storyboards",
                            'text' => elgg_echo('repository:group')
                        )
                    )))));
                }
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