<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/07/14
 * Last update:     9/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$file = $_FILES['upload-users'];
$activity_id = get_input('entity-id');

$groups = ClipitUser::import_data($file['tmp_name']);
$output = array();
foreach($groups as $group_name => $users){
    $output[$group_name] = array();
    foreach($users as $user_id){
        $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        if($user->role == ClipitUser::ROLE_STUDENT) {
            $output[$group_name][] = array(
                'name' => $user->name,
                'id' => $user->id,
            );
            if($activity_id){
                ClipitActivity::add_students($activity_id, array($user->id));
            }
        }
    }
}

echo json_encode($output);
die();