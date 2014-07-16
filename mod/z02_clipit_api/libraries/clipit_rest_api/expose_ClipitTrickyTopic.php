<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:04
 */
function expose_tricky_topic_functions() {
    $api_suffix = "clipit.tricky_topic.";
    $class_suffix = "ClipitTrickyTopic::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_tags", $class_suffix . "add_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Add Tags by Id to a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tags", $class_suffix . "set_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Set Tags by Id to a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tags", $class_suffix . "remove_tags", array(
            "id" => array("type" => "int", "required" => true),
            "tag_array" => array("type" => "array", "required" => true)
        ), "Remove Tags by Id from a Tricky Topic", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tags", $class_suffix . "get_tags", array("id" => array("type" => "int", "required" => true)),
        "Get Tags from a Tricky Topic", 'GET', false, true
    );
}
