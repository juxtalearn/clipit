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
}
