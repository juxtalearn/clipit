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
                $correct = false){
    $quiz_result = new ClipitQuizResult();
    $quiz_result->quiz_question = $quiz_question;
    $quiz_result->result_array = $result_array;
    $quiz_result->user = $user;
    $quiz_result->setCorrect($correct);
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
 * @param int $limit Number of results to show, default= 0 [no limit] (optional)
 * @return array Returns an array of ClipitQuizQuestion objects
 */
function get_all($limit = 0){
    $quiz_result_array = array();
    $elgg_object_array = elgg_get_entities(array('type' => ClipitQuizResult::TYPE,
                                                 'subtype' => ClipitQuizResult::SUBTYPE,
                                                 'limit' => $limit));
    if(!$elgg_object_array){
        return $quiz_result_array;
    }
    foreach($elgg_object_array as $elgg_object){
        array_push($quiz_result_array, new ClipitQuizResult($elgg_object->guid));
    }
    return $quiz_result_array;
}

/**
 * Get all Quiz Results from a specified Quiz Question.
 *
 * @param int $quiz_question_id Id of Quiz Question to get Results form
 * @param int $limit Number of results to show, default = 0 [no limit] (optional)
 * @return array|bool Array of Quiz Results, or false if error
 */
function get_from_question($quiz_question_id, $limit = 0){
    $quiz_result_array = array();
    $elgg_object_array = elgg_get_entities(array("type" => ClipitQuizResult::TYPE,
                                                 "subtype" => ClipitQuizResult::SUBTYPE,
                                                 "limit" => $limit));
    if(!$elgg_object_array){
        return $quiz_result_array;
    }
    foreach($elgg_object_array as $elgg_object){
        if((int) $elgg_object->quiz_question == (int) $quiz_question_id){
            array_push($quiz_result_array, new ClipitQuizResult($elgg_object->guid));
        }
    }
    return $quiz_result_array;
}

/**
 * Get all Quizz Results with Id contained in a given list.
 *
 * @param array $id_array Array of Quiz Result Ids
 * @return array Returns an array of ClipitQuizResult objects
 */
function get_by_id($id_array){
    $quiz_result_array = array();
    $i = 0;
    foreach($id_array as $id){
        if(elgg_entity_exists((int) $id)){
            $quiz_result_array[$i] = new ClipitQuizResult((int) $id);
        } else{
            $quiz_result_array[$i] = null;
        }
        $i++;
    }
    return $quiz_result_array;
}

