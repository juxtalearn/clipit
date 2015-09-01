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
function expose_performance_rating_functions() {
    $api_suffix = "clipit.performance_rating.";
    $class_suffix = "ClipitPerformanceRating::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_by_item", $class_suffix . "get_by_item",
        array("item_array" => array("type" => "array", "required" => true)),
        "Get Performance Ratings by target resource item", "GET", false, true
    );
    expose_function(
        $api_suffix . "get_average_rating_for_target", $class_suffix . "get_average_rating_for_target",
        array("target_id" => array("type" => "int", "required" => true)),
        "Get the average performance rating for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_item_average_rating_for_target", $class_suffix . "get_item_average_rating_for_target", array(
        "target_id" => array("type" => "int", "required" => true)
    ), "Get the average performance rating by item for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_average_user_rating_for_target", $class_suffix . "get_average_user_rating_for_target", array(
            "user_id" => array("type" => "int", "required" => true),
            "target_id" => array("type" => "int", "required" => true)
        ), "Get the average performance rating from a user for a target", 'GET', false, true
    );

}
