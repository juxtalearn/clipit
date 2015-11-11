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
    $users = ClipitUser::get_by_id($activity->student_array, 0, 0, 'name');
    if($users){
        $body = elgg_view('tasks/admin/resource_download', array(
            'activity' => $activity,
            'entities'    => $users,
            'task' => $task,
        ));
    } else {
        $body = elgg_view('output/empty', array('value' => elgg_echo('users:none')));
    }
} elseif($user->role == ClipitUser::ROLE_STUDENT) {
    $body = clipit_task_resource_view($task, 'all', ClipitUser::ROLE_STUDENT);
}