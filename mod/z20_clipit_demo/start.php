<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/05/14
 * Last update:     20/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
if(get_config('clipit_site_type') == ClipitSite::TYPE_DEMO) {
    elgg_register_event_handler('init', 'system', 'clipit_demo_init');
}

function clipit_demo_init() {
    $plugin_dir = elgg_get_plugins_path() . "z20_clipit_demo";
    elgg_register_page_handler('login', 'demo_account_page_handler');
    elgg_register_page_handler('login_admin', 'demo_login_admin_page_handler');
    elgg_register_page_handler('register', 'demo_account_page_handler');
    elgg_register_page_handler('forgotpassword', 'demo_account_page_handler');
    elgg_register_plugin_hook_handler('index', 'system', 'demo_walled_garden', 1);
    // Register "/settings" page handler
    elgg_register_page_handler('settings', 'usersettings_clipit_demo_handler');
    elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'login_public_page');
    function login_public_page($hook, $type, $return_value, $params){
        $return_value[] = 'login_admin';
        return $return_value;
    }
}
function demo_walled_garden(){
    if(!elgg_is_logged_in()) {
        forward('login');
    }
}
function demo_login_admin_page_handler(){
    $title = elgg_echo("login");
    $content = '<div class="col-md-9 col-md-offset-3">';
    $content .= elgg_view_title($title);

    $content .= elgg_view_form('login', array(
        'body' => elgg_view('forms/demo/login_admin'),
        'class' => 'clipit-home-form',
    ));

    $content .= '</div>';
    $body  = elgg_view_layout("one_column", array('content' => $content, 'class' => 'clipit-home'));

    echo elgg_view_page($title, $body);
}
function usersettings_clipit_demo_handler(){
    forward('');
}
function demo_account_page_handler($page_elements, $handler) {
    $base_dir = elgg_get_plugins_path() . 'z20_clipit_demo/pages/account';
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
