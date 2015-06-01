<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_admin
 */

/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_admin_init');

/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function clipit_admin_init() {
    $plugin_name = "z40_clipit_admin";
    // Register actions
    elgg_register_action("update_clipit", elgg_get_plugins_path().$plugin_name."/actions/update_clipit/update.php");
    elgg_register_action("clipit_options/save", elgg_get_plugins_path().$plugin_name."/actions/clipit_options/save.php");
    elgg_register_action("clipit_options/clean_accounts", elgg_get_plugins_path().$plugin_name."/actions/clipit_options/clean_accounts.php");
    elgg_register_action("import_export/import", elgg_get_plugins_path().$plugin_name."/actions/import_export/import.php");
    elgg_register_action("import_export/export", elgg_get_plugins_path().$plugin_name."/actions/import_export/export.php");
    // Register Admin Menus
    elgg_register_admin_menu_item('configure', 'clipit_options', 'clipit', 1);
    elgg_register_admin_menu_item('configure', 'youtube_auth', 'clipit', 2);
    elgg_register_admin_menu_item('configure', 'update_clipit', 'clipit', 3);
    elgg_register_admin_menu_item('configure', 'import_export', 'clipit', 4);
}
