<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
$qq_array = ClipitQuizQuestion::get_all();
foreach($qq_array as $qq){
    if($qq->video == "0") {
        ClipitQuizQuestion::set_properties((int)$qq->id, array("video" => ""));
    }
}
