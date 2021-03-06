<?php
/**
 * Action to request a new password.
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */

$username = get_input('email');

// allow email addresses
if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
    $username = $users[0]->username;
}

$user = get_user_by_username($username);
if ($user) {
    if (send_new_password_request($user->guid)) {
        system_message(elgg_echo('user:password:resetreq:success'));
    } else {
        register_error(elgg_echo('user:password:resetreq:fail'));
    }
} else {
    register_error(elgg_echo('user:username:notfound', array($username)));
}

forward();
