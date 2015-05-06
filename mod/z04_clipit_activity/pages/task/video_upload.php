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
if($user->role == ClipitUser::ROLE_TEACHER){
    $videos = ClipitVideo::get_by_id($task->video_array);
    $body = elgg_view('tasks/admin/task_upload', array(
        'entities'    => $videos,
        'activity'      => $activity,
        'task'      => $task,
        'entity_type'      => 'videos',
        'list_view' => 'multimedia/video/list'
    ));
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $videos = ClipitGroup::get_videos($group_id);
    $href_publications = "clipit_activity/{$activity->id}/publications";

    $body = elgg_view('multimedia/video/list', array(
        'entities' => $videos,
        'entity' => array_pop(ClipitGroup::get_by_id(array($group_id))),
        'create' => true,
        'create_form' => elgg_view('input/hidden', array(
            'name' => 'select-task',
            'value' => $task->id
        )),
        'href' => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
        'task_id' => $task->id,
        'rating' => false,
        'actions' => false,
        'publish' => true,
        'total_comments' => false,
    ));
    if (!$videos) {
        $body .= elgg_view('output/empty', array('value' => elgg_echo('task:videos:none')));
    }
// Group id get parameter
    if (get_input('group_id')) {
        $group_id = get_input('group_id');
        $object = ClipitSite::lookup($group_id);
        $status = get_task_status($task, $group_id);
        $video = array($status['result']);
        $super_title = $object['name'];
        if ($status['status']) {
            $body .= elgg_view('multimedia/video/list', array(
                'entities' => $video,
                'href' => $href_publications,
                'task_id' => $task->id,
            ));
        } else {
            $body = elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
        }
    }


    if ($status['status'] === true || $task->end <= time()) {
        $video = array($status['result']);
        $body = elgg_view("page/components/title_block", array(
            'title' => elgg_echo("task:my_video"),
        ));
        // Task is completed, show my video
        if ($status['status'] === true) {
            $unlink = false;
            if ($task->status == ClipitTask::STATUS_ACTIVE) {
                $unlink = true;
            }
            $body .= elgg_view('multimedia/video/list', array(
                'entities' => $video,
                'href' => $href_publications,
                'task_id' => $task->id,
                'unlink' => $unlink
            ));
        } else {
            $body = elgg_view('multimedia/video/list', array(
                'entities' => $videos,
                'entity' => array_pop(ClipitGroup::get_by_id(array($group_id))),
                'create' => true,
                'create_form' => elgg_view('input/hidden', array(
                    'name' => 'select-task',
                    'value' => $task->id
                )),
                'href' => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                'task_id' => $task->id,
                'rating' => false,
                'actions' => false,
                'publish' => true,
                'total_comments' => false,
            ));
        }
        // View other videos
        $body .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("task:other_videos"),
        ));
        if (($key = array_search($status['result'], $task->video_array)) !== false) {
            unset($task->video_array[$key]);
        }
        if ($task->video_array) {
            $body .= elgg_view('multimedia/video/list_summary', array(
                'videos' => $task->video_array,
                'href' => $href_publications,
                'task_id' => $task->id,
            ));
        } else {
            $body .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
        }
    }

}