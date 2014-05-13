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
    elgg_register_library('clipit:functions', elgg_get_plugins_path() . 'clipit_theme/lib/functions.php');
    elgg_load_library('clipit:functions');
    // Register events log
    set_default_clipit_events();

    // Landing modules by role
    /*add_landing_tool_option("student_landing",
        array(
            "col-md-8" => array(
            'name' => 'pending',
            'text' => 'Pending task',
            'column' => 2,
            'order' => 1,
            'view' => 'landing/student/pending_module')
        ));
    add_landing_tool_option("student_landing",
        array(
            'name' => 'events',
            'text' => 'Events',
            'column' => 1,
            'order' => 1,
            'view' => 'landing/student/events_module'
        ));
    print_r($CONFIG->landing_tool_options);*/


    elgg_register_admin_menu_item('administer', 'clipit_theme', 'clipit_plugins');
    elgg_register_action("clipit_theme/settings", elgg_get_plugins_path() . "clipit_theme/actions/settings.php", 'admin');
    elgg_register_action('login', elgg_get_plugins_path() . "clipit_theme/actions/login.php", 'public');
    elgg_register_action('logout', elgg_get_plugins_path() . "clipit_theme/actions/logout.php");
    elgg_register_action('register', elgg_get_plugins_path() . "clipit_theme/actions/register.php", 'public');

    elgg_register_action('user/requestnewpassword', elgg_get_plugins_path() . "clipit_theme/actions/user/requestnewpassword.php", 'public');
    elgg_register_action('user/passwordreset', elgg_get_plugins_path() . "clipit_theme/actions/user/passwordreset.php", 'public');
    elgg_register_action("user/check", elgg_get_plugins_path() . "clipit_theme/actions/check.php", 'public');
    // Language selector
    elgg_register_action('language/set', elgg_get_plugins_path() . "clipit_theme/actions/language/set.php");
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
        elgg_register_css("ui-lightness", $CONFIG->url . "mod/clipit_theme/vendors/jquery-ui-1.10.2.custom/css/ui-lightness/jquery-ui-1.10.2.custom.min.css");
        elgg_register_css("clipit", $CONFIG->url . "mod/clipit_theme/bootstrap/less/clipit/clipit_base.css");
        elgg_register_css("bubblegum", "http://fonts.googleapis.com/css?family=Bubblegum+Sans");
        elgg_register_css("righteous", "http://fonts.googleapis.com/css?family=Righteous");
        elgg_register_css("ubuntu", "http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic");
        elgg_register_css("fontawesome", "//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
        elgg_register_js("jquery", $CONFIG->url . "mod/clipit_theme/vendors/jquery/jquery-1.9.1.min.js", "head", 0);
        elgg_register_js("jquery-migrate", $CONFIG->url . "mod/clipit_theme/vendors/jquery/jquery-migrate-1.1.1.js", "head", 1);
        elgg_register_js("jquery-ui", $CONFIG->url . "mod/clipit_theme/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js", "head", 2);
        // Waypoints
        elgg_register_js("jquery:waypoints", $CONFIG->url . "mod/clipit_theme/vendors/waypoints/waypoints.min.js");
        elgg_register_js("jquery:waypoints:sticker", $CONFIG->url . "mod/clipit_theme/vendors/waypoints/waypoints-sticky.min.js");
        elgg_register_js("jquery:waypoints:infinite", $CONFIG->url . "mod/clipit_theme/vendors/waypoints/waypoints-infinite.min.js");
        // Wysihtml5
        elgg_register_js("jquery:wysihtml5", $CONFIG->url . "mod/clipit_theme/vendors/wysihtml5/wysihtml5-0.3.0.min.js");
        elgg_register_js("jquery:bootstrap:wysihtml5", $CONFIG->url . "mod/clipit_theme/vendors/wysihtml5/bootstrap-wysihtml5.js");
        elgg_register_css("wysihtml5:css", $CONFIG->url . "mod/clipit_theme/vendors/wysihtml5/wysihtml5.css");
        // TinyMCE
        elgg_register_js("tinymce", $CONFIG->url . "mod/clipit_theme/vendors/tinymce/tinymce.min.js");
        elgg_register_js("jquery:tinymce", $CONFIG->url . "mod/clipit_theme/vendors/tinymce/jquery.tinymce.min.js");
        // Bootbox
        elgg_register_js("jquery:bootbox", $CONFIG->url . "mod/clipit_theme/vendors/bootbox.js");
        // jQuery validate
        elgg_register_js("jquery:validate", $CONFIG->url . "mod/clipit_theme/vendors/jquery.validate.js");
        // jquery tokeninput (automcomplete)
        elgg_register_js("jquery:tokeninput", $CONFIG->url . "mod/clipit_theme/vendors/tokeninput.js");


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
        elgg_load_css("ui-lightness");
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
        elgg_register_js("less_dev", $CONFIG->url . "mod/clipit_theme/bootstrap/js/less_dev.js");
        elgg_load_js("less_dev");
        elgg_register_js("clipit_theme_less", $CONFIG->url . "mod/clipit_theme/bootstrap/js/less.js");
        elgg_load_js("clipit_theme_less");
        elgg_register_js("clipit_theme_bootstrap", $CONFIG->url . "mod/clipit_theme/bootstrap/dist/js/bootstrap.js");
        elgg_load_js("clipit_theme_bootstrap");




    }
}

