<?php
/**
 * Provide a way of setting your full name.
 *
 * @package Elgg
 * @subpackage Core
 */
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));

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

}
