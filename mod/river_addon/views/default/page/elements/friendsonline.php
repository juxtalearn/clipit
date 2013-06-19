<?php
/**
 * Friends online module
 *
 */

$title = elgg_echo('river_addon:friends:online');   

$options = array(
	'type' => 'user',
	"limit" => FALSE,
	'relationship' => 'friend',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
	'inverse_relationship' => FALSE,
	'full_view' => FALSE,
	'pagination' => FALSE,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
);		
$friends_online = elgg_get_entities_from_relationship($options);

$result = '';
foreach ($friends_online as $online) {
	if ($online->last_action > time() - 300) {
		$result .= elgg_view_entity_icon($online, 'tiny');
	} 
}
if ($result) {
	echo elgg_view_module('featured', $title, $result);
} else {
	$result = elgg_echo('river_addon:friends:online:none');
	echo elgg_view_module('featured', $title, $result);
}


