<?php
/**
 * Save three column context
 */

$plugin = elgg_get_plugin_from_id('river_addon');

$contexts = get_input('selected');

$result = elgg_set_plugin_setting('three_column_context', $contexts, 'river_addon');

//system_message(elgg_echo('river_addon:settings:ok'));
forward(REFERER);

exit;
