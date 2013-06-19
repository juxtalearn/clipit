<?php 
/**
 * Announcement module
 *
 */

$plugin = elgg_get_plugin_from_id('river_addon');
$site_url = elgg_get_site_url();

$icon = $site_url . "mod/river_addon/graphics/announcement.png";

$style = $plugin->module_style;
$class = array('class' => 'ez-module');

$title = elgg_echo("river_addon:announcement:title");

$html = "<img src=\"$icon\" align=\"left\" width=\"60\" height=\"60\" alt=\"Announcement\" />";
$html .= $plugin->html_content; 

echo elgg_view_module($style, $title, $html, $class);
