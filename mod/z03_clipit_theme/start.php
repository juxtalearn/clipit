<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_register_event_handler('init', 'system', 'clipit_final_init');
elgg_register_event_handler('plugins_boot', 'system', 'language_selector_boot');

function language_selector_boot(){
    global $CONFIG;
    $client_language = $_COOKIE['client_language'];
    if(!elgg_is_logged_in()){
        if(!empty($client_language)){
            $CONFIG->language = $client_language;
        }
        reload_all_translations();
    } else {
        if(!empty($client_language)){
            setcookie('client_language', '', time()-60*60*24*30, '/'); // reset cookie
        }
    }
}
function clipit_final_init() {
    global $CONFIG;
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    /**
     * Register menu footer
    */
    setup_footer_menus();
    $plugin_dir = elgg_get_plugins_path() . "z03_clipit_theme";
    // Register & load libs
    elgg_register_library('clipit:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:functions');
    // Register & load events lib
    elgg_register_library('clipit:recommended:events', "{$plugin_dir}/lib/recommended/events.php");
    elgg_load_library('clipit:recommended:events');

    // Activity admin module ajax
    elgg_register_ajax_view('dashboard/modules/activity_admin/task_list');

    elgg_register_action("clipit_theme/settings", "{$plugin_dir}/actions/settings.php", 'admin');
    elgg_register_action('login', "{$plugin_dir}/actions/login.php", 'public');
    elgg_register_action('logout', "{$plugin_dir}/actions/logout.php");
    elgg_register_action('register', "{$plugin_dir}/actions/register.php", 'public');

    elgg_register_action('user/requestnewpassword', "{$plugin_dir}/actions/user/requestnewpassword.php", 'public');
    elgg_register_action('user/passwordreset', "{$plugin_dir}/actions/user/passwordreset.php", 'public');
    elgg_register_action("user/check", "{$plugin_dir}/actions/check.php", 'public');
    // Language selector
    elgg_register_action('language/set', "{$plugin_dir}/actions/language/set.php", 'public');
    // Register ajax view for timeline events
    elgg_register_ajax_view('navigation/pagination_timeline');
    // Register public pages
    elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'actions_clipit_public_pages');
    function actions_clipit_public_pages($hook, $type, $return_value, $params) {
        $return_value[] = 'action/user/check';
        $return_value[] = 'action/language/set';
        // Clipit sections
        $return_value[] = 'clipit/team';
        $return_value[] = 'clipit/about';
        $return_value[] = 'clipit/developers';
        // Help sections
        $return_value[] = 'help/support_center';
        $return_value[] = 'help/basics';
        // Legal sections
        $return_value[] = 'legal/terms';
        $return_value[] = 'legal/privacy';
        $return_value[] = 'legal/community_guidelines';
        return $return_value;
    }

    elgg_register_page_handler('activity', 'user_landing_page');
    // Footer links
    elgg_register_page_handler('clipit', 'clipit_footer_page');
    elgg_register_page_handler('help', 'help_footer_page');
    elgg_register_page_handler('legal', 'legal_footer_page');
    elgg_register_page_handler('forgotpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('resetpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('register', 'home_user_account_page_handler');
    elgg_register_page_handler('login', 'home_user_account_page_handler');

    $plugin_url = elgg_get_site_url() . "mod/z03_clipit_theme";
    if (elgg_get_context() === "admin") {
        if($user->role == ClipitUser::ROLE_TEACHER){
            elgg_unregister_page_handler('admin');
            return false;
        }
        elgg_unregister_css("twitter-bootstrap");
        elgg_unregister_css("ui-lightness");
        elgg_unregister_css("clipit");
        elgg_unregister_js("jquery-migrate");
        elgg_unregister_js("twitter-bootstrap");
    } else {
        elgg_register_css("ui-lightness", "{$plugin_url}/vendors/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css");
        elgg_register_css("clipit", "{$plugin_url}/bootstrap/less/clipit/clipit_base.css");
        elgg_register_css("fontawesome", "{$plugin_url}/vendors/fontawesome/fontawesome.min.css");
        elgg_register_js("jquery", "{$plugin_url}/vendors/jquery/jquery-1.9.1.min.js", "head", 0);
        elgg_register_js("jquery-migrate", "{$plugin_url}/vendors/jquery/jquery-migrate-1.1.1.js", "head", 1);
        elgg_register_js("jquery-ui", "{$plugin_url}/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js", "head", 2);
        // Waypoints
        elgg_register_js("jquery:waypoints", "{$plugin_url}/vendors/waypoints/waypoints.min.js");
        elgg_register_js("jquery:waypoints:sticker", "{$plugin_url}/vendors/waypoints/waypoints-sticky.min.js");
        elgg_register_js("jquery:waypoints:infinite", "{$plugin_url}/vendors/waypoints/waypoints-infinite.min.js");
        // TinyMCE
        elgg_register_js("jquery:tinymce", "{$plugin_url}/vendors/tinymce/jquery.tinymce.min.js");
        elgg_register_js("tinymce", "{$plugin_url}/vendors/tinymce/tinymce.min.js");

        // Bootbox
        elgg_register_js("jquery:bootbox", "{$plugin_url}/vendors/bootbox.js");
        // jQuery validate
        elgg_register_js("jquery:validate", "{$plugin_url}/vendors/jquery.validate.js");
        // jquery tokeninput (automcomplete)
        elgg_register_js("jquery:tokeninput", "{$plugin_url}/vendors/tokeninput.js");
        // NVD3 chart
        elgg_register_js("nvd3:d3_v2", "{$plugin_url}/vendors/nvd3/d3.v2.js");
        elgg_register_js("nvd3", "{$plugin_url}/vendors/nvd3/nv.d3.js");
        elgg_register_css("nvd3:css", "{$plugin_url}/vendors/nvd3/nv.d3.css");


        $clipit_js = elgg_get_simplecache_url('js', 'clipit');
        elgg_register_simplecache_view('js/clipit');
        elgg_register_js('clipit', $clipit_js);

        elgg_load_js("jquery");
        elgg_load_js("jquery-ui");
        elgg_load_js("jquery-migrate");
        elgg_load_js("jquery:waypoints");
        elgg_load_js("jquery:waypoints:sticker");
        elgg_load_js("jquery:waypoints:infinite");
        elgg_load_js("jquery:wysihtml5");
        elgg_load_js("jquery:tinymce");
        elgg_load_js("tinymce");
        elgg_load_js("jquery:bootbox");
        elgg_load_js("jquery:bootstrap:wysihtml5");
        elgg_load_css("wysihtml5:css");
        elgg_load_js("jquery:validate");
        elgg_load_js("jquery:tokeninput");
        elgg_load_js("clipit");
        //elgg_load_css("ui-lightness");
        elgg_load_css("twitter-bootstrap");
        elgg_unregister_js("twitter-bootstrap");
        elgg_load_css("fontawesome");
        elgg_load_css("clipit");
        elgg_unregister_css("elgg");
        elgg_unregister_css("elgg.walled_garden");
        elgg_register_js("clipit_theme_bootstrap", "{$plugin_url}/bootstrap/dist/js/bootstrap.js");
        elgg_load_js("clipit_theme_bootstrap");
    }
}

