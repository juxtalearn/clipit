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

$videos = ClipitGroup::get_videos($group_id);
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