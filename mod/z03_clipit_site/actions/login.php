<?php
/**
 * Elgg login action
 *
 * @package Elgg.Core
 * @subpackage User.Authentication
 */

// set forward url
if (!empty($_SESSION['last_forward_from'])) {
    $forward_url = $_SESSION['last_forward_from'];
} elseif (get_input('returntoreferer')) {
    $forward_url = REFERER;
} else {
    // forward to main index page
    $forward_url = '';
}

$username = get_input('username');
$password = get_input('password', null, false);
$persistent = (bool) get_input("persistent");
$result = false;

if (empty($username) || empty($password)) {
    register_error(elgg_echo('login:empty'));
    forward();
}


$result = elgg_authenticate($username, $password);
if ($result !== true) {
    register_error($result);
    forward(REFERER);
}

$user = get_user_by_username($username);
if (!$user) {
    register_error(elgg_echo('login:baduser'));
    forward(REFERER);
}
try {
    ClipitUser::login($username, $password, $persistent);
} catch (Exception $e) {
    register_error($e->getMessage());
    forward(REFERER);
}

// elgg_echo() caches the language and does not provide a way to change the language.
// @todo we need to use the config object to store this so that the current language
// can be changed. Refs #4171
if ($user->language) {
    $message = elgg_echo('loginok', array(), $user->language);
} else {
    $message = elgg_echo('loginok');
}

system_message($message);
forward($forward_url);