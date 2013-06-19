<?php
/**
 * Latest Groups
 *
 */

elgg_push_context('widgets');

$title = elgg_view('output/url', array(
	'href' => "/groups/all",
	'text' => elgg_echo('river_addon:latest:groups'),
	'is_trusted' => true,
));

$num = (int) elgg_get_plugin_setting('num_groups', 'river_addon');

$options = array(
	'type' => 'group', 
	'full_view' => FALSE,
	'pagination' => FALSE,
	'limit' => $num,
);
$groups = elgg_list_entities($options);

elgg_pop_context();

if ($groups) {
	echo elgg_view_module('aside', $title, $groups);
} else {
	$groups = elgg_echo('river_addon:groups:none');
	echo elgg_view_module('aside', $title, $groups);
}
