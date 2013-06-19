<?php
/**
 * Friends module
 *
 */

$user = elgg_get_logged_in_user_entity();
$friends = $user->getFriends("", 0, false);

foreach ($friends as $friend) {
	$count = count($friends);
}

$title = elgg_view('output/url', array(
	'href' => "/friends/$user->username",
	'text' => elgg_echo('friends'),
	'is_trusted' => true,
));

$num = (int) elgg_get_plugin_setting('num_friends', 'river_addon');

$options = array(
	'type' => 'user',
	"limit" => $num,
	'relationship' => 'friend',
	'relationship_guid' => elgg_get_logged_in_user_guid(),
	'inverse_relationship' => false,
	'full_view' => false,
	'pagination' => false,
	'list_type' => 'gallery',
	'order_by' => 'rand()' 
);
$content = elgg_list_entities_from_relationship($options);

if ($content) {
	$title .= '<span> (' . $count . ')</span>';
	echo elgg_view_module('featured', $title, $content);
} else {
	$content = elgg_echo('river_addon:friends:none');
	echo elgg_view_module('featured', $title, $content);
}
