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
$user_name = get_input('user-name');
$user_login = get_input('user-login');
$user_password = get_input('user-password');
$user_email = get_input('user-email');
for($i=0; $i < count($user_name); $i++){
    if(trim($user_name[$i]) != "" && trim($user_login[$i]) != "" && trim($user_password[$i]) != "" && trim($user_email[$i]) != ""){
        $user_id = ClipitUser::create(array(
            'login'     => $user_login[$i],
            'password'  => $user_password[$i],
            'name'      => $user_name[$i],
            'email'     => $user_email[$i],
            'role'      => ClipitUser::ROLE_STUDENT
        ));
        $output[] = array(
            'name' => $user_name[$i],
            'id' => $user_id,
        );
    }
}
echo json_encode($output);
die();