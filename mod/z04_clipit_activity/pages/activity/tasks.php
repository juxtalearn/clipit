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
    $task_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/task';
    if($task){
        elgg_pop_breadcrumb($title);
        elgg_push_breadcrumb($title, $href);
        elgg_push_breadcrumb($task->name);
        $filter = "";
        $title = elgg_echo('activity:task');
        $status = get_task_status($task);
        switch($task->task_type){
            case ClipitTask::TYPE_VIDEO_UPLOAD:
                require($task_dir. "/video_upload.php");
                break;
            case ClipitTask::TYPE_RESOURCE_UPLOAD:
                require($task_dir. "/resource_upload.php");
                break;
            case ClipitTask::TYPE_STORYBOARD_UPLOAD:
                require($task_dir. "/storyboard_upload.php");
                break;
            case ClipitTask::TYPE_QUIZ_TAKE:
                require($task_dir. "/quiz_take.php");
                break;
            case ClipitTask::TYPE_VIDEO_FEEDBACK:
                require($task_dir. "/video_feedback.php");
                break;
            case ClipitTask::TYPE_RESOURCE_FEEDBACK:
                require($task_dir. "/resource_feedback.php");
                break;
            case ClipitTask::TYPE_STORYBOARD_FEEDBACK:
                require($task_dir. "/storyboard_feedback.php");
                break;
            case ClipitTask::TYPE_RESOURCE_DOWNLOAD:
                require($task_dir. "/resource_download.php");
                break;
            case ClipitTask::TYPE_OTHER:
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