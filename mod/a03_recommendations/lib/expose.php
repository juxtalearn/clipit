<?php

function expose_recommendation_engine()
{
//Exposes the recommendation for webservice access

    $api_suffix = "clipit.recommendations.";
    $class_suffix = "RecommendationEngine::";

    expose_function($api_suffix . "get_recommended_items", $class_suffix . "get_recommended_items", array(
        "user_id" => array("type" => "int", "required" => true),
        "item_types" => array("type" => "array", "required" => false),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended items ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_lsd_videos", $class_suffix . "get_recommended_lsd_videos", array(
        "users" => array("type" => "array", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended videos ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_videos", $class_suffix . "get_recommended_videos", array(
        "user_id" => array("type" => "int", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended videos ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_files", $class_suffix . "get_recommended_files", array(
        "user_id" => array("type" => "int", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended files ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_storyboards", $class_suffix . "get_recommended_storyboards", array(
        "user_id" => array("type" => "int", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended storyboards ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_resources", $class_suffix . "get_recommended_resources", array(
        "user_id" => array("type" => "int", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended resources ranked by their suitability.", "GET", false, true);

    expose_function($api_suffix . "get_recommended_users", $class_suffix . "get_recommended_users", array(
        "user_id" => array("type" => "int", "required" => true),
        "number_of_items" => array("type" => "int", "required" => false),
    ), "Get a sorted array of recommended users ranked by their suitability.", "GET", false, true);


}
