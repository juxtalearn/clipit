<?php
/**
 * Elgg registration action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */

elgg_make_sticky_form('register');

// Get variables
$username = get_input('username');
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
$email = get_input('email');
$name = get_input('name');
$friend_guid = (int) get_input('friend_guid', 0);
$invitecode = get_input('invitecode');


if (elgg_get_config('allow_registration')) {
    try {
        if (trim($password) == "" || trim($password2) == "") {
            throw new RegistrationException(elgg_echo('RegistrationException:EmptyPassword'));
        }

        if (strcmp($password, $password2) != 0) {
            throw new RegistrationException(elgg_echo('RegistrationException:PasswordMismatch'));
        }
        // Clipit create user
        $guid = ClipitUser::create(array(
            'login'     => $username,
            'password'  => $password,
            'name'      => $name,
            'email'     => $email
        ));

        if ($guid) {
            ClipitUser::set_role_student($guid);
            $new_user = get_entity($guid);

            elgg_clear_sticky_form('register');
            system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));

            // if exception thrown, this probably means there is a validation
            // plugin that has disabled the user
            try {
                ClipitUser::login($username, $password);
            } catch (LoginException $e) {
                // do nothing
            }

            // Forward on success, assume everything else is an error...
            forward();
        } else {
            register_error(elgg_echo("registerbad"));
        }
    } catch (RegistrationException $r) {
        register_error($r->getMessage());
    }
} else {
    register_error(elgg_echo('registerdisabled'));
}
die();
