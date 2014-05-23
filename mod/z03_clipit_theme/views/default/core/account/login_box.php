<?php
/**
 * Elgg login box
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['module'] The module name. Default: aside
 */

$module = elgg_extract('module', $vars, 'aside');

$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
    $login_url = str_replace("http:", "https:", $login_url);
}

$vars["target"] = "modal-login";
$vars["title"] = elgg_echo('login');
$vars["body"] = elgg_view_form('login_modal', array('action' => "{$login_url}action/login", 'role' => 'form', 'class' => ''));


//echo elgg_view_module($module, $title, $body);
echo elgg_view("page/components/modal", $vars);