<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:01
 */
function expose_performance_rating_functions() {
    $api_suffix = "clipit.performance_rating.";
    $class_suffix = "ClipitPerformanceRating::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_average_target_rating", $class_suffix . "get_average_item_rating",
        array("target_id" => array("type" => "int", "required" => true)),
        "Get the average performance rating for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_average_user_rating_for_target", $class_suffix . "get_average_user_rating_for_target", array(
            "user_id" => array("type" => "int", "required" => true),
            "target_id" => array("type" => "int", "required" => true)
        ), "Get the average performance rating from a user for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_average_item_rating_for_target", $class_suffix . "get_average_item_rating_for_target", array(
            "performance_item_id" => array("type" => "int", "required" => true),
            "target_id" => array("type" => "int", "required" => true)
        ), "Get the average rating of one performance item for a target", 'GET', false, true
    );
}
