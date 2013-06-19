<?php
/**
 * River Addon settings
 */

$plugin = elgg_get_plugin_from_id('river_addon');

if (!isset($plugin->show_announcement)) {
	$plugin->show_announcement = 'no';
}
if (!isset($plugin->module_style)) {
	$plugin->module_style = 'announcement';
}

echo "<div class=\"label\">" . elgg_echo('river_addon:header:announcement') . "</div>";
echo "<div>" . elgg_echo('river_addon:info:announcement') . "</div>";

echo '<div class="item">';
echo elgg_echo('river_addon:label:announcement');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[show_announcement]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $plugin->show_announcement,
));
echo elgg_view("input/dropdown", array(
	'name' => 'params[announcement_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->announcement_context
));
echo '</div>';

echo '<div class="item">';
echo elgg_echo('river_addon:label:module');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[module_style]',
	'options_values' => array(
		'announcement' => elgg_echo('river_addon:option:announcement'),
		'aside' => elgg_echo('river_addon:option:aside'),
		'featured' => elgg_echo('river_addon:option:featured'),
		'info' => elgg_echo('river_addon:option:info')
	),
	'value' => $plugin->module_style,
));
echo '</div>';

echo '<div>' . elgg_echo('river_addon:label:html');
echo elgg_view("input/longtext", array(
	'name' => 'params[html_content]',
	'value' => $plugin->html_content
));
echo '</div>';
 
echo elgg_view('input/submit', array('value' => elgg_echo("save")));
