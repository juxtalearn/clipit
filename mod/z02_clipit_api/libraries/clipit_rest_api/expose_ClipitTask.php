<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 21/05/14
 * Time: 16:03
 */

function expose_task_functions(){
    $api_suffix = "clipit.task.";
    $class_suffix = "ClipitTask::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "get_activity",
        $class_suffix . "get_activity",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "Get Task Activity",
        'GET', false, true);
}
