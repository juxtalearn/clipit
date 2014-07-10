<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/07/14
 * Last update:     9/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
print_r($_FILES);
die();
$user_name = get_input('user-name');
$user_login = get_input('user-login');
$user_password = get_input('user-password');
$user_email = get_input('user-email');
for($i=0; $i < count($user_name); $i++){
    $output[] = array(
        'name' => $user_name[$i],
        'id' => mt_rand(10,500),
    );
}
echo json_encode($output);
die();