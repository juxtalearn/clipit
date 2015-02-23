<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if(get_config('clipit_site_type') == 'demo') {
    elgg_register_event_handler('init', 'system', 'clipit_demo_init');
}

function clipit_demo_init() {
    $plugin_dir = elgg_get_plugins_path() . "z99_clipit_demo";
    elgg_register_page_handler('login', 'demo_account_page_handler');
    elgg_register_page_handler('register', 'demo_account_page_handler');
    elgg_register_page_handler('forgotpassword', 'demo_account_page_handler');
    elgg_register_plugin_hook_handler('index', 'system', 'demo_walled_garden', 1);
    // Register "/settings" page handler
    elgg_register_page_handler('settings', 'usersettings_clipit_demo_handler');
}
function demo_walled_garden(){
    if(!elgg_is_logged_in()) {
        forward('login');
    }
}
function usersettings_clipit_demo_handler(){
    forward('');
}
function demo_account_page_handler($page_elements, $handler) {
    $base_dir = elgg_get_plugins_path() . 'z99_clipit_demo/pages/account';
    switch ($handler) {
        case 'forgotpassword':
            return false;
            break;
        case 'register':
            return false;
            break;
        case 'login':
            require_once("$base_dir/login.php");
            break;
        default:
            return false;
    }
    return true;
}
