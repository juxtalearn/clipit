<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:04
 */

function expose_tricky_topic_functions(){
    $api_suffix = "clipit.tricky_topic.";
    $class_suffix = "ClipitTrickyTopic::";
    expose_common_functions($api_suffix, $class_suffix);
}
