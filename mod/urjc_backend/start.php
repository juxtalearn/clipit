<?php
/**
 * URJC Backend
 * PHP version:     >= 5.2
 * Creation date:   2013-11-01
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'urjc_backend_init');

/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function urjc_backend_init(){
    /*echo elgg_get_entities(
        array(
            'type' => "object",
            'subtype' => "clipit_activity",
            'limit' => 10));*/
    //loadFiles(elgg_get_plugins_path()."urjc_backend/libraries/");
    register_pam_handler('clipit_auth_usertoken');
}

/**
 * Loads PHP files.
 *
 * @throws InstallationException
 */
function loadFiles($path){
    if(!$path){
        return false;
    }
    $obj_files = elgg_get_file_list($path, array(), array(), array(".php"));
    foreach($obj_files as $obj){
        elgg_log("Loading $obj...");
        if(!include_once($obj)){
            $msg = "Could not load $obj";
            throw new InstallationException($msg);
        }
    }
}

/**
 * Check the user token
 * This examines whether an authentication token is present and returns true if
 * it is present and is valid. The user gets logged in so with the current
 * session code of Elgg, that user will be logged out of all other sessions.
 *
 * @return bool
 * @access private
 */
function clipit_auth_usertoken(){
    global $CONFIG;
    if(isset($_SERVER["HTTP_AUTH_TOKEN"])){
        $token = $_SERVER["HTTP_AUTH_TOKEN"];
    }
    if(!isset($token) || empty($token)){
        return false;
    }

    $validated_userid = validate_user_token($token, $CONFIG->site_id);

    if($validated_userid){
        $u = get_entity($validated_userid);

        // Could we get the user?
        if(!$u){
            return false;
        }

        // Not an elgg user
        if((!$u instanceof ElggUser)){
            return false;
        }

        // User is banned
        if($u->isBanned()){
            return false;
        }

        // Fail if we couldn't log the user in
        if(!login($u)){
            return false;
        }

        return true;
    }

    return false;
}
