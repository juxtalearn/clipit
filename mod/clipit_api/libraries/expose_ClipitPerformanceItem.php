<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:01
 */

function expose_performance_item_functions(){
    $api_suffix = "clipit.performance_item.";
    $class_suffix = "ClipitPerformanceItem::";
    expose_common_functions($api_suffix, $class_suffix);
}
