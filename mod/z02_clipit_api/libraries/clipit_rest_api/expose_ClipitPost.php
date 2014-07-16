<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:01
 */
function expose_post_functions() {
    $api_suffix = "clipit.post.";
    $class_suffix = "ClipitPost::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "add_storyboards", $class_suffix . "add_storyboards", array(
            "id" => array("type" => "int", "required" => true),
            "storyboard_array" => array("type" => "array", "required" => true)
        ), "Add Storyboards by Id to a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_storyboards", $class_suffix . "set_storyboards", array(
            "id" => array("type" => "int", "required" => true),
            "storyboard_array" => array("type" => "array", "required" => true)
        ), "Set Storyboards by Id to a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_storyboards", $class_suffix . "remove_storyboards", array(
            "id" => array("type" => "int", "required" => true),
            "storyboard_array" => array("type" => "array", "required" => true)
        ), "Removes Storyboards by Id from a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_storyboards", $class_suffix . "get_storyboards",
        array("id" => array("type" => "int", "required" => true)), "Gets Storyboards from a Post", "GET", false, true
    );
    expose_function(
        $api_suffix . "add_videos", $class_suffix . "add_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Add Videos by Id to a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "set_videos", $class_suffix . "set_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Set Videos by Id to a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "remove_videos", $class_suffix . "remove_videos", array(
            "id" => array("type" => "int", "required" => true),
            "video_array" => array("type" => "array", "required" => true)
        ), "Removes Videos by Id from a Post", "POST", false, true
    );
    expose_function(
        $api_suffix . "get_videos", $class_suffix . "get_videos",
        array("id" => array("type" => "int", "required" => true)), "Gets Videos from a Post", "GET", false, true
    );
}
