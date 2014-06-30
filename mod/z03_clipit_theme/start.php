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

function clipit_final_init() {
    global $CONFIG;
    $CONFIG->user = new ClipitUser(elgg_get_logged_in_user_guid());
    $role = $CONFIG->user->role;
    /**
     * Register menu footer
    */
    setup_footer_menus();

    // Register & load libs
    elgg_register_library('clipit:functions', elgg_get_plugins_path() . 'z03_clipit_theme/lib/functions.php');
    elgg_load_library('clipit:functions');
    // Register & load events lib
    elgg_register_library('clipit:recommended:events', elgg_get_plugins_path() . 'z03_clipit_theme/lib/recommended/events.php');
    elgg_load_library('clipit:recommended:events');


    elgg_register_admin_menu_item('administer', 'z03_clipit_theme', 'clipit_plugins');
    elgg_register_action("clipit_theme/settings", elgg_get_plugins_path() . "z04_clipit_activity/actions/settings.php", 'admin');
    elgg_register_action('login', elgg_get_plugins_path() . "z03_clipit_theme/actions/login.php", 'public');
    elgg_register_action('logout', elgg_get_plugins_path() . "z03_clipit_theme/actions/logout.php");
    elgg_register_action('register', elgg_get_plugins_path() . "z03_clipit_theme/actions/register.php", 'public');

    elgg_register_action('user/requestnewpassword', elgg_get_plugins_path() . "z03_clipit_theme/actions/user/requestnewpassword.php", 'public');
    elgg_register_action('user/passwordreset', elgg_get_plugins_path() . "z03_clipit_theme/actions/user/passwordreset.php", 'public');
    elgg_register_action("user/check", elgg_get_plugins_path() . "z03_clipit_theme/actions/check.php", 'public');
    // Language selector
    elgg_register_action('language/set', elgg_get_plugins_path() . "z03_clipit_theme/actions/language/set.php");
    // Register ajax view for timeline events
    elgg_register_ajax_view('navigation/pagination_timeline');
    // Register public pages
    elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'actions_clipit_public_pages');
    function actions_clipit_public_pages($hook, $type, $return_value, $params) {
        $return_value[] = 'action/user/check';
        return $return_value;
    }

    elgg_register_page_handler('activity', 'user_landing_page');
    elgg_register_page_handler('forgotpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('resetpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('register', 'home_user_account_page_handler');
    elgg_register_page_handler('login', 'home_user_account_page_handler');


    if (elgg_get_context() === "admin") {
        elgg_unregister_css("twitter-bootstrap");
        elgg_unregister_css("ui-lightness");
        elgg_unregister_css("clipit");
        elgg_unregister_css("bubblegum");
        elgg_unregister_css("righteous");
        elgg_unregister_css("ubuntu");
        elgg_unregister_js("jquery-migrate");
        elgg_unregister_js("twitter-bootstrap");
    } else {
        elgg_register_css("twitter-bootstrap", $CONFIG->url . "mod/clipit/vendors/bootstrap/css/bootstrap.css");
        elgg_register_css("ui-lightness", $CONFIG->url . "mod/z03_clipit_theme/vendors/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css");
        elgg_register_css("clipit", $CONFIG->url . "mod/z03_clipit_theme/bootstrap/less/clipit/clipit_base.css");
        elgg_register_css("bubblegum", "http://fonts.googleapis.com/css?family=Bubblegum+Sans");
        elgg_register_css("righteous", "http://fonts.googleapis.com/css?family=Righteous");
        elgg_register_css("ubuntu", "http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic");
        elgg_register_css("fontawesome", "//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css");
        elgg_register_js("jquery", $CONFIG->url . "mod/z03_clipit_theme/vendors/jquery/jquery-1.9.1.min.js", "head", 0);
        elgg_register_js("jquery-migrate", $CONFIG->url . "mod/z03_clipit_theme/vendors/jquery/jquery-migrate-1.1.1.js", "head", 1);
        elgg_register_js("jquery-ui", $CONFIG->url . "mod/z03_clipit_theme/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js", "head", 2);
        // Waypoints
        elgg_register_js("jquery:waypoints", $CONFIG->url . "mod/z03_clipit_theme/vendors/waypoints/waypoints.min.js");
        elgg_register_js("jquery:waypoints:sticker", $CONFIG->url . "mod/z03_clipit_theme/vendors/waypoints/waypoints-sticky.min.js");
        elgg_register_js("jquery:waypoints:infinite", $CONFIG->url . "mod/z03_clipit_theme/vendors/waypoints/waypoints-infinite.min.js");
        // Wysihtml5
        elgg_register_js("jquery:wysihtml5", $CONFIG->url . "mod/z03_clipit_theme/vendors/wysihtml5/wysihtml5-0.3.0.min.js");
        elgg_register_js("jquery:bootstrap:wysihtml5", $CONFIG->url . "mod/z03_clipit_theme/vendors/wysihtml5/bootstrap-wysihtml5.js");
        elgg_register_css("wysihtml5:css", $CONFIG->url . "mod/z03_clipit_theme/vendors/wysihtml5/wysihtml5.css");
        // TinyMCE
        elgg_register_js("tinymce", $CONFIG->url . "mod/z03_clipit_theme/vendors/tinymce/tinymce.min.js");
        elgg_register_js("jquery:tinymce", $CONFIG->url . "mod/z03_clipit_theme/vendors/tinymce/jquery.tinymce.min.js");
        // Bootbox
        elgg_register_js("jquery:bootbox", $CONFIG->url . "mod/z03_clipit_theme/vendors/bootbox.js");
        // jQuery validate
        elgg_register_js("jquery:validate", $CONFIG->url . "mod/z03_clipit_theme/vendors/jquery.validate.js");
        // jquery tokeninput (automcomplete)
        elgg_register_js("jquery:tokeninput", $CONFIG->url . "mod/z03_clipit_theme/vendors/tokeninput.js");
        // NVD3 chart
        elgg_register_js("nvd3:d3_v2", $CONFIG->url . "mod/z03_clipit_theme/vendors/nvd3/d3.v2.js");
        elgg_register_js("nvd3", $CONFIG->url . "mod/z03_clipit_theme/vendors/nvd3/nv.d3.js");
        elgg_register_css("nvd3:css", $CONFIG->url . "mod/z03_clipit_theme/vendors/nvd3/nv.d3.css");


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
        elgg_unregister_css("righteous");
        elgg_load_css("fontawesome");
        elgg_load_css("ubuntu");
        elgg_load_css("clipit");
        elgg_load_css("bubblegum");
        elgg_unregister_css("twitter-bootstrap");
        elgg_unregister_css("elgg");
        elgg_unregister_css("elgg.walled_garden");
        ///////////////////////////////////////
        elgg_register_js("less_dev", $CONFIG->url . "mod/z03_clipit_theme/bootstrap/js/less_dev.js");
        elgg_load_js("less_dev");
        elgg_register_js("clipit_theme_less", $CONFIG->url . "mod/z03_clipit_theme/bootstrap/js/less.js");
        elgg_load_js("clipit_theme_less");
        elgg_register_js("clipit_theme_bootstrap", $CONFIG->url . "mod/z03_clipit_theme/bootstrap/dist/js/bootstrap.js");
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
            'href' => 'about',
            'text' => elgg_echo('about'),
            'priority' => 450,
            'section' => 'clipit',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'team',
            'href' => 'team',
            'text' => elgg_echo('team'),
            'priority' => 455,
            'section' => 'clipit',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'developers',
            'href' => 'developers',
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
            'href' => 'terms',
            'text' => elgg_echo('terms'),
            'priority' => 460,
            'section' => 'legal',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'privacy',
            'href' => 'privacy',
            'text' => elgg_echo('privacy'),
            'priority' => 465,
            'section' => 'legal',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'community_guidelines',
            'href' => 'community_guidelines',
            'text' => elgg_echo('community_guidelines'),
            'priority' => 470,
            'section' => 'legal',
        )
    );
    // Help section
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'support_center',
            'href' => 'support_center',
            'text' => elgg_echo('support_center'),
            'priority' => 470,
            'section' => 'help',
        )
    );
    elgg_register_menu_item(
        'footer_clipit',
        array(
            'name' => 'basics',
            'href' => 'basics',
            'text' => elgg_echo('basics'),
            'priority' => 475,
            'section' => 'help',
        )
    );
}

// STUDENT LANDING PAGE
function user_landing_page($page) {
    global $CONFIG;
    // Activity page cambiado a Dashboard

    // Ensure that only logged-in users can see this page
    gatekeeper();
    $role = $CONFIG->user->role;
    // Set context
    elgg_set_context($role.'_landing');
    elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

    $content = elgg_view('landing/widgets', array('role' => $role));
    $params = array(
        'content' => $content,
        'title'     => '',
        'filter'    => '',
        'class'     => 'landing row'
    );
    $body = elgg_view_layout('one_column', $params);

    echo elgg_view_page($role." Landing", $body);
}