<?php
/**
 * @package clipit\quiz
 */
namespace clipit\quiz;

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
        "clipit.quiz.create",
        __NAMESPACE__."\\create",
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
             "taxonomy" => array(
                 "type" => "int",
                 "required" => false)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.quiz.delete",
        __NAMESPACE__."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_all",
        __NAMESPACE__."\\get_all",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.get_by_id",
        __NAMESPACE__."\\get_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.add_questions",
        __NAMESPACE__."\\add_questions",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "question_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
}

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties whith type and default value
 */
function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitQuiz");
}

/**
 * Get the values for the specified properties of a Quiz.
 *
 * @param int $id Id from Quiz
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of [property => value] pairs, or false if error.
 * If a property does not exist, the returned array will show null as that propertie's value.
 */
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

/**
 * Set values to specified properties of a Quiz.
 *
 * @param int $id Id from Quiz
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
    $quiz = new ClipitQuiz($id);
    if(!$quiz){
        return false;
    }
    for($i = 0; $i < count($prop_array); $i++){
        if($prop_array[$i] == "public"){
            $quiz->setPrivacy($value_array[$i]);
        } else{
            $quiz->$prop_array[$i] = $value_array[$i];
        }
    }
    if(!$quiz->save()){
        return false;
    }
    return true;
}

/**
 * Create a new ClipitQuiz instance, and save it into the system.
 *
 * @param string $name Name of the Quiz
 * @param string $target Target interface to present Quiz (web space, large display, etc.)
 * @param string $description Quiz full description (optional)
 * @param bool $public Whether the Quiz can be reused by other teachers (true= yes, false= no)
 * @param array $question_array Array of ClipitQuizQuestions contained in this Quiz (optional)
 * @param array $result_array Array of ClipitQuizResults submitted for this Quiz (optional)
 * @param int $taxonomy Id of the Taxonomy referenced by this Quiz (optional)
 * @return bool|int Returns the new Quiz Id, or false if error
 */
function create($name,
                $target,
                $description = "",
                $public = false,
                $question_array = array(),
                $result_array = array(),
                $taxonomy = -1){
    $quiz = new ClipitQuiz();
    $quiz->name = $name;
    $quiz->target = $target;
    $quiz->description = $description;
    $quiz->setPrivacy($public);
    $quiz->question_array = $question_array;
    $quiz->result_array = $result_array;
    $quiz->taxonomy = $taxonomy;
    return $quiz->save();
}

/**
 * Delete a Quiz from the system.
 *
 * @param int $id If from the Quiz to delete
 * @return bool True if success, false if error
 */
function delete($id){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    return $quiz->delete();
}

/**
 * Adds Quiz Questions to a Quiz.
 *
 * @param int $id Id from Quiz to add Questions to
 * @param array $question_array Array of Questions to add
 * @return bool Returns true if success, false if error
 */
function add_questions($id, $question_array){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    if(!$quiz->question_array){
        $quiz->question_array = $question_array;
    } else{
        array_merge($quiz->question_array, $question_array);
    }
    if(!$quiz->save()){
        return false;
    }
    return true;
}


/**
 * Get all quizzes from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (default)
 * @return array Returns an array of ClipitQuiz objects
 */
function get_all($limit = 0){
    $quiz_array = array();
    $elgg_object_array = elgg_get_entities(array('type' => ClipitQuiz::TYPE,
                                                 'subtype' => ClipitQuiz::SUBTYPE,
                                                 'limit' => $limit));
    if(!$elgg_object_array){
        return $quiz_array;
    }
    $i = 0;
    foreach($elgg_object_array as $elgg_object){
        $quiz_array[$i] = new ClipitQuiz($elgg_object->guid);
        $i++;
    }
    return $quiz_array;
}

/**
 * Get Quizzes with Id contained in a given list.
 *
 * @param array $id_array Array of Quiz Ids
 * @return array Returns an array of ClipitQuiz objects
 */
function get_by_id($id_array){
    $quiz_array = array();
    $i = 0;
    foreach($id_array as $id){
        if(elgg_entity_exists($id)){
            $quiz_array[$i] = new ClipitQuiz((int) $id);
        } else{
            $quiz_array[$i] = null;
        }
        $i++;
    }
    return $quiz_array;
}

function get_quiz_questions($id){
    if(!$quiz = new Clipitquiz($id)){
        return false;
    }
    $quiz_question_array = array();
    foreach($quiz->question_array as $question_id){
        array_push($quiz_question_array, new question\ClipitQuizQuestion($question_id));
    }
    return $quiz_question_array;
}