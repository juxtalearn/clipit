<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/06/14
 * Last update:     18/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = (int)get_input('user_id');

$user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
if($user->role != ClipitUser::ROLE_ADMIN && $user_id != $user->id){
    register_error(elgg_echo('user:edit:no_access'));
    forward(REFERRER);
} else {
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
}

// Set language
set_input('lang', get_input('language'));
set_input('no_forward', true);
include(elgg_get_plugins_path() . 'z03_clipit_site/actions/language/set.php');
// Set user properties
$name = strip_tags(get_input('name'));
$email = get_input('email');
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email = $user->email;
}

ClipitUser::set_properties($user_id, array(
    'name' => $name,
    'email' => $email
));

// Set password
$current_password = get_input('current_password', null, false);
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
if(trim($current_password) != "" && ($password === $password2)){
    $credentials = array(
        'username' => $user->login,
        'password' => $current_password
    );
    if(pam_auth_userpass($credentials)){
        ClipitUser::set_properties($user_id, array(
            'password' => $password2,
        ));
        system_message(elgg_echo('user:password:success'));
        forward("action/logout");
    } else {
        register_error(elgg_echo('LoginException:ChangePasswordFailure'));
    }
}
forward(REFERRER);