<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = get_input('entity-id');
$entity = array_pop(ClipitTask::get_by_id(array($entity_id)));
$task = array_pop(get_input('task'));
$task_array = $task;

if($task['feedback-form'] && $task['title'] == "") {
    $task_array = $task['feedback-form'];
}
$updated = ClipitTask::set_properties($entity_id, array(
    'name' => $task_array['title'],
    'description' => $task_array['description'],
    'start' => get_timestamp_from_string($task_array['start']),
    'end' => get_timestamp_from_string($task_array['end']),
    'quiz' => $task_array['quiz']
));
if($entity->task_type == ClipitTask::TYPE_RESOURCE_DOWNLOAD){
    $files = array_filter(get_input('attach_files'));
    ClipitTask::set_files($entity_id, $files);
    $videos = array_filter(get_input('attach_videos'));
    ClipitTask::set_videos($entity_id, $videos);
    $storyboards = array_filter(get_input('attach_storyboards'));
    ClipitTask::set_storyboards($entity_id, $storyboards);
}
if($task['feedback'] && $task['feedback-form']){
    $task_array = $task['feedback-form'];
    $new_task_id = ClipitTask::create(array(
        'name' => $task_array['title'],
        'description' => $task_array['description'],
        'task_type' => $task_array['type'],
        'start' => get_timestamp_from_string($task_array['start']),
        'end' => get_timestamp_from_string($task_array['end']),
        'parent_task' => $entity_id,
        'quiz' => $task_array['type'] == ClipitTask::TYPE_QUIZ_TAKE ? $task_array['quiz'] : 0
    ));
    $task_object = array_pop(ClipitTask::get_by_id(array($entity_id)));
    ClipitActivity::add_tasks($task_object->activity, array($new_task_id));

}

if($updated){
    system_message(elgg_echo('task:updated'));
} else {
    register_error(elgg_echo("task:cantupdate"));
}

forward(REFERRER);