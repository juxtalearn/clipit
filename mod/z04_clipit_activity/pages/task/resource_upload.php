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
$resources = ClipitGroup::get_resources($group_id);
$href_publications = "clipit_activity/{$activity->id}/publications";
$body = elgg_view('multimedia/resource/list', array(
    'entities'    => $resources,
    'href'      => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
    'task_id'   => $task->id,
    'rating'    => false,
    'actions'   => false,
    'publish'   => true,
    'total_comments' => false,
));
if(!$resources){
    $body = elgg_view('output/empty', array('value' => elgg_echo('task:resources:none', array(elgg_view('output/url',
        array(
            'href'=> "clipit_activity/{$activity->id}/group/{$group_id}/repository?filter=resources",
            'text' => elgg_echo('repository:group')
        )
    )))));
}
// Group id get parameter
if( get_input('group_id')){
    $group_id = get_input('group_id');
    $object = ClipitSite::lookup($group_id);
    $status = get_task_status($task, $group_id);
    $resource = array($status['result']);
    $super_title = $object['name'];
    if($status['status']){
        $body .= elgg_view('multimedia/resource/list', array(
            'entities'    => $resource,
            'href'      => $href_publications,
            'task_id'   => $task->id,
        ));
    } else {
        $body = elgg_view('output/empty', array('value' => elgg_echo('resources:none')));
    }
}


if($status['status'] === true || $task->end <= time()){
    $resource = array($status['result']);
    $body = elgg_view("page/components/title_block", array(
        'title' => elgg_echo("task:my_resource"),
    ));
    // Task is completed, show my video
    if($status['status'] === true){
        $body .= elgg_view('multimedia/resource/list', array(
            'entities'    => $resource,
            'href'      => $href_publications,
            'task_id'   => $task->id,
        ));
    } else {
        $body = elgg_view('multimedia/resource/list', array(
            'entities'    => $resources,
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
        'title' => elgg_echo("task:other_resources"),
    ));
    if(($key = array_search($status['result'], $task->resource_array)) !== false) {
        unset($task->resource_array[$key]);
    }
    if($task->resource_array){
        $body .= elgg_view('multimedia/resource/list', array(
            'videos'    => $task->resource_array,
            'href'      => $href_publications,
            'task_id'   => $task->id,
        ));
    } else {
        $body .= elgg_view('output/empty', array('value' => elgg_echo('resources:none')));
    }
}
// Teacher view
if($user->role == ClipitUser::ROLE_TEACHER){
    $resources = ClipitResource::get_by_id($task->resource_array);
    $body = elgg_view('tasks/admin/task_upload', array(
        'entities'    => $resources,
        'activity'      => $activity,
        'task'      => $task,
        'list_view' => 'multimedia/resource/list'
    ));
}