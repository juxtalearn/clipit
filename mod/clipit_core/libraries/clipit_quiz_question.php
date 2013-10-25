<?php namespace clipit\quiz\question;
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
     *                  published by the Free Software Foundation, version 3. *
     *                  This program is distributed in the hope that it will be useful,
     *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     *                  GNU Affero General Public License for more details. *
     *                  You should have received a copy of the GNU Affero General Public License
     *                  along with this program. If not, see
     *                  http://www.gnu.org/licenses/agpl-3.0.txt.
     */

/**
 * Expose libraty functions to REST API.
 */
function expose_functions(){
    expose_function(
        "clipit.quiz.question.list_properties",
        __NAMESPACE__."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_properties",
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
        "clipit.quiz.question.set_properties",
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
}

function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitQuizQuestion");
}

function delete_quiz_question($id){
    if(!$quiz_question = new ClipitQuizQuestion($id)){
        return false;
    }
    return $quiz_question->delete();
}

function get_properties($id, $prop_array){
    $quiz_question = new ClipitQuizQuestion($id);
    if(!$quiz_question){
        return false;
    }
    $value_array = array();
    for($i = 0; $i < count($prop_array); $i++){
        $value_array[$i] = $quiz_question->$prop_array[$i];
    }
    return array_combine($prop_array, $value_array);
}

function set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        return null;
    }
    $quiz_question = new ClipitQuizQuestion($id);
    if(!$quiz_question){
        return null;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $quiz_question->$prop_array[$i] = $value_array[$i];
    }
    return $quiz_question->save();
}