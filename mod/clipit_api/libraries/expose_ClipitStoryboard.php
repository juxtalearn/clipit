<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:03
 */

function expose_storyboard_functions(){
    $api_suffix = "clipit.storyboard.";
    $class_suffix = "ClipitStoryboard::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_publication_functions($api_suffix, $class_suffix);
}
