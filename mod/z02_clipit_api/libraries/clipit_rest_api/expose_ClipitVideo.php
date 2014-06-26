<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:04
 */

function expose_video_functions(){
    $api_suffix = "clipit.video.";
    $class_suffix = "ClipitVideo::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_resource_functions($api_suffix, $class_suffix);
}
