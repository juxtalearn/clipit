<?php
/**
 * Group membership module
 *
 */

elgg_push_context('widgets');

$user = elgg_get_logged_in_user_entity();
$user_guid = $user->getGUID();

$title = elgg_echo('groups:widget:membership');

$group_count = elgg_get_plugin_user_setting('group_count', $user_guid, 'river_addon');

$options = array(
	'type' => 'group',
	'limit' => $group_count,
	'relationship' => 'member',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
	'full_view' => FALSE,
	'pagination' => FALSE
);
$mygroups = elgg_list_entities_from_relationship($options);

elgg_pop_context();

if ($mygroups) {
	echo elgg_view_module('aside', $title, $mygroups);
} else {
	$url = "groups/all";
	$visit = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('river_addon:groups:join'),
		'is_trusted' => true,
	));
	$mygroups = elgg_echo ('river_addon:groups:none') . $visit;
	echo elgg_view_module('aside', $title, $mygroups);
}