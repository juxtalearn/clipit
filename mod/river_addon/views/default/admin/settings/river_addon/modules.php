<?php
/**
 * River Addon settings
 */

$plugin = elgg_get_plugin_from_id('river_addon');

echo '<ul id="elgg-module-list" class="elgg-list elgg-list-entity ui-sortable">';

$items = array (
"<li id=\"0\" class=\"$plugin->show_icon\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_icon]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_icon
))
. elgg_view("input/dropdown", array(
	'name' => 'params[icon_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->icon_context
)) .   
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_icon') . "</div>
</li>",

"<li id=\"1\" class=\"$plugin->show_menu\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_menu]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_menu
))
. elgg_view("input/dropdown", array(
	'name' => 'params[menu_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->menu_context
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_menu') . "</div>
</li>",

"<li id=\"2\" class=\"$plugin->show_latest_members\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_latest_members]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_latest_members
))
. elgg_view("input/dropdown", array(
	'name' => 'params[members_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->members_context
))
. elgg_view("input/dropdown", array(
	'name' => 'params[num_members]',
	'options' => array(7, 14, 21, 28, 35, 42, 49, 56, 63, 70),
	'value' => $plugin->num_members
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_latest_members') . "</div>
</li>",

"<li id=\"3\" class=\"$plugin->show_friends\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"

. elgg_view("input/dropdown", array(
	'name' => 'params[show_friends]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_friends
))
. elgg_view("input/dropdown", array(
	'name' => 'params[friends_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->friends_context
)) 
. elgg_view("input/dropdown", array(
	'name' => 'params[num_friends]',
	'options' => array(7, 14, 21, 28, 35, 42, 49, 56, 63, 70),
	'value' => $plugin->num_friends
)) . 	   
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_friends') . "</div>
</li>",

"<li id=\"4\" class=\"$plugin->show_friends_online\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_friends_online]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_friends_online
))
. elgg_view("input/dropdown", array(
	'name' => 'params[online_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->online_context
)) . 
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_friends_online') . "</div>
</li>",

"<li id=\"5\" class=\"$plugin->show_ticker\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_ticker]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_ticker
))
. elgg_view("input/dropdown", array(
	'name' => 'params[ticker_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->ticker_context
))
. elgg_view("input/dropdown", array(
	'name' => 'params[tweetcount]',
	'options' => array(2, 3, 4, 5, 6, 7, 8),
	'value' => $plugin->tweetcount
)) .
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_ticker') . "</div>
</li>",

"<li id=\"6\" class=\"$plugin->show_groups\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_groups]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_groups
))
. elgg_view("input/dropdown", array(
	'name' => 'params[groups_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->groups_context
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_groups') . "</div>
</li>",

"<li id=\"7\" class=\"$plugin->show_latest_groups\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_latest_groups]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_latest_groups
))
. elgg_view("input/dropdown", array(
	'name' => 'params[latest_groups_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->latest_groups_context
))
. elgg_view("input/dropdown", array(
	'name' => 'params[num_groups]',
	'options' => array(1, 2, 3, 4, 5, 6),
	'value' => $plugin->num_groups
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_latest_groups') . "</div>
</li>",

"<li id=\"8\" class=\"$plugin->show_tagcloud\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_tagcloud]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_tagcloud
))
. elgg_view("input/dropdown", array(
	'name' => 'params[tagcloud_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->tagcloud_context
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_tagcloud') . "</div>
</li>",

"<li id=\"9\" class=\"$plugin->show_custom\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_custom]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_custom
))
. elgg_view("input/dropdown", array(
	'name' => 'params[custom_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->custom_context
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_custom') . "</div>
</li>",

"<li id=\"10\" class=\"$plugin->show_albums\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_albums]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_albums
))
. elgg_view("input/dropdown", array(
	'name' => 'params[albums_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->albums_context
))
. elgg_view("input/dropdown", array(
	'name' => 'params[num_albums]',
	'options' => array(1, 2, 3, 4, 5, 6),
	'value' => $plugin->num_albums
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:show_albums') . "</div>
</li>",

"<li id=\"11\" class=\"$plugin->show_comments\">
<div class='elgg-handle'>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span>
<span class='elgg-handle-bar'></span><span class='elgg-handle-bar'></span></div>"
 . elgg_view("input/dropdown", array(
	'name' => 'params[show_comments]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'sidebar_alt' => elgg_echo('river_addon:option:sidebar:left'),
		'sidebar' => elgg_echo('river_addon:option:sidebar:right')
	),
	'value' => $plugin->show_comments
))
. elgg_view("input/dropdown", array(
	'name' => 'params[comments_context]',
	'options_values' => array(
		'activity' => elgg_echo('river_addon:option:activity'),
		'site' => elgg_echo('river_addon:option:site')
	),
	'value' => $plugin->comments_context
)) 
. elgg_view("input/dropdown", array(
	'name' => 'params[subtypes]',
	'options_values' => array(
		'' => elgg_echo('river_addon:subtype:all'),
		'blog' => elgg_echo('river_addon:subtype:blog'),
		'bookmarks' => elgg_echo('river_addon:subtype:bookmarks'),
		'file' => elgg_echo('river_addon:subtype:file'),
		'page' => elgg_echo('river_addon:subtype:page'),
	),
	'value' => $plugin->subtypes
)) .  
"<div id='title' class='elgg-state-draggable'>" . elgg_echo('river_addon:label:comments') . "</div>
</li>",
);

$ordering = elgg_get_plugin_setting('neworder', 'river_addon');
$ordering = explode(',', $ordering);

foreach ($ordering as $key => $value) {
	echo $items[$value];
}
		
echo "</ul>";