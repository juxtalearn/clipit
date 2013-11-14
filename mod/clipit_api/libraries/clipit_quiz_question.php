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
use clipit\taxonomy\tag\ClipitTaxonomyTag;

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties with type and default value
 */
function list_properties(){
    return ClipitQuizQuestion::listProperties();
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
    return $quiz_question->getProperties($prop_array);
}

/**
 * Set values to specified properties of a QuizQuestion.
 *
 * @param int $id Id from QuizQuestion
 * @param array $prop_value_array Array of properties => values to set
 * @return bool Returns true if success, false if error
 */
function set_properties($id, $prop_value_array){
    $quiz_question = new ClipitQuizQuestion($id);
    if(!$quiz_question){
        return false;
    }
    return $quiz_question->setProperties($prop_value_array);
}

/**
 * Create a new ClipitQuizQuestion instance, and save it into the system.
 *
 * @param string $name Name of the Quiz Question
 * @param string $description Quiz Question full description (optional)
 * @param array $option_array Array of Options presented to the user to choose from
 * @param string $option_type Type of Options (select 1 only, select 2, select any...)
 * @param array $taxonomy_tag_array Array of tags linking the question to the taxonomy (optional)
 * @param int $video Id of video to which the question relates to (optional)
 * @return bool|int Returns the new Quiz Question Id, or false if error
 */
function create($name,
                $description = "",
                $option_array,
                $option_type,
                $taxonomy_tag_array = array(),
                $video = -1){
    $prop_value_array["name"] = $name;
    $prop_value_array["description"] = $description;
    $prop_value_array["option_array"] = $option_array;
    $prop_value_array["option_type"] = $option_type;
    $prop_value_array["taxonomy_tag_array"] = $taxonomy_tag_array;
    $prop_value_array["video"] = $video;
    $quiz_question = new ClipitQuizQuestion();
    return $quiz_question->setProperties($prop_value_array);
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
 * Get all Quiz Questions from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (default)
 * @return array Returns an array of ClipitQuizQuestion objects
 */
function get_all($limit = 0){
    return ClipitQuizQuestion::getAll($limit);
}

/**
 * Get all Quizz Questions with Id contained in a given list.
 *
 * @param array $id_array Array of Quiz Question Ids
 * @return array Returns an array of ClipitQuizQuestion objects
 */
function get_by_id($id_array){
    return ClipitQuizQuestion::getById($id_array);
}

/**
 * Get all Quiz Results from a specified Quiz Question.
 *
 * @param int $id Id of Quiz Question to get Results form
 * @return array|bool Array of Quiz Results, or false if error
 */
function get_results($id){
    return $quiz_result_array = \clipit\quiz\result\get_from_question($id);
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
    if(!$quiz_question->taxonomy_tag_array){
        $quiz_question->taxonomy_tag_array = $taxonomy_tag_array;
    } else{
        $quiz_question->taxonomy_tag_array = array_merge($quiz_question->taxonomy_tag_array, $taxonomy_tag_array);
    }
    if(!$quiz_question->save()){
        return false;
    }
    return true;
}

/**
 * Remove a list of Tags from the Taxonomy from a Quiz Question.
 *
 * @param int $id Id of the Quiz Question
 * @param array $taxonomy_tag_array Array of Taxonomy Tags to remove from the Quiz Question
 * @return bool True if success, false if error
 */
function remove_taxonomy_tags($id, $taxonomy_tag_array){
    if(!$quiz_question = new ClipitQuizQuestion($id)){
        return false;
    }
    if(!$quiz_question->taxonomy_tag_array){
        return false;
    }
    foreach($taxonomy_tag_array as $taxonomy_tag){
        $key = array_search($taxonomy_tag, $quiz_question->taxonomy_tag_array);
        if(isset($key)){
            unset($quiz_question->taxonomy_tag_array[$key]);
        }else{
            return false;
        }
    }
    if(!$quiz_question->save()){
        return false;
    }
    return true;
}

/**
 * Get all Taxonomy Tags for a Quiz Question.
 *
 * @param int $id Id from the Quiz Question to get Taxonomy Tags from
 * @return array|bool Returns an array of Taxonomy Tag items, or false if error
 */
function get_taxonomy_tags($id){
    if(!$quiz_question = new ClipitQuizQuestion($id)){
        return false;
    }
    $taxonomy_tag_array = array();
    foreach($quiz_question->taxonomy_tag_array as $taxonomy_tag_id){
        if(!$taxonomy_tag = new ClipitTaxonomyTag($taxonomy_tag_id)){
            $taxonomy_tag_array[] = null;
        } else{
            $taxonomy_tag_array[] = $taxonomy_tag;
        }
    }
    return $taxonomy_tag_array;
}

