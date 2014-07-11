<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:01
 */
function expose_performance_item_functions() {
    $api_suffix = "clipit.performance_item.";
    $class_suffix = "ClipitPerformanceItem::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_by_category", $class_suffix . "get_by_category",
        array("category" => array("type" => "string", "required" => false)),
        "Get items belonging to a certain Category. Leave Category blank for all items, ordered by Category.", 'GET',
        false, true
    );
}
