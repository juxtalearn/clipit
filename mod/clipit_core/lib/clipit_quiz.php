<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pablo
 * Date: 18/10/13
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */
function clipit_quiz_expose_functions(){
    expose_function("clipit.quiz.list_properties",
        "clipit_quiz_list_properties",
        null, "description", 'GET', false, true);
    expose_function("clipit.quiz.get_properties",
        "clipit_quiz_get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.quiz.set_properties",
        "clipit_quiz_set_roperties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true),
            "value_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
}

function clipit_quiz_list_properties(){
    return get_class_vars("ClipitQuiz");
}

function clipit_quiz_delete_quiz($id){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    return $quiz->delete();
}

function clipit_quiz_get_properties($id, $prop_array){
    $quiz = new ClipitQuiz($id);
    if(!$quiz){
        return false;
    }
    $value_array = array();
    for($i = 0; $i < count($prop_array); $i++){
        $value_array[$i] = $quiz->$prop_array[$i];
    }
    return array_combine($prop_array, $value_array);
}

function clipit_quiz_set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        return null;
    }
    $quiz = new ClipitQuiz($id);
    if(!$quiz){
        return null;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $quiz->$prop_array[$i] = $value_array[$i];
    }
    return $quiz->save();
}