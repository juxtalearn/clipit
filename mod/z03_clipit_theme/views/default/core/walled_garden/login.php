<?php
/**
 * Walled garden login
 */

$title = elgg_get_site_entity()->name;
$welcome = elgg_echo('welcome');
//$welcome .= ': <br/>' . $title;

$menu = elgg_view_menu('walled_garden', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-general elgg-menu-hz',
));
$login_box = elgg_view('core/account/login_box', array('module' => 'walledgarden-login'));
$plugin = elgg_get_plugin_from_id('z03_clipit_theme');
$vars = $plugin->getAllSettings();
$vars['img_path'] = $CONFIG->wwwroot."mod/z03_clipit_theme/graphics/";
$vars['bg_img'] = $vars['img_path']."icons/".$vars['bg_img'];
$vars['logo_img'] = $vars['img_path']."icons/".$vars['logo_img'];
//echo elgg_view("header", $vars);
echo $login_box;
//echo $login_box;
echo elgg_view("jumbotron", $vars);
echo elgg_view("body", $vars);


