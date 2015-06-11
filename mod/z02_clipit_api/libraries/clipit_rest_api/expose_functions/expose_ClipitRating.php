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

/**
 * Expose class functions for the ClipIt REST API
 */
function expose_rating_functions() {
    $api_suffix = "clipit.rating.";
    $class_suffix = "ClipitRating::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_target", $class_suffix . "get_target",
        array("id" => array("type" => "int", "required" => true)), "Get Rating Target", "GET",
        false, true
    );
    expose_function(
        $api_suffix . "get_by_target", $class_suffix . "get_by_target",
        array("target_array" => array("type" => "array", "required" => true)), "Get all Ratings by Target", "GET",
        false, true
    );
    expose_function(
        $api_suffix . "get_user_rating_for_target", $class_suffix . "get_user_rating_for_target", array(
            "user_id" => array("type" => "int", "required" => true),
            "target_id" => array("type" => "int", "required" => true)
        ), "Return the rating made by a user upon a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_average_rating_for_target", $class_suffix . "get_average_rating_for_target", array(
            "target_id" => array("type" => "int", "required" => true)
        ),"Return the average rating for a target", "GET", false, true);
    expose_function(
        $api_suffix . "add_tag_ratings", $class_suffix . "add_tag_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "tag_rating_array" => array("type" => "array", "required" => true)
        ), "Add Tag Ratings to a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_tag_ratings", $class_suffix . "set_tag_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "tag_rating_array" => array("type" => "array", "required" => true)
        ), "Set Tag Ratings to a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_tag_ratings", $class_suffix . "remove_tag_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "tag_rating_array" => array("type" => "array", "required" => true)
        ), "Remove Tag Ratings from a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_tag_ratings", $class_suffix . "get_tag_ratings",
        array("id" => array("type" => "int", "required" => true)), "Get Tag Ratings from a Rating.", 'GET', false, true
    );
    expose_function(
        $api_suffix . "add_performance_ratings", $class_suffix . "add_performance_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "performance_rating_array" => array("type" => "array", "required" => true)
        ), "Add Performance Ratings to a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "set_performance_ratings", $class_suffix . "set_performance_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "performance_rating_array" => array("type" => "array", "required" => true)
        ), "Set Performance Ratings to a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "remove_performance_ratings", $class_suffix . "remove_performance_ratings", array(
            "id" => array("type" => "int", "required" => true),
            "performance_rating_array" => array("type" => "array", "required" => true)
        ), "Remove Performance Ratings from a Rating.", 'POST', false, true
    );
    expose_function(
        $api_suffix . "get_performance_ratings", $class_suffix . "get_performance_ratings",
        array("id" => array("type" => "int", "required" => true)), "Get Performance Ratings from a Rating.", 'GET',
        false, true
    );
}
