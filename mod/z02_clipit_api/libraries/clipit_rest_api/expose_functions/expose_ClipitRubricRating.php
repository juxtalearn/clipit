<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * Expose class functions for the Clipit REST API
 */
function expose_rubric_rating_functions()
{
    $api_suffix = "clipit.rubric_rating.";
    $class_suffix = "ClipitRubricRating::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_average_rating_for_target", $class_suffix . "get_average_rating_for_target",
        array("target_id" => array("type" => "int", "required" => true)),
        "Get the average rubric rating for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_item_average_rating_for_target", $class_suffix . "get_item_average_rating_for_target", array(
        "target_id" => array("type" => "int", "required" => true)
    ), "Get the average rubric rating by item for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_average_user_rating_for_target", $class_suffix . "get_average_user_rating_for_target", array(
        "user_id" => array("type" => "int", "required" => true),
        "target_id" => array("type" => "int", "required" => true)
    ), "Get the average rubric rating from a user for a target", 'GET', false, true
    );
    expose_function(
        $api_suffix . "get_by_item", $class_suffix . "get_by_item",
        array(
            "item_array" => array("type" => "array", "required" => true)
        ), "Get Rubric Ratings by Rubric Items", "GET", false, true
    );
}
