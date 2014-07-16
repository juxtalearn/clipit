<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:00
 */
function expose_la_functions() {
    $api_suffix = "clipit.la.";
    $class_suffix = "ClipitLA::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "send_metrics", $class_suffix . "send_metrics", array(
            "returnId" => array("type" => "int", "required" => true),
            "data" => array("type" => "string", "required" => true),
            "statuscode" => array("type" => "int", "required" => true)
        ), "Send Learning Analytics Metrics to ClipIt", "POST", false, true
    );
}
