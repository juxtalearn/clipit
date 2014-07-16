<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 15:59
 */
function expose_event_functions() {
    $api_suffix = "clipit.event.";
    $class_suffix = "ClipitEvent::";
    expose_function(
        $api_suffix . "get_latest", $class_suffix . "get_latest", array(
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get the latest events without filtering.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_user", $class_suffix . "get_by_user", array(
            "user_array" => array("type" => "array", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events filtered by User.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_object", $class_suffix . "get_by_object", array(
            "object_array" => array("type" => "array", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events filtered by Object.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_recommended_events", $class_suffix . "get_recommended_events", array(
            "user_id" => array("type" => "int", "required" => true),
            "offset" => array("type" => "int", "required" => true),
            "limit" => array("type" => "int", "required" => true)
        ), "Get events which may interest a User.", 'GET', false, true
    );
}
