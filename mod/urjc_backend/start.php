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
    //loadFiles(elgg_get_plugins_path()."urjc_backend/libraries/");
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
