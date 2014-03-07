<?php
/**
 * Action to reset a password and send success email.
 *
 * @package Elgg
 * @subpackage Core
 */

function execute_new_password($user_guid, $conf_code, $password) {
    global $CONFIG;

    $user_guid = (int)$user_guid;
    $user = get_entity($user_guid);

    if ($user instanceof ElggUser) {
        $saved_code = $user->getPrivateSetting('passwd_conf_code');

        if ($saved_code && $saved_code == $conf_code && $password) {

            if (force_user_password_reset($user_guid, $password)) {
                remove_private_setting($user_guid, 'passwd_conf_code');
                // clean the logins failures
                reset_login_failure_count($user_guid);

                login($user);
                return true;
               /* return notify_user($user->guid, $CONFIG->site->guid,
                    elgg_echo('email:resetpassword:subject'), $email, array(), 'email');*/
            }
        }
    }

    return FALSE;
}

$user_guid = get_input('u');
$code = get_input('c');
$user = get_user((int)$user_guid);
$password = get_input('password');
$password2 = get_input('password2');
try{
    if (trim($password) == "" || trim($password2) == "") {
        throw new RegistrationException(elgg_echo('RegistrationException:EmptyPassword'));
    }

    if (strcmp($password, $password2) != 0) {
        throw new RegistrationException(elgg_echo('RegistrationException:PasswordMismatch'));
    }
    if (execute_new_password($user_guid, $code, $password)) {
        throw new RegistrationException(elgg_echo('user:password:success'));
    } else {
        throw new RegistrationException(elgg_echo('user:password:fail'));
    }
} catch (RegistrationException $r) {
    register_error($r->getMessage());
}
forward();
exit;
