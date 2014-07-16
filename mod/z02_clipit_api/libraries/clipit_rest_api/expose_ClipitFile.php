<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:00
 */
function expose_file_functions() {
    $api_suffix = "clipit.file.";
    $class_suffix = "ClipitFile::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_group", $class_suffix . "get_group",
        array("id" => array("type" => "int", "required" => true)), "Get the Group this File is inside of.", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_task", $class_suffix . "get_task", array("id" => array("type" => "int", "required" => true)),
        "Get the Task this File is inside of.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_activity", $class_suffix . "get_activity",
        array("id" => array("type" => "int", "required" => true)), "Get the Activity this File is inside of.", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_site", $class_suffix . "get_site", array("id" => array("type" => "int", "required" => true)),
        "Get the Site this File is inside of.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Tags from a File", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_labels", $class_suffix . "add_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Add Labels by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_labels", $class_suffix . "set_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Set Labels by Id to a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_labels", $class_suffix . "remove_labels", array(
            "id" => array("type" => "int", "required" => true),
            "label_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a File", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_labels", $class_suffix . "get_labels",
        array("id" => array("type" => "int", "required" => true)), "Get Labels from a File", 'GET', false, true
    );
}
