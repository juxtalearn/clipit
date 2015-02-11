<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */

// Update ClipitQuizResult->user from static int to relationship
$quiz_result_array = ClipitQuizResult::get_all(0, 0, "", true, true);
foreach($quiz_result_array as $quiz_result_id){
    $elgg_object = get_entity((int)$quiz_result_id);
    $user = $elgg_object->get("user");
    if(!empty($user)){
        ClipitQuizResult::set_properties((int)$quiz_result_id, array("user" => (int)$user));
    }
    $elgg_object->set("user", null);
}