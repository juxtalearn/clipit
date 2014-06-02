<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:00
 */

function expose_label_functions(){
    $api_suffix = "clipit.label.";
    $class_suffix = "ClipitLabel::";
    expose_common_functions($api_suffix, $class_suffix);
}