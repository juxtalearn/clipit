<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:03
 */

function expose_sta_functions(){
    $api_suffix = "clipit.sta.";
    $class_suffix = "ClipitSTA::";
    expose_common_functions($api_suffix, $class_suffix);
}
