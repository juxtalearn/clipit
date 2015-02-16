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
$body = "";
$href = "clipit_activity/{$activity->id}/resources";

$videos = ClipitTask::get_videos($task->id);
if($videos) {
    $body .= elgg_view("page/components/title_block", array(
        'title' => elgg_echo("videos"),
    ));
    $params = array(
        'entity' => $activity,
        'create' => false,
        'entities' => $videos,
        'href' => $href,
        'task_id' => $task->id
    );
    $body .= elgg_view('multimedia/video/list', $params);
}

$files = ClipitTask::get_files($task->id);
if($files) {
    $body .= elgg_view("page/components/title_block", array(
        'title' => elgg_echo("files"),
    ));
    $params = array(
        'entity' => $activity,
        'create' => false,
        'files' => $files,
        'href' => $href,
        'task_id' => $task->id
    );
    $body .= elgg_view('multimedia/file/list', $params);
}

$storyboards = ClipitTask::get_storyboards($task->id);
if($storyboards) {
    $body .= elgg_view("page/components/title_block", array(
        'title' => elgg_echo("storyboards"),
    ));
    $params = array(
        'entity' => $activity,
        'create' => false,
        'entities' => $storyboards,
        'href' => $href,
        'task_id' => $task->id
    );
    $body .= elgg_view('multimedia/storyboard/list', $params);
}
$resources = ClipitTask::get_resources($task->id);
if($resources) {
    $body .= elgg_view("page/components/title_block", array(
        'title' => elgg_echo("resources"),
    ));
    $params = array(
        'entity' => $activity,
        'create' => false,
        'entities' => $resources,
        'href' => $href,
        'task_id' => $task->id
    );
    $body .= elgg_view('multimedia/resource/list', $params);
}
