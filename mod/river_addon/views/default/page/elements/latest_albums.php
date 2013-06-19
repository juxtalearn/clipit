<?php
/**
 * Albums module
 *
 */

elgg_push_context('widgets');

$title = elgg_view('output/url', array(
	'href' => "/photos/all",
	'text' => elgg_echo('tidypics:widget:albums'),
	'is_trusted' => true,
));

$num = (int) elgg_get_plugin_setting('num_albums', 'river_addon');

$options = array(
	"type" => "object",
	"subtype" => "album",
	"limit" => $num,
	"full_view" => false,
	"pagination" => false,
	"view_type_toggle" => false,
	'full_view' => false
);
$albums = elgg_list_entities_from_metadata($options);

elgg_pop_context();

if ($albums) {
	echo elgg_view_module('aside', $title, $albums);
} else {
	$albums = elgg_echo('river_addon:albums:none');
	echo elgg_view_module('aside', $title, $albums);
}
