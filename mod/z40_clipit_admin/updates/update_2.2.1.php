<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */

// Update ClipitActivity->tricky_topic from static int to relationship
$activity_array = ClipitActivity::get_all(0, 0, "", true, true);
foreach($activity_array as $activity_id){
    $elgg_object = get_entity((int)$activity_id);
    $tricky_topic = $elgg_object->get("tricky_topic");
    if(!empty($tricky_topic)){
        ClipitActivity::set_properties((int)$activity_id, array("tricky_topic" => (int)$tricky_topic));
    }
    $elgg_object->set("tricky_topic", null);
}

// Update ClipitExample->tricky_topic from static int to relationship
$example_array = ClipitExample::get_all(0, 0, "", true, true);
foreach($example_array as $example_id){
    $elgg_object = get_entity((int)$example_id);
    $tricky_topic = $elgg_object->get("tricky_topic");
    if(!empty($tricky_topic)){
        ClipitExample::set_properties((int)$example_id, array("tricky_topic" => (int)$tricky_topic));
    }
    $elgg_object->set("tricky_topic", null);
}

// Update ClipitQuiz->tricky_topic from static int to relationship
$quiz_array = ClipitQuiz::get_all(0, 0, "", true, true);
foreach($quiz_array as $quiz_id){
    $elgg_object = get_entity((int)$quiz_id);
    $tricky_topic = $elgg_object->get("tricky_topic");
    if(!empty($tricky_topic)){
        ClipitQuiz::set_properties((int)$quiz_id, array("tricky_topic" => (int)$tricky_topic));
    }
    $elgg_object->set("tricky_topic", null);
}