<?php
/**
 * Clipit eLearning Platform
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, Clipit Team
 * @version         $Version$
 * @link            http://www.clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      urjc_backend
 */
/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'urjc_backend_init');

/**
 * Initialization method which loads libraries and configures some options and handlers.
 */
function urjc_backend_init() {
    $lib_path = elgg_get_plugins_path() . "z01_urjc_backend/libraries/";
    loadFiles($lib_path."/php_excel/Classes/");
    date_default_timezone_set(get_config("timezone"));
    register_pam_handler('check_http_auth_token');
}

// Flatten a multidimensional array
function array_flatten($array) {
    $return = array();
    foreach ($array as $key => $value) {
        if (is_array($value)){
            $return = array_merge($return, array_flatten($value));
        } else {
            $return[$key] = $value;
        }
    }
    return $return;
}

/**
 * Loads PHP files from a specified path
 *
 * @param string $path Path to load php files from (must be absolute path!)
 *
 * @throws InstallationException
 * @return bool True if success.
 */
function loadFiles($path) {
    if (!$path) {
        return false;
    }
    $obj_files = elgg_get_file_list($path, array(), array(), array(".php"));
    foreach ($obj_files as $obj) {
        elgg_log("Loading $obj...");
        include_once($obj);
    }
    return true;
}

/**
 * Check the user token sent through HTTP
 * This examines whether an authentication token is present and returns true if
 * it is present and is valid. The user gets logged in so with the current
 * session code of Elgg, that user will be logged out of all other sessions.
 * @return bool
 * @access private
 */
function check_http_auth_token() {
    global $CONFIG;
    if (isset($_SERVER["HTTP_AUTH_TOKEN"])) {
        $token = $_SERVER["HTTP_AUTH_TOKEN"];
    }
    if (!isset($token) || empty($token)) {
        return false;
    }
    $validated_userid = validate_user_token($token, $CONFIG->site_id);
    if ($validated_userid) {
        $u = get_entity($validated_userid);
        // Could we get the user?
        if (!$u) {
            return false;
        }
        // Not an elgg user
        if ((!$u instanceof ElggUser)) {
            return false;
        }
        // User is banned
        if ($u->isBanned()) {
            return false;
        }
        // Fail if we couldn't log the user in
        if (!login($u)) {
            return false;
        }
        return true;
    }
    return false;
}

