<?php
/**
 * Assembles and outputs a login page.
 *
 * This page serves as a fallback for non-JS users who click on the login
 * drop down link.
 *
 * If the user is logged in, this page will forward to the front page.
 *
 * @package Elgg.Core
 * @subpackage Accounts
 */

if (elgg_is_logged_in()) {
    forward();
}

$title = elgg_echo("login");
$content = '<div class="col-md-6 col-md-offset-3">';
$content .= elgg_view_title($title);

$content .= elgg_view_form('login', array(
    'class' => 'clipit-home-form',
));

$content .= '</div>';
$body  = elgg_view_layout("one_column", array('content' => $content, 'class' => 'clipit-home'));

echo elgg_view_page($title, $body);
