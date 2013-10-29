<?php namespace clipit\quiz\result;
    /**
     * ClipIt - JuxtaLearn Web Space
     * PHP version:     >= 5.2
     * Creation date:   2013-10-10
     * Last update:     $Date$
     *
     * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://juxtalearn.org
     * @license         GNU Affero General Public License v3
     *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
     *                  This program is free software: you can redistribute it and/or modify
     *                  it under the terms of the GNU Affero General Public License as
     *                  published by the Free Software Foundation, version 3.
     *                  This program is distributed in the hope that it will be useful,
     *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     *                  GNU Affero General Public License for more details.
     *                  You should have received a copy of the GNU Affero General Public License
     *                  along with this program. If not, see
     *                  http://www.gnu.org/licenses/agpl-3.0.txt.
     */

/**
 * Expose libraty functions to REST API.
 */
function expose_functions(){
    expose_function(
        "clipit.quiz.result.list_properties",
        __NAMESPACE__."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_properties",
        __NAMESPACE__."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.set_properties",
        __NAMESPACE__."\\set_roperties",
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
    expose_function(
        "clipit.quiz.create_quiz_result",
        __NAMESPACE__."\\create_quiz_result",
        array(
             "quiz_question" => array(
                 "type" => "int",
                 "required" => true),
             "result_array" => array(
                 "type" => "array",
                 "required" => true),
             "user" => array(
                 "type" => "int",
                 "required" => true),
             "correct" => array(
                 "type" => "bool",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.delete_quiz_result",
        __NAMESPACE__."\\delete_quiz_result",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
}

function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitQuizResult");
}

function get_properties($id, $prop_array){
    $quiz_result = new ClipitQuizResult($id);
    if(!$quiz_result){
        return false;
    }
    $value_array = array();
    for($i = 0; $i < count($prop_array); $i++){
        $value_array[$i] = $quiz_result->$prop_array[$i];
    }
    return array_combine($prop_array, $value_array);
}

function set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        throw(new \InvalidParameterException(
            "ERROR: The length of prop_array and value_array must match."));
    }
    $quiz_result = new ClipitQuizResult($id);
    if(!$quiz_result){
        return null;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $quiz_result->$prop_array[$i] = $value_array[$i];
    }
    if(!$quiz_result->save()){
        return false;
    }
    return true;
}

function create_quiz_result($quiz_question,
                            $result_array,
                            $user,
                            $correct = null){
    $quiz_result = new ClipitQuizResult();
    $quiz_result->quiz_question = $quiz_question;
    $quiz_result->result_array = $result_array;
    $quiz_result->user = $user;
    if($correct){
        $quiz_result->$correct;
    }
    return $quiz_result->save();
}

function delete_quiz_result($id){
    if(!$quiz_result = new ClipitQuizResult($id)){
        return false;
    }
    return $quiz_result->delete();
}