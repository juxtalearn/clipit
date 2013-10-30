<?php
/**
 * @package clipit\quiz\result
 */
namespace clipit\quiz\result;

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
 * Alias so classes outside of this namespace can be used without path.
 * @use \clipit\quiz\ClipitQuiz
 */
use \clipit\quiz\ClipitQuiz;

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
        "clipit.quiz.result.create",
        __NAMESPACE__."\\create",
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
        "clipit.quiz.result.delete",
        __NAMESPACE__."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_all",
        __NAMESPACE__."\\get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.result.get_from_quiz",
        __NAMESPACE__."\\get_from_quiz",
        array(
             "quiz_id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties with type and default value
 */
function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitQuizResult");
}

/**
 * Get the values for the specified properties of a QuizResult.
 *
 * @param int $id Id from QuizResult
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of [property => value] pairs, or false if error.
 * If a property does not exist, the returned array will show null as that propertie's value.
 */
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

/**
 * Set values to specified properties of a QuizResult.
 *
 * @param int $id Id from QuizResult
 * @param array $prop_array Array of properties to set values into
 * @param array $value_array Array of associated values to set into properties
 * @return bool Returns true if success, false if error
 * @throws \InvalidParameterException If count(prop_array) != count(value_array)
 */
function set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        throw(new \InvalidParameterException(
            "ERROR: The length of prop_array and value_array must match."));
    }
    $quiz_result = new ClipitQuizResult($id);
    if(!$quiz_result){
        return false;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $quiz_result->$prop_array[$i] = $value_array[$i];
    }
    if(!$quiz_result->save()){
        return false;
    }
    return true;
}

/**
 * Create a new ClipitQuizResult instance, and save it into the system.
 *
 * @param int $quiz_question Id of the Quiz Question this Result refers to
 * @param array $result_array Array with the Result elements posted by a user
 * @param int $user Id of the user who posted the result
 * @param bool $correct If true: the result is correct, if false: the result is incorrect (optional)
 * @return bool|int Returns Returns the new Quiz Result Id, or false if error
 */
function create($quiz_question,
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

/**
 * Delete a Quiz Result from the system.
 *
 * @param int $id Id from the Quiz Result to delete
 * @return bool True if success, false if error
 */
function delete($id){
    if(!$quiz_result = new ClipitQuizResult($id)){
        return false;
    }
    return $quiz_result->delete();
}

/**
 * Get all Quiz Results from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (default)
 * @return array Returns an array of ClipitQuizQuestion objects
 */
function get_all($limit = 0){
    $quiz_result_array = array();
    $elgg_object_array = elgg_get_entities(array('type' => 'object',
                                                 'subtype' => ClipitQuizResult::SUBTYPE,
                                                 'limit' => $limit));
    if(!$elgg_object_array){
        return $quiz_result_array;
    }
    $i = 0;
    foreach($elgg_object_array as $elgg_object){
        $quiz_result_array[$i] = new ClipitQuizResult($elgg_object->guid);
        $i++;
    }
    return $quiz_result_array;
}

/**
 * Get all Quiz Results from a specified Quiz.
 *
 * @param int $quiz_id Id of quiz to get Results form
 * @return array|bool Array of Quiz Results, or false if error
 */
function get_from_quiz($quiz_id){
    if(!$quiz = new ClipitQuiz($quiz_id)){
        return false;
    }
    $quiz_result_array = array();
    $i = 0;
    foreach($quiz->result_array as $quiz_result_id){
        if(!$quiz_result = new ClipitQuizResult($quiz_result_id)){
            $quiz_result_array[$i] = null;
        } else{
            $quiz_result_array[$i] = $quiz_result;
        }
        $i++;
    }
    return $quiz_result_array;
}