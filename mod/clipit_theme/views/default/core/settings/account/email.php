<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if ($user) {
	$title = elgg_echo('email:settings');
    $input_name = 'email';
    $input = elgg_view('input/email', array(
        'class' => 'form-control',
        'name'  => $input_name,
        'id'    => $input_name,
        'value' => $user->email,
    ));
    $content = elgg_view("input/form_group", array(
        'label' => elgg_echo('email:address:label').':',
        'name'  => $input_name,
        'input' => $input
    ));
	echo elgg_view_module('info', $title, $content);
}
