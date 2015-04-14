<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 13/04/2015
 * Time: 17:27
 */

// Update all activity and task end times adding 23h 45 mins = 85500 secs so they cover the whole end day
$offset = 85500;
$activity_array = ClipitActivity::get_all();
foreach($activity_array as $activity){
    if($activity->end)
    ClipitActivity::set_properties((int)$activity->id, array("end" => (int)$activity->end + $offset));
}

$task_array = ClipitTask::get_all();
foreach($task_array as $task){
    ClipitTask::set_properties((int)$task->id, array("end" => (int)$task->end + $offset));
}