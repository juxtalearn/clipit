<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity_id = get_input('entity-id');
$teachers = get_input('teachers_list');
$remove_teacher = get_input('remove_teacher');
$user_name = get_input('user-name');
$user_login = get_input('user-login');
$user_password = get_input('user-password');
$user_email = get_input('user-email');

for($i = 0; $i < count($user_name); $i++){
    if(trim($user_name[$i]) != "" && trim($user_login[$i]) != "" && trim($user_password[$i]) != "" && trim($user_email[$i]) != ""){
        $user_id = ClipitUser::create(array(
            'login'     => $user_login[$i],
            'password'  => $user_password[$i],
            'name'      => $user_name[$i],
            'email'     => $user_email[$i],
            'role'      => ClipitUser::ROLE_TEACHER,
        ));
        ClipitActivity::add_teachers($activity_id, array($user_id));
    }
}

// Add teachers to activity
if($teachers && !$remove_teacher){
    ClipitActivity::add_teachers($activity_id, $teachers);
}
// Remove teachers
if($remove_teacher){
    ClipitActivity::remove_teachers($activity_id, array($remove_teacher));
}
