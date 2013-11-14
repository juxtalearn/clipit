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
 * @use clipit\quiz\question\ClipitQuizQuestion as ClipitQuizQuestion
 */
use clipit\quiz\question\ClipitQuizQuestion;

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties whith type and default value
 */
function list_properties(){
    return ClipitQuiz::listProperties();
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
    return $quiz->getProperties($prop_array);
}

/**
 * Set values to specified properties of a Quiz.
 *
 * @param int $id Id from Quiz
 * @param array $prop_value_array Array of properties => values to set
 * @return bool Returns true if success, false if error
 */
function set_properties($id, $prop_value_array){
    $quiz = new ClipitQuiz($id);
    if(!$quiz){
        return false;
    }
    return $quiz->setProperties($prop_value_array);
}

/**
 * Create a new ClipitQuiz instance, and save it into the system.
 *
 * @param string $name Name of the Quiz
 * @param string $target Target interface to present Quiz (web space, large display, etc.)
 * @param string $description Quiz full description (optional)
 * @param bool $public Whether the Quiz can be reused by other teachers (true= yes, false= no)
 * @param array $question_array Array of ClipitQuizQuestions contained in this Quiz (optional)
 * @param int $taxonomy Id of the Taxonomy referenced by this Quiz (optional)
 * @return bool|int Returns the new Quiz Id, or false if error
 */
function create($name,
                $target,
                $description = "",
                $public = false,
                $question_array = array(),
                $taxonomy = -1){
    $prop_value_array["name"] = $name;
    $prop_value_array["target"] = $target;
    $prop_value_array["description"] = $description;
    $prop_value_array["public"] = $public;
    $prop_value_array["question_array"] = $question_array;
    $prop_value_array["taxonomy"] = $taxonomy;
    $quiz = new ClipitQuiz();
    return $quiz->setProperties($prop_value_array);
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
 * Get all Quizzes from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (optional)
 * @return array Returns an array of ClipitQuiz objects
 */
function get_all($limit = 0){
    return ClipitQuiz::getAll($limit);
}

/**
 * Get Quizzes with id contained in a given list.
 *
 * @param array $id_array Array of Quiz Ids
 * @return array Returns an array of ClipitQuiz objects
 */
function get_by_id($id_array){
    return ClipitQuiz::getById($id_array);
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
        $quiz->question_array = array_merge($quiz->question_array, $question_array);
    }
    if(!$quiz->save()){
        return false;
    }
    return true;
}

/**
 * Remove Quiz Questions from a Quiz.
 *
 * @param int $id Id from Quiz to remove Questions from
 * @param array $question_array Array of Questions to remove
 * @return bool Returns true if success, false if error
 */
function remove_questions($id, $question_array){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    if(!$quiz->question_array){
        return false;
    }
    foreach($question_array as $question){
        $key = array_search($question, $quiz->question_array);
        if(isset($key)){
            unset($quiz->question_array[$key]);
        } else{
            return false;
        }
    }
    if(!$quiz->save()){
        return false;
    }
    return true;
}

/**
 * Get an array of Quiz Questions included in a Quiz.
 *
 * @param int $id The Id of the Quiz to get questions from
 * @return array|bool Returns an array of ClipitQuizQuestion objects, or false if error
 */
function get_questions($id){
    if(!$quiz = new ClipitQuiz($id)){
        return false;
    }
    $quiz_question_array = array();
    foreach($quiz->question_array as $quiz_question_id){
        if(!$quiz_question = new ClipitQuizQuestion($quiz_question_id)){
            $quiz_question_array[] = null;
        } else{
            $quiz_question_array[] = $quiz_question;
        }
    }
    return $quiz_question_array;
}