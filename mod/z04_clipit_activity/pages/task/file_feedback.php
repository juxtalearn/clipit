<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/10/2014
 * Last update:     10/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Teacher view
if(hasTeacherAccess($user->role)){
    $task_parent = array_pop(ClipitTask::get_by_id(array($task->parent_task)));
    $files = ClipitFile::get_by_id($task_parent->file_array);
    $body = elgg_view('tasks/admin/task_feedback', array(
        'entities'    => $files,
        'activity'      => $activity,
        'task'      => $task,
        'entity_type' => 'files',
        'list_view' => 'multimedia/file/list'
    ));
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $href = "clipit_activity/{$activity->id}/publications";
    $body = "";
    $entities = ClipitTask::get_files($task->parent_task);
    $evaluation_list = get_filter_evaluations($entities, $activity->id);
    $list_no_evaluated = elgg_view('multimedia/file/list_summary', array(
        'entities' => $evaluation_list["no_evaluated"],
        'href' => $href,
        'rating' => true,
        'preview' => false,
        'total_comments' => true,
    ));
    $list_evaluated = elgg_view('multimedia/file/list_summary', array(
        'entities' => $evaluation_list["evaluated"],
        'href' => $href,
        'preview' => false,
        'rating' => true,
        'options' => false,
        'total_comments' => true,
    ));
// No Evaluated section
    if (count($evaluation_list["no_evaluated"]) > 0) {
        $title_block_no_evaluated = elgg_view("page/components/title_block", array(
            'title' => elgg_echo("publications:no_evaluated")
        ));
        $body .= $title_block_no_evaluated . $list_no_evaluated;
    }
// Evaluated section
    if (count($evaluation_list["evaluated"]) > 0) {
        $title_block_evaluated = elgg_view("page/components/title_block", array(
            'title' => elgg_echo("publications:evaluated")
        ));
        $body .= $title_block_evaluated . $list_evaluated;
    }
    if (!$entities) {
        $body = elgg_view('output/empty', array('value' => elgg_echo('files:none')));
    }
}