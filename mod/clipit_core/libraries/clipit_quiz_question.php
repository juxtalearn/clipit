<?php
/**
 * @package clipit\quiz\question
 */
namespace clipit\quiz\question;

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
        "clipit.quiz.question.create",
        __NAMESPACE__."\\create",
        array(
             "question" => array(
                 "type" => "string",
                 "required" => true),
             "option_array" => array(
                 "type" => "array",
                 "required" => true),
             "type" => array(
                 "type" => "string",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => false),
             "video" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.delete",
        __NAMESPACE__."\\delete",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.add_taxonomy_tags",
        __NAMESPACE__."\\add_taxonomy_tags",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "taxonomy_tag_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_all",
        __NAMESPACE__."\\get_all",
        array(
             "limit" => array(
                 "type" => "int",
                 "required" => false)),
        "description", 'GET', false, true);
    expose_function(
        "clipit.quiz.question.get_from_quiz",
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
    return get_class_vars(__NAMESPACE__."\\ClipitQuizQuestion");
}

/**
 * Get the values for the specified properties of a QuizQuestion.
 *
 * @param int $id Id from QuizQuestion
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of [property => value] pairs, or false if error.
 * If a property does not exist, the returned array will show null as that propertie's value.
 */
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

/**
 * Set values to specified properties of a QuizQuestion.
 *
 * @param int $id Id from QuizQuestion
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
    $quiz_question = new ClipitQuizQuestion($id);
    if(!$quiz_question){
        return false;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $quiz_question->$prop_array[$i] = $value_array[$i];
    }
    if(!$quiz_question->save()){
        return false;
    }
    return true;
}

/**
 * Create a new ClipitQuizQuestion instance, and save it into the system.
 *
 * @param string $question Question in text form to be presented to the user taking the quiz
 * @param array $option_array Array of options presented to the user to choose from
 * @param string $type Type of answer to be given (select 1 only, select 2, select any...)
 * @param array $taxonomy_tag_array Array of tags linking the question to the taxonomy (optional)
 * @param int $video Id of video to which the question relates to (optional)
 * @return bool|int Returns the new Quiz Question Id, or false if error
 */
function create($question,
                $option_array,
                $type,
                $taxonomy_tag_array = null,
                $video = null){
    $quiz_question = new ClipitQuizQuestion();
    $quiz_question->question = $question;
    $quiz_question->option_array = $option_array;
    $quiz_question->type = $type;
    if($taxonomy_tag_array){
        $quiz_question->taxonomy_tag_array = $taxonomy_tag_array;
    }
    if($video){
        $quiz_question->video = $video;
    }
    return $quiz_question->save();
}

/**
 * Delete a Quiz Question from the system.
 *
 * @param int $id Id from the Quiz Question to delete
 * @return bool True if success, false if error
 */
function delete($id){
    if(!$quiz_question = new ClipitQuizQuestion($id)){
        return false;
    }
    return $quiz_question->delete();
}

/**
 * Add a list of Tags from the Taxonomy to a Quiz Question.
 *
 * @param int $id Id of the Quiz Question
 * @param array $taxonomy_tag_array Array of Taxonomy Tags to add to the Quiz Question
 * @return bool True if success, false if error
 */
function add_taxonomy_tags($id, $taxonomy_tag_array){
    if(!$quiz_question = new ClipitQuizQuestion($id)){
        return false;
    }
    array_merge($quiz_question->taxonomy_tag_array, $taxonomy_tag_array);
    return true;
}

/**
 * Get all Quiz Questions from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (default)
 * @return array Returns an array of ClipitQuizQuestion objects
 */
function get_all($limit = 0){
    $quiz_question_array = array();
    $elgg_object_array = elgg_get_entities(array('type' => 'object',
                                                 'subtype' => ClipitQuizQuestion::SUBTYPE,
                                                 'limit' => $limit));
    if(!$elgg_object_array){
        return $quiz_question_array;
    }
    $i = 0;
    foreach($elgg_object_array as $elgg_object){
        $quiz_question_array[$i] = new ClipitQuizQuestion($elgg_object->guid);
        $i++;
    }
    return $quiz_question_array;
}

/**
 * Get all Quiz Questions from a specified Quiz.
 *
 * @param int $quiz_id Id of quiz to get Questions form
 * @return array|bool Array of Quiz Questions, or false if error
 */
function get_from_quiz($quiz_id){
    if(!$quiz = new ClipitQuiz($quiz_id)){
        return false;
    }
    $quiz_question_array = array();
    $i = 0;
    foreach($quiz->question_array as $quiz_question_id){
        if(!$quiz_question = new ClipitQuizQuestion($quiz_question_id)){
            $quiz_question_array[$i] = null;
        } else{
            $quiz_question_array[$i] = $quiz_question;
        }
        $i++;
    }
    return $quiz_question_array;
}