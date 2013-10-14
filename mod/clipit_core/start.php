<?php

/**
 * [Short description/title for module]
 * 
 * [Long description for module]
 * 
 * PHP version:      >= 5.2
 * 
 * Creation date:    [YYYY-MM-DD]
 * Last update:      $Date$
 * 
 * @category         [name]
 * @package          [name]
 * @subpackage       [name]
 * @author           Pablo Llinás Arnaiz <pebs74@gmail.com>
 * @version          $Version$
 * @link             [URL description]
 * 
 * @license          GNU Affero General Public License v3
 * http://www.gnu.org/licenses/agpl-3.0.txt
 * 
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

elgg_register_event_handler('init', 'system', 'clipit_core_init');

function clipit_core_init() {
    register_libs();
    expose_functions();
    elgg_register_plugin_hook_handler('unit_test', 'system', 'clipit_core_tests');
}

function register_libs(){
    elgg_register_library('clipit:user', elgg_get_plugins_path().'clipit_core/lib/user.php');
    elgg_register_library('clipit:tests', elgg_get_plugins_path().'clipit_core/tests/test.php');
}

function expose_functions(){
    elgg_load_library('clipit:user');
    
    expose_function("clipit.getUsers", 
                "getUsers", 
                 NULL,
                 "<description>",
                 'GET',
                 true,
                 false
                );
}

function clipit_core_tests($hook, $type, $value, $params) {
    $value[] = elgg_get_plugins_path()."clipit_core/tests/clipit_core_tests.php";
    return $value;
}
