<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */
/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_api_init');
/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function clipit_api_init() {
    $lib_path = elgg_get_plugins_path() . "z02_clipit_api/libraries";
    loadFiles("$lib_path/clipit_rest_api/");
    expose_clipit_api();
    loadFiles("$lib_path/performance_palette/");
    loadFiles("$lib_path/example_types/");
    elgg_register_action("useradd", elgg_get_plugins_path(). "z02_clipit_api/actions/useradd.php", 'admin');
    elgg_register_admin_menu_item('configure', 'youtube_auth', 'settings');
    elgg_register_admin_menu_item('configure', 'update_clipit', 'settings');
    elgg_register_admin_menu_item('configure', 'clipit_options', 'settings');
    if(get_config("clipit_global_published") !== true) {
        set_config("clipit_global_published", true);
        ClipitSite::publish_to_global();
    }
}