function home_user_account_page_handler($page_elements, $handler) {

    $base_dir = elgg_get_plugins_path() . 'z03_clipit_theme/pages/account';
    switch ($handler) {

        case 'forgotpassword':
            require_once("$base_dir/forgotten_password.php");
        break;
        case 'resetpassword':
            require_once("$base_dir/reset_password.php");
            break;
        case 'register':
            require_once("$base_dir/register.php");
        break;
        case 'login':
            require_once("$base_dir/login.php");
        break;
        default:
            return false;
    }
    return true;
}

function setup_footer_menus(){
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'about',
            'href' => 'clipit/about',
            'text' => elgg_echo('about'),
            'priority' => 450,
            'section' => 'clipit',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'team',
            'href' => 'clipit/team',
            'text' => elgg_echo('team'),
            'priority' => 455,
            'section' => 'clipit',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'developers',
            'href' => 'http://juxtalearn.github.io/clipit/',
            'text' => elgg_echo('developers'),
            'priority' => 460,
            'section' => 'clipit',
        )
    );
    // Legal section
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'terms',
            'href' => 'legal/terms',
            'text' => elgg_echo('terms'),
            'priority' => 460,
            'section' => 'legal',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'privacy',
            'href' => 'legal/privacy',
            'text' => elgg_echo('privacy'),
            'priority' => 465,
            'section' => 'legal',
        )
    );
}
function clipit_footer_page($page) {
    $file_dir = elgg_get_plugins_path() . 'z03_clipit_theme/pages/clipit';
    switch($page[0]){
        case "about":
            return false;
            break;
        case "team":
            include "$file_dir/team.php";
            break;
        case "developers":
            return false;
            break;
        default:
            return false;
    }
    return true;
}
function help_footer_page($page) {
    return false;
}

function legal_footer_page($page) {
    return false;
}
// Dashboard page
function user_landing_page($page) {
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    switch($user->role){
        case ClipitUser::ROLE_TEACHER:
            $content = elgg_view('dashboard/teacher', array('entity' => $user));
            break;
        case ClipitUser::ROLE_STUDENT:
            $content = elgg_view('dashboard/student', array('entity' => $user));
            break;
        case ClipitUser::ROLE_ADMIN:
            $content = elgg_view('dashboard/admin', array('entity' => $user));
            break;
    }
    $params = array(
        'content' => $content,
        'filter'    => '',
        'class'     => 'landing row'
    );
    $body = elgg_view_layout('one_column', $params);
    echo elgg_view_page('', $body);
}