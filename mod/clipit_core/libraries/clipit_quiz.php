<?php namespace clipit\quiz;
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
        "clipit.quiz.list_properties",
        __NAMESPACE__."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_properties",
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
        "clipit.quiz.set_properties",
        __NAMESPACE__."\\set_properties",
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
        "clipit.quiz.create_quiz",
        __NAMESPACE__."\\create_quiz",
        array(
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "target" => array(
                 "type" => "string",
                 "required" => true),
             "description" => array(
                 "type" => "string",
                 "required" => false),
             "public" => array(
                 "type" => "bool",
                 "required" => false),
             "question_array" => array(
                 "type" => "array",
                 "required" => false),
             "result_array" => array(
                 "type" => "array",
                 "required" => false),
             "taxonomy" => array(
                 "type" => "int",
                 "required" => false),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => false),
             "video" => array(
                 "type" => "int",
                 "required" => false)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.delete_quiz",
        __NAMESPACE__."\\delete_quiz",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_all_quizzes",
        __NAMESPACE__."\\get_all_quizzes",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_quizzes_by_id",
        __NAMESPACE__."\\get_quizzes_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
}

function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitQuiz");
}

function get_properties($id, $prop_array){
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

function set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        throw(new \InvalidParameterException("ERROR: The length of prop_array and value_array must match."));
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

function create_quiz($name,
                     $target,
                     $description = null,
                     $public = null,
                     $question_array = null,
                     $result_array = null,
                     $taxonomy = null,
                     $taxonomy_tag_array = null,
                     $video = null){
    $quiz = new ClipitQuiz();
    $quiz->name = $name;
    $quiz->target = $target;
    if($description){
        $quiz->description = $description;
    }
    if($public){
        $quiz->public = (bool) $public;
    }
    if($question_array){
        foreach($question_array as $question){
            $quiz->addQuestion($question);
        }
    }
    if($result_array){
        foreach($result_array as $result){
            $quiz->addResult($result);
        }
    }
    if($taxonomy){
        $quiz->taxonomy = $taxonomy;
    }
    if($taxonomy_tag_array){
        foreach($taxonomy_tag_array as $taxonomy_tag){
            $quiz->addTaxonomyTag($taxonomy_tag);
        }
    }
    if($video){
        $quiz->video = $video;
    }
    return $quiz->save();
}

function delete_quiz($id){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    return $quiz->delete();
}

function get_all_quizzes($limit = 0){
    $elgg_object_array = elgg_get_entities(array('type' => 'object',
                                                 'subtype' => 'quiz',
                                                 'limit' => $limit));
    $quiz_array = array();
    $i = 0;
    foreach($elgg_object_array as $elgg_object){
        $quiz_array[$i] = new ClipitQuiz($elgg_object->guid);
        $i++;
    }
    return $quiz_array;
}

function get_quizzes_by_id($id_array){
    $quiz_array = array();
    for($i = 0; $i < count($id_array); $i++){
        $elgg_object = get_entity($id_array[$i]);
        if(!$elgg_object){
            $quiz_array[$i] = null;
            continue;
        }
        $quiz_array[$i] = new ClipitQuiz($elgg_object->guid);
    }
    return $quiz_array;
}