<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:00
 */
function expose_example_functions() {
    $api_suffix = "clipit.example.";
    $class_suffix = "ClipitExample::";
    expose_common_functions($api_suffix, $class_suffix);
}
