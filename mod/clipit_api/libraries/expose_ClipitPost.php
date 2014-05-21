<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:01
 */

function expose_post_functions(){
    $api_suffix = "clipit.post.";
    $class_suffix = "ClipitPost::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_message_functions($api_suffix, $class_suffix);
}
