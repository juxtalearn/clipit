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
    $entity_tasks = array();
    foreach($tasks as $task_id){
        $task = array_pop(ClipitTask::get_by_id(array($task_id)));
        if($task->task_type == $task_type && $task->status != ClipitTask::STATUS_LOCKED){
            $task_entity[] = $task->id;
            $entity_tasks[$task->id] = $task->name ." [".date("d M Y", $task->start)." - ".date("d M Y", $task->end)."]";
        }
    }
    $last_task_id = reset($task_entity);
    $get_task = get_input('task_id', $last_task_id);
    $task = array_pop(ClipitTask::get_by_id(array($get_task)));
    switch($task_type){
        case "video_upload":
            $view = 'multimedia/video/list';
            $entities = $task->video_array;
            $none_msg = elgg_echo('videos:none');
            break;
        case ClipitTask::TYPE_RESOURCE_UPLOAD:
            $view = 'multimedia/resource/list';
            $entities = $task->resource_array;
            $none_msg = elgg_echo('resources:none');
            break;
        case "storyboard_upload":
            $view = 'multimedia/storyboard/list_summary';
            $entities = $task->storyboard_array;
            $none_msg = elgg_echo('storyboards:none');
            break;
    }

    $content = elgg_view('tasks/select', array('entities' => $entity_tasks, 'entity' => $task));

    $content .= elgg_view($view, array(
        'entities'    => $entities,
        'href'      => $href,
        'rating'    => true,
        'actions'   => false,
        'total_comments' => true,
    ));
    if (!$entities) {
        $content .= elgg_view('output/empty', array('value' => $none_msg));
    }
    return $content;
}