<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:04
 */
function expose_tag_rating_functions() {
    $api_suffix = "clipit.tag_rating.";
    $class_suffix = "ClipitTagRating::";
    expose_common_functions($api_suffix, $class_suffix);
}
