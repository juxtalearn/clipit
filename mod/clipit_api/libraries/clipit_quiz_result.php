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
    return ClipitQuizResult::listProperties();
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
    return $quiz_result->getProperties($prop_array);
}

/**
 * Set values to specified properties of a QuizResult.
 *
 * @param int $id Id from QuizResult
 * @param array $prop_value_array Array of properties => values to set
 * @return bool Returns true if success, false if error
 */
function set_properties($id, $prop_value_array){
    $quiz_result = new ClipitQuizResult($id);
    if(!$quiz_result){
        return false;
    }
    return $quiz_result->setProperties($prop_value_array);
}

/**
 * Create a new ClipitQuizResult instance, and save it into the system.
 *
 * @param string $name Name of the Quiz Result
 * @param string $description Quiz Result full description (optional)
 * @param int $quiz_question Id of the Quiz Question this Result refers to
 * @param array $result_array Array with the Result elements posted by a user
 * @param int $user Id of the user who posted the result
 * @param bool $correct If true: the result is correct, if false: the result is incorrect (optional)
 * @return bool|int Returns Returns the new Quiz Result Id, or false if error
 */
function create($name,
                $description = "",
                $quiz_question,
                $result_array,
                $user,              // USAR EL CAMPO $name PARA EL $user??
                $correct = false){
    $prop_value_array["name"] = $name;
    $prop_value_array["description"] = $description;
    $prop_value_array["quiz_question"] = $quiz_question;
    $prop_value_array["result_array"] = $result_array;
    $prop_value_array["user"] = $user;
    $prop_value_array["correct"] = $correct;
    $quiz_result = new ClipitQuizResult();
    return $quiz_result->setProperties($prop_value_array);
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
    return ClipitQuizResult::getAll($limit);
}

/**
 * Get all Quizz Results with Id contained in a given list.
 *
 * @param array $id_array Array of Quiz Result Ids
 * @return array Returns an array of ClipitQuizResult objects
 */
function get_by_id($id_array){
    return ClipitQuizResult::getById($id_array);
}


/**
 * Get all Quiz Results from a specified Quiz Question.
 *
 * @param int $quiz_question_id Id of Quiz Question to get Results form
 * @return array|bool Array of Quiz Results, or false if error
 */
function get_from_question($quiz_question_id){
    $quiz_result_array = array();
    $elgg_object_array = elgg_get_entities_from_metadata(
        array(
             "type" => ClipitQuizResult::TYPE,
             "subtype" => ClipitQuizResult::SUBTYPE,
             "metadata_names" => array("quiz_question"),
             "metadata_values" => array($quiz_question_id)
             )
    );
    if(!$elgg_object_array){
        return $quiz_result_array;
    }
    foreach($elgg_object_array as $elgg_object){
        $quiz_result_array[] =  new ClipitQuizResult($elgg_object->guid);
    }
    return $quiz_result_array;
}

