<?php
/**
 * Provide a way of setting your language prefs
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if ($user) {
	$title = elgg_echo('user:set:language');

    $input_name = 'language';
    $input = elgg_view('input/dropdown', array(
        'class' => 'form-control',
        'name'  => $input_name,
        'id'    => $input_name,
        'value' => $user->language,
        'options_values' => get_installed_translations()
    ));
    $content = elgg_view("input/form_group", array(
        'label' => elgg_echo('user:language:label').':',
        'name'  => $input_name,
        'input' => $input,
        'width' => 3
    ));
	echo elgg_view_module('info', $title, $content);
}
