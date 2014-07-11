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
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/clipit_rest_api/");
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/juxtalearn-cookie-authentication/");
    loadFiles(elgg_get_plugins_path() . "z02_clipit_api/libraries/PHPExcel/");
    require_once("libraries/performance_palette/load_performance_palette.php");
    expose_clipit_api();
    elgg_register_admin_menu_item('configure', 'youtube_auth', 'settings');
    elgg_register_admin_menu_item('configure', 'clipit_api_test', 'settings');
}

