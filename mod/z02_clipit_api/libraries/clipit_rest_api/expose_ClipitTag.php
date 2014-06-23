<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:03
 */

function expose_tag_functions(){
    $api_suffix = "clipit.tag.";
    $class_suffix = "ClipitTag::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_tricky_topics",
        $class_suffix . "get_tricky_topics",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Tricky Topics which contain a Tag",
        'GET', false, true);
}
