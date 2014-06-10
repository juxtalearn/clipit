<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:02
 */

function expose_site_functions(){
    $api_suffix = "clipit.site.";
    $class_suffix = "ClipitSite::";
    expose_function(
        $api_suffix . "get_site",
        $class_suffix . "get_site",
        null,
        "Return the Site object.",
        'GET', false, true);
    unexpose_function("system.api.list");
    expose_function(
        $api_suffix . "api_list",
        $class_suffix . "api_list",
        null,
        "Return the API method list, including description and required parameters.",
        'GET', false, false);
    unexpose_function("auth.gettoken");
    expose_function(
        $api_suffix . "get_token",
        $class_suffix . "get_token",
        array(
            "login" => array(
                "type" => "string",
                "required" => true),
            "password" => array(
                "type" => "string",
                "required" => true),
            "timeout" => array(
                "type" => "int",
                "required" => false)),
        "Obtain a user authentication token which can be used for authenticating future API calls passing it as the parameter \"auth_token\"",
        'GET', false, false);
    expose_function(
        $api_suffix . "remove_token",
        $class_suffix . "remove_token",
        array(
            "token" => array(
                "type" => "string",
                "required" => true)),
        "Remove an API user authentication token from the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "lookup",
        $class_suffix . "lookup",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Returns basic information about an unknown object based on its id",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_google_token",
        $class_suffix . "get_google_token",
        null,
        "Get a Google API authentication token from the system",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_google_token",
        $class_suffix . "set_google_token",
        array(
            "token" => array(
                "type" => "string",
                "required" => true)),
        "Set a Google API authentication token from the system",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_google_refresh_token",
        $class_suffix . "get_google_refresh_token",
        null,
        "Get a Google API refresh authentication token from the system",
        'GET', false, true);
    expose_function(
        $api_suffix . "set_google_refresh_token",
        $class_suffix . "set_google_refresh_token",
        array(
            "token" => array(
                "type" => "string",
                "required" => true)),
        "Set a Google API refresh authentication token from the system",
        'POST', false, true);
}
