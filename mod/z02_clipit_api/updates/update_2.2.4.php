<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */

// Update ClipitTask->quiz from static int to relationship
$task_array = ClipitTask::get_all(0, 0, "", true, true);
foreach($task_array as $task_id){
    $elgg_object = get_entity((int)$task_id);
    $quiz = $elgg_object->get("quiz");
    if(!empty($quiz)){
        ClipitTask::set_properties((int)$task_id, array("quiz" => (int)$quiz));
    }
    $elgg_object->set("quiz", null);
}
