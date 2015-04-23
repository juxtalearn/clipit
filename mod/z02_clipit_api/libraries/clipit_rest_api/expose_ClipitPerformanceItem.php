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
function expose_performance_item_functions() {
    $api_suffix = "clipit.performance_item.";
    $class_suffix = "ClipitPerformanceItem::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_from_category", $class_suffix . "get_from_category",
        array(
            "category" => array("type" => "string", "required" => false),
            "language" => array("type" => "string", "required" => false)),
        "Get items from a category. Leave  blank for all items, ordered by Category.", 'GET',
        false, true
    );
    expose_function(
        $api_suffix . "get_by_reference", $class_suffix . "get_by_reference",
        array("reference_array" => array("type" => "array", "required" => false)),
        "Get items by reference number", 'GET',
        false, true
    );
}
