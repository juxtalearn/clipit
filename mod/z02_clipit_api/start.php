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
 * Initialization method which loads objects, libraries, exposes the REST API,
 * and registers test classes.
 */
function clipit_api_init() {
    $plugin_name = "z02_clipit_api";
    // Load libraries
    $lib_path = elgg_get_plugins_path().$plugin_name."/libraries";
    // Load REST API Expose functions
    loadFiles("$lib_path/clipit_rest_api/");
    // Expose REST API
    include_once("$lib_path/expose_clipit_api.php");
    // Load palettes
    loadFiles("$lib_path/performance_palette/");
    loadFiles("$lib_path/example_types/");
    elgg_register_action("useradd",
        elgg_get_plugins_path().$plugin_name."/actions/useradd.php", 'admin');
    // Publish Site to Global (if not done already)
    if(get_config("clipit_global_published") !== true) {
        set_config("clipit_global_published", true);
        ClipitSite::publish_to_global();
    }
    // Add aditional plugin hook handler for permissions_check
    elgg_register_plugin_hook_handler('permissions_check',
        'all', 'clipit_override_permissions',600);
}

function clipit_override_permissions($hook, $type, $value, $params){
    // check if user is inside the same ClipitGroup where the entity is contained
    $user = elgg_extract('user', $params);
    $entity = elgg_extract('entity', $params);
    $entity_subtype = get_subtype_from_id($entity->subtype);
    switch ($entity_subtype){
        case ClipitVideo::SUBTYPE:
            $entity_group = ClipitVideo::get_group($entity->guid);
            break;
        case ClipitStoryboard::SUBTYPE:
            $entity_group = ClipitStoryboard::get_group($entity->guid);
            break;
        case ClipitFile::SUBTYPE:
            $entity_group = ClipitFile::get_group($entity->guid);
            break;
        default:
            $entity_group = null;
    }
    if(!empty($entity_group)){
        $user_groups = ClipitUser::get_groups($user->guid);
        if(in_array($entity_group, $user_groups)){
            return true;
        }
    }
    return null;
}
