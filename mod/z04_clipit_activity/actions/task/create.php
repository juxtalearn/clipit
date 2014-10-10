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
$tasks = get_input('task');
foreach($tasks as $task){
    $task_id = ClipitTask::create(array(
        'name' => $task['title'],
        'description' => $task['description'],
        'task_type' => $task['type'],
        'start' => get_timestamp_from_string($task['start']),
        'end' => get_timestamp_from_string($task['end']),
        'quiz' => $task['type'] == ClipitTask::TYPE_QUIZ_TAKE ? $task['quiz'] : 0
    ));
    ClipitActivity::add_tasks($entity_id, array($task_id));
    if($task['feedback']){
        $feedback = $task['feedback-form'];
        if($feedback['title'] && $feedback['type'] && $feedback['start'] && $feedback['end'] ){
            $feedback_task_id = ClipitTask::create(array(
                'name' => $feedback['title'],
                'description' => $feedback['description'],
                'task_type' => $feedback['type'],
                'start' => get_timestamp_from_string($feedback['start']),
                'end' => get_timestamp_from_string($feedback['end']),
                'parent_task' => $task_id
            ));
            ClipitActivity::add_tasks($entity_id, array($feedback_task_id));
        }
    }
}
forward(REFERRER);