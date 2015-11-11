<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/02/2015
 * Last update:     23/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
if (elgg_is_logged_in()) {
    forward();
}

$title = elgg_echo("login");
$content = '<div class="col-md-6 col-md-offset-3">';
$content .= elgg_view_title($title);

$content .= elgg_view_form('login', array(
    'body' => elgg_view('forms/demo/login'),
    'class' => 'clipit-home-form',
));

$content .= '</div>';
$body  = elgg_view_layout("one_column", array('content' => $content, 'class' => 'clipit-home'));

echo elgg_view_page($title, $body);