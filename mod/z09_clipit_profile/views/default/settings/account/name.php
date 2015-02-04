<?php
/**
 * Provide a way of setting your full name.
 *
 * @package Elgg
 * @subpackage Core
 */
$user = elgg_extract('entity', $vars);

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
        'label' => elgg_echo('user:name').':',
        'name'  => $input_name,
        'input' => $input
    ));
	echo elgg_view_module('info', $title, $content);

}
