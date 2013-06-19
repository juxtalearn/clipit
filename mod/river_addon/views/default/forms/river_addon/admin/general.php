<?php
/**
 * River Addon settings
 * 
 */

$plugin = elgg_get_plugin_from_id('river_addon');

if (!isset($plugin->show_thewire)) { $plugin->show_thewire = 'no'; }
if (!isset($plugin->show_icon)) { $plugin->show_icon = 'sidebar'; }

echo "<div class=\"label\">" . elgg_echo('river_addon:header:general') . "</div>";

echo '<div class="item">';
echo elgg_echo('river_addon:label:taborder');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[tab_order]',
	'options_values' => array(
		'default' => elgg_echo('river_addon:option:default'),
		'friend_order' => elgg_echo('river_addon:option:friend'),
		'mine_order' => elgg_echo('river_addon:option:mine')
	),
	'value' => $plugin->tab_order,
));
echo '</div>';

echo "<div>" . elgg_echo('river_addon:info:columns') . "</div>";

$menu = elgg_get_config('menus');
$menu = $menu['site'];

$selected = $plugin->three_column_context;
$selected = explode(",", $selected);

echo '<div>';
echo elgg_echo('river_addon:label:columns');
echo '<select id="select-context" class="elgg-input-select" multiple="multiple">';
foreach ($menu as $item) {
	if (in_array($item->getName(), $selected)) {
		echo "<option selected=\"selected\" value=\"{$item->getName()}\">" . $item->getText() . "</option>";
	} else {
		echo "<option value=\"{$item->getName()}\">" . $item->getText() . "</option>";
	}		
}
echo '</select>';
echo '</div>';

echo "<div class=\"no\" id=\"target\"></div>";

echo '<div class="item">';
echo elgg_echo('river_addon:label:thewire');
echo ' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[show_thewire]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $plugin->show_thewire
));
echo '</div>';

echo elgg_view('input/submit', array('value' => elgg_echo("save")));
