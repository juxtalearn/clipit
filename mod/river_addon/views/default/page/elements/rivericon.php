<?php
/**
 * Icon module
 *
 */

$user = elgg_get_logged_in_user_entity();

$icon = elgg_view_entity_icon($user, 'large', array('use_hover' => false));

echo <<<HTML

<div id="profile-owner-block">
	$icon
</div>

HTML;
