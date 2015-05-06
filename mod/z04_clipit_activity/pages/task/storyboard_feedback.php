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
// Teacher view
if($user->role == ClipitUser::ROLE_TEACHER){
    $task_parent = array_pop(ClipitTask::get_by_id(array($task->parent_task)));
    $storyboards = ClipitStoryboard::get_by_id($task_parent->storyboard_array);
    $body = elgg_view('tasks/admin/task_feedback', array(
        'entities'    => $storyboards,
        'activity'      => $activity,
        'task'      => $task,
        'entity_type' => 'storyboards',
        'list_view' => 'multimedia/storyboard/list'
    ));
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $href = "clipit_activity/{$activity->id}/publications";
    $body = "";
    $entities = ClipitTask::get_storyboards($task->parent_task);
    $evaluation_list = get_filter_evaluations($entities, $activity->id);
    $list_no_evaluated = elgg_view('multimedia/storyboard/list_summary', array(
        'entities' => $evaluation_list["no_evaluated"],
        'href' => $href,
        'rating' => true,
        'total_comments' => true,
    ));
    $list_evaluated = elgg_view('multimedia/storyboard/list_summary', array(
        'entities' => $evaluation_list["evaluated"],
        'href' => $href,
        'rating' => true,
        'actions' => false,
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
        $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
    }
}