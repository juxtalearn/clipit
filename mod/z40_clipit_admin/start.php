<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_admin
 */

/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_admin_init');

/**
 * Initialization method which views and actions for Clipit Administration pages.
 */
function clipit_admin_init() {
    $plugin_name = "z40_clipit_admin";
    // Register actions
    elgg_register_action("update_clipit",
        elgg_get_plugins_path().$plugin_name."/actions/update_clipit/update.php");
    elgg_register_action("clipit_options/apply",
        elgg_get_plugins_path().$plugin_name."/actions/clipit_options/apply.php");
    elgg_register_action("import_export/import",
        elgg_get_plugins_path().$plugin_name."/actions/import_export/import.php");
    elgg_register_action("import_export/export",
        elgg_get_plugins_path().$plugin_name."/actions/import_export/export.php");

    // Set tag branch and version (if unset - first run only)
    $clipit_tag_branch = get_config("clipit_tag_branch");
    if(empty($clipit_tag_branch)){
        $versions_file = file_get_contents(elgg_get_plugins_path().$plugin_name."/updates/versions.json");
        $versions = json_decode($versions_file);
        set_config("clipit_tag_branch", $versions->clipit_tag_branch);
        set_config("clipit_version", $versions->clipit_version);
    }

    // Register Admin Menus
    elgg_register_admin_menu_item('configure', 'clipit_options', 'clipit', 1);
    elgg_register_admin_menu_item('configure', 'google_auth', 'clipit', 2);
    elgg_register_admin_menu_item('configure', 'import_export', 'clipit', 3);
    elgg_register_admin_menu_item('configure', 'update_clipit', 'clipit', 4);

    expose_function(
        "clipit.admin.export_all",
        "ClipitDataExport::export_all",
        null,
        "Export all Clipit classes and relationships in Excel format for download",
        "GET",
        false,
        true
    );
    expose_function(
        "clipit.admin.set_clipit_version",
        "ClipitUpdate::set_clipit_version",
        array("clipit_version" => array("type" => "string", "required" => true)),
        "Sets forcefully the current Clipit version",
        "POST",
        false,
        true
    );
    // UPDATE REST API CALLS
    expose_function(
        "clipit.admin.update_clipit",
        "ClipitUpdate::update_clipit",
        null,
        "Update Clipit to latest tag released",
        "POST",
        false,
        true
    );
    expose_function(
        "clipit.admin.run_update_scripts",
        "ClipitUpdate::run_update_scripts",
        null,
        "",
        "POST",
        false,
        true
    );
    expose_function(
        "clipit.admin.flush_caches",
        "ClipitUpdate::flush_caches",
        null,
        "",
        "POST",
        false,
        true
    );
}
