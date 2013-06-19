<?php
/**
 * Changes order of Modules
 */

$plugin = elgg_get_plugin_from_id('river_addon');
$settinglist = river_addon_get_modules();

$ordering = get_input('moduleorder');

$result = elgg_set_plugin_setting('neworder', $ordering, 'river_addon');

$synclist = explode(",", $ordering);

$ordered = array();
foreach ($synclist as $key) {
    $ordered[] = $settinglist[$key];
}

foreach ($ordered as $key => $value) {
	$key = $key + 501;
	elgg_set_plugin_setting($value, $key, 'river_addon');
}

system_message(elgg_echo('river_addon:settings:order:ok'));
forward(REFERER);

exit;
