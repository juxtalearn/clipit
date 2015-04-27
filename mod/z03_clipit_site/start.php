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

function clipit_final_init(){
    global $CONFIG;
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    /**
     * Register menu footer
     */
    setup_footer_menus();
    $plugin_dir = elgg_get_plugins_path() . "z03_clipit_site";
    // Register & load events lib
    elgg_register_library('clipit:recommended:events', "{$plugin_dir}/lib/recommended/events.php");
    elgg_load_library('clipit:recommended:events');
    elgg_register_library('clipit:site:functions', "{$plugin_dir}/lib/functions.php");
    elgg_load_library('clipit:site:functions');

    // Activity admin module ajax
    elgg_register_ajax_view('dashboard/modules/activity_admin/task_list');

    elgg_register_ajax_view('dashboard/modules/group_status_data');

    elgg_register_action("clipit_theme/settings", "{$plugin_dir}/actions/settings.php", 'admin');
    elgg_register_action('login', "{$plugin_dir}/actions/login.php", 'public');
    elgg_register_action('logout', "{$plugin_dir}/actions/logout.php");
    elgg_register_action('register', "{$plugin_dir}/actions/register.php", 'public');

    elgg_register_action("filter_search", "{$plugin_dir}/actions/filter_search.php");

    elgg_register_action('user/requestnewpassword', "{$plugin_dir}/actions/user/requestnewpassword.php", 'public');
    elgg_register_action('user/passwordreset', "{$plugin_dir}/actions/user/passwordreset.php", 'public');
    elgg_register_action("user/check", "{$plugin_dir}/actions/check.php", 'public');
    // Language selector
    elgg_register_action('language/set', "{$plugin_dir}/actions/language/set.php", 'public');
    // Register ajax view for timeline events
    elgg_register_ajax_view('navigation/pagination_timeline');
    // Register ajax view for activity group status
    elgg_register_ajax_view('dashboard/modules/activity_groups_status');


    if ($user->role == ClipitUser::ROLE_ADMIN) {
        elgg_extend_view("navigation/menu/top", "navigation/menu/admin", 100);
    }

    elgg_register_page_handler('activity', 'user_landing_page');
    // Footer links
    elgg_register_page_handler('forgotpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('resetpassword', 'home_user_account_page_handler');
    elgg_register_page_handler('register', 'home_user_account_page_handler');

    $plugin_url = elgg_get_site_url() . "mod/z03_clipit_site";

    elgg_register_js("jquery", "{$plugin_url}/vendors/jquery/jquery-1.9.1.min.js", "head", 0);
    elgg_register_js("jquery-migrate", "{$plugin_url}/vendors/jquery/jquery-migrate-1.1.1.js", "head", 1);
    elgg_load_js("jquery");
    elgg_load_js("jquery-migrate");

    if (elgg_get_context() == "admin") {
        if ($user->role == ClipitUser::ROLE_TEACHER) {
            elgg_unregister_page_handler('admin');
            return false;
        }
        elgg_unregister_css("twitter-bootstrap");
        elgg_unregister_css("ui-lightness");
        elgg_unregister_css("clipit");
        elgg_unregister_js("twitter-bootstrap");
    } else {
        if (elgg_get_context() == "activity" && $user->role == ClipitUser::ROLE_ADMIN) {
            forward('admin');
        }
        elgg_unregister_js('jquery.form');
        elgg_register_css("ui-lightness", "{$plugin_url}/vendors/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css");
        elgg_register_js("jquery-ui", "{$plugin_url}/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js", "head", 2);
        // Waypoints
        elgg_register_js("jquery:waypoints", "{$plugin_url}/vendors/waypoints/waypoints.min.js", "footer");
        elgg_register_js("jquery:waypoints:sticker", "{$plugin_url}/vendors/waypoints/waypoints-sticky.min.js", "footer");
        elgg_register_js("jquery:waypoints:infinite", "{$plugin_url}/vendors/waypoints/waypoints-infinite.min.js", "footer");
        // TinyMCE
        elgg_register_js("jquery:tinymce", "{$plugin_url}/vendors/tinymce/jquery.tinymce.min.js", "footer");
        elgg_register_js("tinymce", "{$plugin_url}/vendors/tinymce/tinymce.min.js", "footer");

        // Bootbox
        elgg_register_js("jquery:bootbox", "{$plugin_url}/vendors/bootbox.js", "footer");
        // jQuery validate
        elgg_register_js("jquery:validate", "{$plugin_url}/vendors/jquery.validate.js");
        // jquery tokeninput (automcomplete)
        elgg_register_js("jquery:tokeninput", "{$plugin_url}/vendors/tokeninput.js", "footer");
        // NVD3 chart
        elgg_register_js("nvd3:d3_v2", "{$plugin_url}/vendors/nvd3/d3.v2.js", "footer");
        elgg_register_js("nvd3", "{$plugin_url}/vendors/nvd3/nv.d3.js", "footer");
        elgg_register_css("nvd3:css", "{$plugin_url}/vendors/nvd3/nv.d3.css");
        // ClipIt
        $clipit_css = elgg_get_simplecache_url('css', 'clipit');
        elgg_register_simplecache_view('css/clipit');
        elgg_register_css("clipit", $clipit_css);
        // FontAwesome
        elgg_register_css("fontawesome", "{$plugin_url}/vendors/fontawesome/fontawesome.min.css");

        $clipit_js = elgg_get_simplecache_url('js', 'clipit');
        elgg_register_simplecache_view('js/clipit');
        elgg_register_js('clipit', $clipit_js);

        elgg_load_js("jquery-ui");
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
        elgg_register_js("elgg.walled_gaarden", "{$plugin_url}/bootstrap/dist/js/adadadaotstrap.js");
        elgg_load_js("clipit_theme_bootstrap");
    }
}

function home_user_account_page_handler($page_elements, $handler)
{

    $base_dir = elgg_get_plugins_path() . 'z03_clipit_site/pages/account';
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
        default:
            return false;
    }
    return true;
}


// Dashboard page
function user_landing_page($page)
{
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $all_activities = ClipitUser::get_activities($user->id);
    $all_activities = ClipitActivity::get_by_id($all_activities);
    $activities = array();
    foreach($all_activities as $my_activity){
        if($my_activity->status != ClipitActivity::STATUS_CLOSED){
            $activities[$my_activity->id] = $my_activity;
        }
    }
    switch ($user->role) {
        case ClipitUser::ROLE_TEACHER:
            $content = elgg_view('dashboard/teacher', array('entity' => $user, 'activities' => $activities));
            break;
        case ClipitUser::ROLE_STUDENT:
            $content = elgg_view('dashboard/student', array('activities' => $activities));
            break;
        case ClipitUser::ROLE_ADMIN:
            $content = elgg_view('dashboard/admin', array('entity' => $user));
            break;
    }
    $params = array(
        'content' => $content,
        'filter' => '',
        'class' => 'landing row'
    );
    $body = elgg_view_layout('one_column', $params);
    echo elgg_view_page('', $body);
}