function home_user_account_page_handler($page_elements, $handler) {

    $base_dir = elgg_get_plugins_path() . 'clipit_theme/pages/account';
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



/**
 * Register clipit events log
 */
function set_default_clipit_events(){
//    register_clipit_event('group-user', function($relationship, $activity){
//        $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
//        $params = array(
//            'icon' => 'user',
//            'message' => 'Nuevo miembro en',
//            'item' => array(
//                'name' => $object->name,
//                'url' => "clipit_activity/{$activity->id}/group/activity_log",
//            )
//        );
//        return $params;
//    });

    register_clipit_event('group-user', function($event, $relationship){
        $params = array(
            'icon'    => 'user',
            'message' => 'Se ha unido al grupo',
        );
        return $params;
    });
    register_clipit_event('group-file', function($event, $relationship){
        $item = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
        $activity_id = ClipitGroup::get_activity($relationship->guid_one);
        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
        $params = array(
            'icon' => 'upload',
            'message' => 'Uploaded the file',
            'item' => array(
                'name' => $item->name,
                'description' => $item->description,
                //'icon' => "$item->icon",
                'icon' => "file-o",
                'url' => "clipit_activity/{$activity->id}/group/files/view/{$item->id}",
            )
        );
        return $params;
    });
    register_clipit_event('message-destination', function($event, $relationship){

        $author = array_pop(ClipitUser::get_by_id(array($event->performed_by_guid)));
        $author_elgg = new ElggUser($event->performed_by_guid);
        $lookup = ClipitSite::lookup($relationship->guid_two);
        switch($lookup['subtype']){
            case 'clipit_group':
                $item = array_pop(ClipitPost::get_by_id(array($relationship->guid_one)));
                $activity_id = ClipitGroup::get_activity($relationship->guid_two);
                $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
                // Main post
                $params = array(
                    'time'    => $event->time_created,
                    'icon' => 'comment',
                    'activity' => $activity,
                    'message' => 'Added a new discussion topic',
                    'author'  => array(
                        'name'  => $author->name,
                        'icon'  => $author_elgg->getIconURL('small'),
                        'url'   => "profile/{$author->login}",
                    ),
                    'item' => array(
                        'name' => $item->name,
                        'description' => $item->description,
                        'url'  => "clipit_activity/{$activity->id}/group/discussion/view/{$item->id}",
                    ),
                );
//                // Reply post
//                } else {
//                    $msg_parent = array_pop(ClipitPost::get_by_id(array($item->parent)));
//                    $params = array(
//                        'time'    => $event->time_created,
//                        'icon' => 'mail-reply',
//                        'activity' => $activity,
//                        'message' => 'Replied to the discussion topic',
//                        'author'  => array(
//                            'name'  => $author->name,
//                            'icon'  => $author_elgg->getIconURL('small'),
//                            'url'   => "profile/{$author->login}",
//                        ),
//                        'item' => array(
//                            'name' => $msg_parent->name,
//                            'description' => $item->description,
//                            'url'  => "clipit_activity/{$activity->id}/group/discussion/view/{$msg_parent->id}#reply_{$item->id}",
//                        ),
//                    );
//                    // Second level reply
//                    if(!$msg_parent->name){
//                        $params['icon'] = 'mail-reply-all';
//                        $id_top_msg = ClipitPost::get_parent($item->id, $top = true);
//                        $msg_parent = array_pop(ClipitPost::get_by_id(array($id_top_msg)));
//                        $params['item']['name'] = $msg_parent->name;
//                        $params['item']['url'] = "clipit_activity/{$activity->id}/group/discussion/view/{$msg_parent->id}#reply_{$item->id}";
//                    }
//
//                }
                break;
            case 'clipit_user':
                // ClipitUser ClipitChat
                break;
        }
        return $params;
    });


//    register_clipit_event('group-file', function($event, $relationship){
//        $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
//        $item = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
//        $activity_id = ClipitGroup::get_activity($object->id);
//        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
//        $author = array_pop(ClipitUser::get_by_id(array($event->performed_by_guid)));
//        $author_elgg = new ElggUser($event->performed_by_guid);
//
//        $params = array(
//            'time'    => $event->time_created,
//            'icon' => 'upload',
//            'message' => 'File uploaded',
//            'author' => array(
//                'name'  => $author->name,
//                'icon'  => $author_elgg->getIconURL('small'),
//                'url'   => "profile/{$author->username}",
//            ),
//            'activity'  => $activity,
//            'item' => array(
//                'name' => $item->name,
//                'description' => $item->description,
//                //'icon' => "$item->icon",
//                'icon' => "file-o",
//                'url' => "clipit_activity/{$activity->id}/group/files/view/{$item->id}",
//            )
//        );
//        return $params;
//    });
//    register_clipit_event('message-destination', function($event, $relationship){
//        $object = array_pop(ClipitMessage::get_by_id(array($relationship->guid_one)));
//        $activity_id = ClipitGroup::get_activity($object->id);
//        $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
//        $author = array_pop(ClipitUser::get_by_id(array($event->performed_by_guid)));
//        $author_elgg = new ElggUser($event->performed_by_guid);
//        $params = array(
//            'time'    => $event->time_created,
//            'icon' => 'comment',
//            'message' => 'Nueva discussión',
//            'author'  => array(
//                'name'  => $author->name,
//                'icon'  => $author_elgg->getIconURL('small'),
//                'url'   => "profile/{$author->login}",
//            ),
//            'item' => array(
//                'name' => $object->name,
//                'description' => $object->description,
//                'url' => "clipit_activity/{$activity->id}/group/discussion/view/{$object->id}",
//            )
//        );
//        return $params;
//    });

//    register_clipit_event('group-file', function($relationship, $activity){
//        $object = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
//        $params = array(
//            'icon' => 'upload',
//            'message' => 'File uploaded',
//            'item' => array(
//                'name' => $object->name,
//                'description' => $object->description,
//                'icon' => "ICONO!!",
//                'url' => "clipit_activity/{$activity->id}/group/files/view/{$object->id}",
//            )
//        );
//        return $params;
//    });
//    register_clipit_event('message-destination', function($relationship, $activity){
//        $object = array_pop(ClipitMessage::get_by_id(array($relationship->guid_one)));
//        $params = array(
//            'icon' => 'comment',
//            'message' => 'Nueva discussión',
//            'item' => array(
//                'name' => $object->name,
//                'description' => $object->description,
//                'url' => "clipit_activity/{$activity->id}/group/discussion/view/{$object->id}",
//            )
//        );
//        return $params;
//    });
//    register_clipit_event('activity-user', function($relationship, $activity){
//        $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
//        $params = array(
//            'icon' => 'user',
//            'message' => 'Nuevo miembro en',
//            'item' => array(
//                'name' => $object->name,
//                'url' => 'clipit_activity/%d/group/activity_log',
//                'url_data' => array($activity->id)
//            )
//        );
//        return $params;
//    });
}