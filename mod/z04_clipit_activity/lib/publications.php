<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   4/07/14
 * Last update:     4/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

function publications_get_page_content_list($task_type, $tasks, $href){
    switch($task_type){
        case "video_upload":
            $task_type = "video_upload";
            break;
        case "storyboard_upload":
            $task_type = "video_upload";
            break;
    }
    $entity_tasks = array();
    foreach($tasks as $task_id){
        $task = array_pop(ClipitTask::get_by_id(array($task_id)));
        if($task->task_type == $task_type){
            $task_entity[] = $task->id;
            $entity_tasks[$task->id] = $task->name ." [".date("d M Y", $task->start)." - ".date("d M Y", $task->end)."]";
        }
    }
    $last_task_id = reset($task_entity);
    $get_task = get_input('task_id', $last_task_id);

    $task = array_pop(ClipitTask::get_by_id(array($get_task)));
    $videos = $task->video_array;
    $content = elgg_view('tasks/select', array('entities' => $entity_tasks, 'entity' => $task));

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
    return $content;
}