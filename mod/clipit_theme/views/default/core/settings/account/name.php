<?php
/**
 * Provide a way of setting your full name.
 *
 * @package Elgg
 * @subpackage Core
 */

global $CONFIG;


$user = elgg_get_page_owner_entity();


$params = array(
    'name' => '1_avatar',
    'href' => "avatar/edit/{$user->username}",
    'text' => elgg_echo('avatar:edit'),
);
elgg_register_menu_item('page', $params);


if ($user) {
	$title = elgg_echo('user:name:label');
    $input_name = 'name';
    $input = elgg_view('input/text', array(
        'class' => 'form-control',
		'name'  => $input_name,
        'id'    => $input_name,
		'value' => $user->name,
	));
    $content = elgg_view("input/form_group", array(
        'label' => elgg_echo('name').':',
        'name'  => $input_name,
        'input' => $input
    ));
	echo elgg_view_module('info', $title, $content);

	// need the user's guid to make sure the correct user gets updated
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
}
