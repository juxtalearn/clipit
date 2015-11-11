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
elgg_register_event_handler('init', 'system', 'clipit_profile_init');

function clipit_profile_init() {
    // Register "/profile" page handler
    elgg_register_page_handler('profile', 'profile_page_handler');
    // Register "/settings" page handler
    elgg_register_page_handler('settings', 'usersettings_clipit_page_handler');

    // Register library
    elgg_register_library('clipit:profile', elgg_get_plugins_path() . 'z09_clipit_profile/lib/profile/functions.php');
    elgg_load_library('clipit:profile');

    elgg_register_event_handler('pagesetup', 'system', 'usersettings_clipit_pagesetup');
    // Actions
    elgg_register_action("settings/account", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/account.php");
    elgg_register_action("settings/avatar/upload", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/avatar/upload.php");
    elgg_register_action("settings/avatar/remove", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/avatar/remove.php");

    elgg_extend_view("navigation/menu/top", "navigation/menu/profile", 400);
    if(isset($_COOKIE['ccr'])) {
        elgg_extend_view("page/elements/head", 'css/ccr');
    }
}

/**
 * @param $page
 * @return bool
 */
function profile_page_handler($page){
    if($page[0] && $user = array_pop(ClipitUser::get_by_login(array($page[0])))){
        $title = $user->name;
        switch($user->role){
            case ClipitUser::ROLE_STUDENT:
                $sub_title = '<small class="margin-top-5 show">'.elgg_echo('student').'</small>';
                break;
            case ClipitUser::ROLE_TEACHER:
                $sub_title = '<small class="margin-top-5 show yellow">'.elgg_echo('teacher').'</small>';
                break;
            case ClipitUser::ROLE_ADMIN:
                $sub_title = '<small class="margin-top-5 red">'.elgg_echo('admin').'</small>';
                break;
        }
        $params = array(
            'content' => elgg_view("profile/layout", array('entity' => $user)),
            'title' => $title,
            'sub_title' => $sub_title,
            'filter' => "",
        );
        $body = elgg_view_layout('one_column', $params);

        echo elgg_view_page($title, $body);
    } else {
        return false;
    }
}

/**
 * @param $page
 * @return bool
 */
function usersettings_clipit_page_handler($page){

    if (!isset($page[0])) {
        $page[0] = 'user';
    }

    if (isset($page[1])) {
        $user = get_user_by_username($page[1]);
        elgg_set_page_owner_guid($user->guid);
    } else {
        $user = elgg_get_logged_in_user_entity();
        elgg_set_page_owner_guid($user->guid);
    }
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    elgg_push_breadcrumb(elgg_echo('settings'), "settings/user");
    elgg_set_context('user_settings');

    if(isset($page[1])){
        if($user->role == ClipitUser::ROLE_ADMIN) {
            $user = array_pop(ClipitUser::get_by_login(array($page[1])));
        } else {
            return false;
        }
    }
    switch ($page[0]) {
        case 'user':
            $title = elgg_echo("profile:settings:edit");
            // extend the account settings form
            elgg_extend_view('forms/settings/account', 'settings/account/name', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/password', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/email', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/language', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/ccr', 100);

            $content = elgg_view_form('settings/account', array('class' => 'form-horizontal clearfix'), array('entity' => $user));
            break;
        case 'avatar':
            $title = elgg_echo("profile:settings:edit_avatar");
            elgg_push_breadcrumb($title);
            $content = elgg_view('settings/avatar/upload', array('entity' => $user));
            break;
        default:
            return false;
            break;
    }
    elgg_set_page_owner_guid($user->id);
    elgg_extend_view("page/elements/owner_block", "settings/sidebar/profile");
    $params = array(
        'content' => $content,
        'title' => $title,
    );
    $body = elgg_view_layout('one_sidebar', $params);
    echo elgg_view_page($title, $body);
}

/**
 * Set up the menu for user settings
 *
 * @return void
 * @access private
 */
function usersettings_clipit_pagesetup() {

    if (elgg_get_context() == "user_settings") {
        $user_href = '';
        $user_id = elgg_get_page_owner_guid();
        if($user_id != elgg_get_logged_in_user_guid()){
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
            $user_href = "/".$user->login;
        }
        $params = array(
            'name' => 'settings_account',
            'text' => elgg_echo('profile:settings:change'),
            'href' => "settings/user".$user_href,
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'settings_avatar',
            'text' => elgg_echo('avatar:edit'),
            'href' => "settings/avatar".$user_href,
        );
        elgg_register_menu_item('page', $params);
    }
}
