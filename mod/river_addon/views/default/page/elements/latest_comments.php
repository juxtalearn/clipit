<?php
/**
 * Latest Members module
 *
 */

$subtypes = elgg_get_plugin_setting('subtypes', 'river_addon');

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => $subtypes
));
