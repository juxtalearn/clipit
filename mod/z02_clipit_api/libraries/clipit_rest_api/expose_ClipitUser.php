<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:04
 */

function expose_user_functions(){
    $api_suffix = "clipit.user.";
    $class_suffix = "ClipitUser::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_from_excel",
        $class_suffix . "add_from_excel",
        array(
            "file_path" => array(
                "type" => "string",
                "required" => true)),
        "Add Users contained in an Excel file",
        "POST", false, true);
    expose_function(
        $api_suffix . "get_by_login",
        $class_suffix . "get_by_login",
        array(
            "login_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by Login",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_email",
        $class_suffix . "get_by_email",
        array(
            "email_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by email. The result is a nested array, with an array of users per email.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_by_role",
        $class_suffix . "get_by_role",
        array(
            "role_array" => array(
                "type" => "array",
                "required" => true)),
        "Get all instances by role. The result is a nested array, with an array of users per role.",
        'GET', false, true);

    expose_function(
        $api_suffix . "set_role_student",
        $class_suffix . "set_role_student",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_role_teacher",
        $class_suffix . "set_role_teacher",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "set_role_admin",
        $class_suffix . "set_role_admin",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Set the Role of a User to Student.",
        'POST', false, true);
    expose_function(
        $api_suffix . "get_last_login",
        $class_suffix . "get_last_login",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get the last login time for a User.",
        "GET", false, true);
    expose_function(
        $api_suffix . "get_groups",
        $class_suffix . "get_groups",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get all Groups in which this user is a member of.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_activities",
        $class_suffix . "get_activities",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "joined_only" => array(
                "type" => "bool",
                "required" => false)),
        "Get all Activities in which this user is a called to, or has joined.",
        'GET', false, true);
    expose_function(
        $api_suffix . "get_avatar",
        $class_suffix . "get_avatar",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "size" => array(
                "type" => "string",
                "required" => false)),
        "Get Avatar for a User.",
        'GET', false, true);
}
