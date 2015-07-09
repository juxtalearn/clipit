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
if(hasTeacherAccess($user->role)){
    $storyboards = ClipitFile::get_by_id($task->storyboard_array);
    $body = elgg_view('tasks/admin/task_upload', array(
        'entities'    => $storyboards,
        'activity'      => $activity,
        'task'      => $task,
        'entity_type'      => 'storyboards',
        'list_view' => 'multimedia/storyboard/list'
    ));
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $storyboards = ClipitGroup::get_files($group_id);
    $href_publications = "clipit_activity/{$activity->id}/publications";
    $body = elgg_view('multimedia/storyboard/list', array(
        'entities' => $storyboards,
        'entity' => array_pop(ClipitGroup::get_by_id(array($group_id))),
        'create' => true,
        'create_form' => elgg_view('input/hidden', array(
            'name' => 'select-task',
            'value' => $task->id
        )),
        'href' => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
        'task_id' => $task->id,
        'publish' => true,
    ));
    if (!$storyboards) {
        $body .= elgg_view('output/empty', array('value' => elgg_echo('task:storyboards:none')));
    }
// Group id get parameter
    if (get_input('group_id')) {
        $group_id = get_input('group_id');
        $object = ClipitSite::lookup($group_id);
        $status = get_task_status($task, $group_id);
        $storyboard = array($status['result']);
        $super_title = $object['name'];
        if ($status['status']) {
            $body .= elgg_view('multimedia/storyboard/list', array(
                'entities' => $storyboard,
                'href' => $href_publications,
                'task_id' => $task->id,
            ));
        } else {
            $body = elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
        }
    }
    if ($status['status'] === true || $task->end <= time()) {
        $storyboard = array($status['result']);
        $body = elgg_view("page/components/title_block", array(
            'title' => elgg_echo("task:my_storyboard"),
        ));
        // Task is completed, show my sb
        if ($status['status'] === true) {
            $body .= elgg_view('multimedia/storyboard/list_summary', array(
                'entities' => $storyboard,
                'unlink' => true,
                'href' => $href_publications,
                'task_id' => $task->id,
            ));
        } else {
            $body = elgg_view('multimedia/storyboard/list', array(
                'entities' => $storyboards,
                'entity' => array_pop(ClipitGroup::get_by_id(array($group_id))),
                'create' => true,
                'create_form' => elgg_view('input/hidden', array(
                    'name' => 'select-task',
                    'value' => $task->id
                )),
                'href' => "clipit_activity/{$activity->id}/group/{$group_id}/repository",
                'task_id' => $task->id,
                'rating' => false,
                'actions' => false,
                'publish' => true,
                'total_comments' => false,
            ));
        }
        // View other storyboards
        $body .= elgg_view("page/components/title_block", array(
            'title' => elgg_echo("task:other_storyboards"),
        ));
        if (($key = array_search($status['result'], $task->storyboard_array)) !== false) {
            unset($task->storyboard_array[$key]);
        }
        if ($task->storyboard_array) {
            $body .= elgg_view('multimedia/storyboard/list_summary', array(
                'entities' => $task->storyboard_array,
                'href' => $href_publications,
                'task_id' => $task->id,
            ));
        } else {
            $body .= elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
        }
    }
}