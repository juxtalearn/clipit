<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/02/2015
 * Last update:     19/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task_id = get_input('task');
$type = get_input('type');
$task = array_pop(ClipitTask::get_by_id(array($task_id)));
$task_parent = array_pop(ClipitTask::get_by_id(array($task->parent_task)));
$activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
switch($type){
    case 'videos':
        $items = $task_parent->video_array;
        break;
    case 'storyboards':
        $items = $task_parent->storyboard_array;
        break;
}
$output = array();
foreach($activity->student_array as $entity_id){
    $evaluation_list = get_filter_evaluations($items, $task->activity, $entity_id);
    $total = (count($evaluation_list["evaluated"]) + count($evaluation_list["no_evaluated"]));
    $output[] = array(
        'entity'=> $entity_id,
        'count' => count($evaluation_list["evaluated"]).'/'.$total,
//        'status' => count($evaluation_list["evaluated"]).'/'.count($task_parent->video_array),
    );
}
echo json_encode($output);
die;