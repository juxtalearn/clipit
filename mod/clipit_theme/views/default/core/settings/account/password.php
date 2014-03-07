<?php

/**
 * Provide a way of setting your password
 *
 * @package Elgg
 * @subpackage Core
 */
$user = elgg_get_page_owner_entity();

if ($user) {
	$title = elgg_echo('user:set:password');

	// only make the admin user enter current password for changing his own password.
	$admin = '';
	if (!elgg_is_admin_logged_in() || elgg_is_admin_logged_in() && $user->guid == elgg_get_logged_in_user_guid()) {
		$admin .= elgg_echo('user:current_password:label') . ': ';
		$admin .= elgg_view('input/password', array('name' => 'current_password'));
		$admin = "<p>$admin</p>";
	}

	$password = elgg_echo('user:password:label') . ': ';
	$password .= elgg_view('input/password', array('name' => 'password'));
	$password = "<p>$password</p>";

	$password2 = elgg_echo('user:password2:label') . ': ';
	$password2 .= elgg_view('input/password', array('name' => 'password2'));
	$password2 = "<p>$password2</p>";

	$content = $admin . $password . $password2;
    // Current password
    $input_name_current = 'current_password';
    $input_current = elgg_view('input/password', array(
        'class' => 'form-control',
        'name'  => $input_name_current,
        'id'    => $input_name_current,
    ));
    $content = elgg_view("input/form_group", array(
        'label' => elgg_echo('user:current_password:label').':',
        'name'  => $input_name_current,
        'input' => $input_current
    ));
    // new password
    $input_name_pw1 = 'password';
    $input_pw1 = elgg_view('input/password', array(
        'class' => 'form-control',
        'name'  => $input_name_pw1,
        'id'    => $input_name_pw1,
    ));
    $content .= elgg_view("input/form_group", array(
        'label' => elgg_echo('user:password:label').':',
        'name'  => $input_name_pw1,
        'input' => $input_pw1
    ));
    // repeat new password
    $input_name_pw2 = 'password2';
    $input_pw2 = elgg_view('input/password', array(
        'class' => 'form-control',
        'name'  => $input_name_pw2,
        'id'    => $input_name_pw2,
    ));
    $content .= elgg_view("input/form_group", array(
        'label' => elgg_echo('user:password2:label').':',
        'name'  => $input_name_pw2,
        'input' => $input_pw2
    ));
	echo elgg_view_module('info', $title, $content);
}
