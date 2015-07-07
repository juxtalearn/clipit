<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/10/2014
 * Last update:     10/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
// Teacher view
if(hasTeacherAccess($user->role)){
    $users = ClipitUser::get_by_id($activity->student_array, 0, 0, 'name');
    if($users){
        $body = elgg_view('tasks/admin/resource_download', array(
            'activity' => $activity,
            'entities'    => $users,
            'task' => $task,
        ));
    } else {
        $body = elgg_view('output/empty', array('value' => elgg_echo('users:none')));
    }
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $body = "";
    $href = "clipit_activity/{$activity->id}/resources";

    $videos = ClipitTask::get_videos($task->id);
    if ($videos) {
        $body .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("videos"),
        ));
        $params = array(
            'entity' => $activity,
            'create' => false,
            'entities' => $videos,
            'href' => $href,
            'task_id' => $task->id,
            'task_type' => $task->task_type
        );
        $body .= elgg_view('multimedia/video/list', $params);
    }

    $files = ClipitTask::get_files($task->id);
    if ($files) {
        $body .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("files"),
        ));
        $params = array(
            'entity' => $activity,
            'create' => false,
            'options' => false,
            'files' => $files,
            'href' => $href,
            'task_id' => $task->id
        );
        $body .= elgg_view('multimedia/file/list', $params);
    }

    $storyboards = ClipitTask::get_storyboards($task->id);
    if ($storyboards) {
        $body .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("storyboards"),
        ));
        $params = array(
            'entity' => $activity,
            'create' => false,
            'entities' => $storyboards,
            'href' => $href,
            'task_id' => $task->id,
            'task_type' => $task->task_type
        );
        $body .= elgg_view('multimedia/storyboard/list', $params);
    }
}