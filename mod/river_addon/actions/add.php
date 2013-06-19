<?php
/**
 * Action for adding a wire post
 * 
 */

// don't filter since we strip and filter escapes some characters
$body = get_input('body', '', false);

$access_id = ACCESS_PUBLIC;
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}

$guid = thewire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method);
 
if ($guid) {	
	$options = array(
		'pagination' => false,
		'limit' => 1
	);
	$output = elgg_list_river($options);
	echo $output;
}

system_message(elgg_echo("thewire:posted"));
forward(REFERER);
