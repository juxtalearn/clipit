<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/02/2015
 * Last update:     19/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
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
    case 'files':
        $items = $task_parent->file_array;
        break;
}
$output = array();
foreach($activity->student_array as $entity_id){
    $evaluation_list = get_filter_evaluations($items, $task->activity, $entity_id);
    $total = (count($evaluation_list["evaluated"]) + count($evaluation_list["no_evaluated"]));
    $status = ClipitTask::get_completed_status($task->id, $entity_id);
    $content = '<span class="text-muted margin-right-10 count">'.count($evaluation_list["evaluated"]).'/'.$total.'</span>
                <span style="width: 14px;" class="inline-block">
                    '.elgg_view("tasks/icon_entity_status", array("status" => $status)).'
                </span>';
    $output[] = array(
        'entity'=> $entity_id,
        'status' => $content,
    );
}
echo json_encode($output);
die;