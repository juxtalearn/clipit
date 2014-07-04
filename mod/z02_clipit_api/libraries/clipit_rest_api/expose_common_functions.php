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

function expose_common_functions($api_suffix, $class_suffix){
    expose_function(
        $api_suffix . "list_properties",
        $class_suffix . "list_properties",
        null,
        "Get class properties",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_properties",
        $class_suffix . "get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => false)),
        "Get property=>value array",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_properties",
        $class_suffix . "set_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_value_array" => array(
                "type" => "array",
                "required" => true)),
        "Set property=>value array and save into the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "create",
        $class_suffix . "create",
        array(
            "prop_value_array" => array(
                "type" => "array",
                "required" => true)),
        "Create a new instance, set property=>value array and save into the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "create_clone",
        $class_suffix . "create_clone",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Create a clone copy of an instance",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_clones",
        $class_suffix . "get_clones",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get all Item IDs which were cloned from the one given",
        "GET", false, true);
    expose_function(
        $api_suffix . "delete_by_id",
        $class_suffix . "delete_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "Delete instances by Id",
        'POST', false, true);
    expose_function(
        $api_suffix . "delete_all",
        $class_suffix . "delete_all",
        null,
        "Delete all instances of this class",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_all",
        $class_suffix . "get_all",
        array(
            "limit" => array(
                "type" => "int",
                "required" => false),
            "id_only" => array(
                "type" => "bool",
                "required" => false)),
        "Get all instances",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_id",
        $class_suffix . "get_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "Get instances by Id",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_events",
        $class_suffix . "get_events",
        array(
            "offset" => array(
                "type" => "int",
                "required" => false),
            "limit" => array(
                "type" => "int",
                "required" => false)),
        "Get object-type associated events",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_by_owner",
        $class_suffix . "get_by_owner",
        array(
            "owner_array" => array(
                "type" => "array",
                "required" => true),
            "limit" => array(
                "type" => "int",
                "required" => false)),
        "Get instances from an Owner",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_from_search",
        $class_suffix . "get_from_search",
        array(
            "search_string" => array(
                "type" => "string",
                "required" => true),
            "name_only" => array(
                "type" => "bool",
                "required" => false),
            "strict" => array(
                "type" => "bool",
                "required" => false)),
        "Get instances from searching inside the object name and description for a string",
        'GET', false, true);
}