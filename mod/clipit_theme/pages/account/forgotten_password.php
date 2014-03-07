<?php
/**
 * Assembles and outputs the forgotten password page.
 *
 * @package Elgg.Core
 * @subpackage Registration
 */

if (elgg_is_logged_in()) {
    forward();
}

$title = elgg_echo("user:password:lost");
$content = '<div class="col-md-6 col-md-offset-3">';
$content .= elgg_view_title($title);

$content .= elgg_view_form('user/requestnewpassword', array(
    'class' => 'clipit-home-form',
));

$content .= '</div>';
$body  = elgg_view_layout("one_column", array('content' => $content, 'class' => 'clipit-home'));

echo elgg_view_page($title, $body);
