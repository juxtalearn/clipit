<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/09/14
 * Last update:     10/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
    $login_url = str_replace("http:", "https:", $login_url);
}

$params = array(
    'target' => 'modal-login',
    'title' => elgg_echo('login'),
    'body' => elgg_view_form('login_modal', array(
        'action' => "{$login_url}action/login",
        'role' => 'form',
        'class' => '',
        'data-validate' => 'true',
    ), array('returntoreferer' => true)),
);
echo elgg_view("page/components/modal", $params);