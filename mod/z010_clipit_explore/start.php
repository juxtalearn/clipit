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
elgg_register_event_handler('init', 'system', 'clipit_explore_init');

function clipit_explore_init() {
    // Register "/explore" page handler
    elgg_register_page_handler('explore', 'explore_page_handler');

    elgg_register_event_handler('pagesetup', 'system', 'explore_clipit_pagesetup');
    // Actions
    elgg_register_action("settings/account", elgg_get_plugins_path() . "z09_clipit_profile/actions/settings/account.php");
}

/**
 * Explore page handler
 *
 * @param array $page Array of URL components for routing
 * @return bool
 */
function explore_page_handler($page) {
    $current_user = elgg_get_logged_in_user_entity();
    elgg_set_context('explore');
    if (!$current_user) {
        register_error(elgg_echo('noaccess'));
        $_SESSION['last_forward_from'] = current_page_url();
        forward('');
    }

    $base_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/activity';
    $vars = array();
    $vars['page'] = $page[0];

    require_once "$base_dir/explore.php";

    return true;

}

/**
 * @param $page
 * @return bool
 */

/**
 * Set up the menu for user settings
 *
 * @return void
 * @access private
 */
function explore_clipit_pagesetup() {
    $user_id = elgg_get_logged_in_user_guid();

    if ($user_id && elgg_get_context() == "explore") {
        $params = array(
            'name' => 'settings_account',
            'text' => elgg_echo('videos'),
            'href' => "?filter=videos",
        );
        elgg_register_menu_item('page', $params);
        $params = array(
            'name' => 'settings_avatar',
            'text' => elgg_echo('files'),
            'href' => "?filter=videos",
        );
        elgg_register_menu_item('page', $params);
    }
}
