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
elgg_register_event_handler('init', 'system', 'clipit_profile_init');

function clipit_profile_init() {
    // Register "/profile" page handler
    elgg_register_page_handler('profile', 'profile_page_handler');
    // Register "/settings" page handler
    elgg_register_page_handler('settings', 'usersettings_clipit_page_handler');

    elgg_register_event_handler('pagesetup', 'system', 'usersettings_clipit_pagesetup');
    // Actions
    elgg_register_action("settings/account", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/account.php");
}

/**
 * @param $page
 * @return bool
 */
function profile_page_handler($page){
    if($page[0] && $user = array_pop(ClipitUser::get_by_login(array($page[0])))){
        $title = $user->name;
        $params = array(
            'content' => elgg_view("profile/layout", array('entity' => $user)),
            'title' => $title,
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
    global $CONFIG;

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

    elgg_push_breadcrumb(elgg_echo('settings'), "settings/user");
    elgg_set_context('user_settings');

    switch ($page[0]) {
        case 'statistics':
            elgg_push_breadcrumb(elgg_echo('usersettings:statistics:opt:linktext'));
            $path = $CONFIG->path . "pages/settings/statistics.php";
            break;
        case 'plugins':
            elgg_push_breadcrumb(elgg_echo('usersettings:plugins:opt:linktext'));
            $path = $CONFIG->path . "pages/settings/tools.php";
            break;
        case 'user':
            $title = elgg_echo("profile:settings:edit");
            $path = $CONFIG->path . "pages/settings/account.php";
            // extend the account settings form
            elgg_extend_view('forms/settings/account', 'settings/account/name', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/password', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/email', 100);
            elgg_extend_view('forms/settings/account', 'settings/account/language', 100);

            $content = elgg_view_form('settings/account', array('class' => 'form-horizontal'));
            break;
        case 'avatar':
            $title = elgg_echo("profile:settings:edit_avatar");
            elgg_push_breadcrumb($title);
            $entity = new ElggUser($user);
            $content = elgg_view('core/avatar/upload', array('entity' => $entity));
            break;
        default:
            return false;
            break;
    }

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
    $user_id = elgg_get_logged_in_user_guid();

    if ($user_id && elgg_get_context() == "user_settings") {
        $params = array(
            'name' => '1_account',
            'text' => elgg_echo('usersettings:user:opt:linktext'),
            'href' => "settings/user",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => '1_avatar',
            'href' => "settings/avatar",
            'text' => elgg_echo('avatar:edit'),
        );
        elgg_register_menu_item('page', $params);
    }
}
