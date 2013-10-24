<?php
/**
 * JuxtaLearn ClipIt Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3. *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details. *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_core_init');

/**
 * Initialization method which loads libraries, exposes REST API, and registers test classes.
 */
function clipit_core_init(){
    loadClasses();
    loadLibs();
    exposeRestApi();
    elgg_register_plugin_hook_handler('unit_test', 'system', 'clipit_core_tests');
}

/**
 * Loads clipit classes.
 * @throws InstallationException
 */
function loadClasses(){
    $class_files = elgg_get_file_list(elgg_get_plugins_path()."clipit_core/classes/",array(), array(), array(".php"));
    foreach($class_files as $class){
        elgg_log("Loading $class...");
        if(!include_once($class)){
            $msg = "Could not load $class";
            throw new InstallationException($msg);
        }
    }
}

/**
 * Loads clipit libraries.
 * @throws InstallationException
 */
function loadLibs(){
    $lib_files = elgg_get_file_list(elgg_get_plugins_path()."clipit_core/lib/", array(), array(), array(".php"));
    foreach($lib_files as $file){
        elgg_log("Loading $file...");
        if(!include_once($file)){
            $msg = "Could not load $file";
            throw new InstallationException($msg);
        }
    }
}

/**
 * Exposes the REST API functions.
 */
function exposeRestApi(){
    \clipit\user\expose_functions();
    \clipit\quiz\expose_functions();
}

/**
 * Method which runs and collects results for PHP Unit tests.
 *
 * @param $hook
 * @param $type
 * @param $value
 * @param $params
 *
 * @return array
 */
function clipit_core_tests($hook, $type, $value, $params){
    $test_files = elgg_get_file_list(elgg_get_plugins_path()."clipit_core/tests/",array(), array(), array(".php"));
    foreach($test_files as $file){
        $value[] = $file;
    }
    return $value;
}
