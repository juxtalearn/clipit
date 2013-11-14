<?php
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
namespace clipit\quiz\question;



/**
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggObject
 */
use \ElggObject;
use pebs\PebsItem;
use clipit\quiz\result\ClipitQuizResult;
use clipit\taxonomy\tag\ClipitTaxonomyTag;


/**
 * Class ClipitQuizQuestion
 *
 * @package clipit\quiz\question
 */
class ClipitQuizQuestion extends PebsItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_question";
    /**
     * @var array Array of options to chose from as an answer to the question
     */
    public $option_array = array();
    /**
     * @var string Type of Question: single choice, multiple choice, select 2...
     */
    public $option_type = "";
    /**
     * @var array Array of Taxonomy Tags relevant to this question
     */
    public $taxonomy_tag_array = array();
    /**
     * @var int ID of ClipitVideo refered to by this question (optional)
     */
    public $video = -1;

    /**
     * Loads a ClipitQuizQuestion instance from the system.
     *
     * @param int $id Id of the ClipitQuiz to load from the system.
     * @return $this|bool Returns ClipitQuiz instance, or false if error.
     */
    protected function _load($id){
        if(!$elgg_object = new ElggObject((int) $id)){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int) $elgg_object->guid;
        $this->name = (string) $elgg_object->name;
        $this->description = (string) $elgg_object->description;
        $this->option_array = (array) $elgg_object->option_array;
        $this->taxonomy_tag_array = (array) $elgg_object->taxonomy_tag_array;
        $this->option_type = (string) $elgg_object->option_type;
        $this->video = (int) $elgg_object->video;
        return $this;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string) $this::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->option_array = (array) $this->option_array;
        $elgg_object->taxonomy_tag_array = (array) $this->taxonomy_tag_array;
        $elgg_object->option_type = (string) $this->option_type;
        $elgg_object->video = (int) $this->video;
        return $this->id = $elgg_object->save();
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
    static function create($name,
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
     * Get all Quiz Results from a specified Quiz Question.
     *
     * @param int $id Id of Quiz Question to get Results form
     * @return array|bool Array of Quiz Results, or false if error
     */
    static function get_results($id){
        return $quiz_result_array = ClipitQuizResult::get_from_question($id);
    }


    /**
     * Add a list of Tags from the Taxonomy to a Quiz Question.
     *
     * @param int $id Id of the Quiz Question
     * @param array $taxonomy_tag_array Array of Taxonomy Tags to add to the Quiz Question
     * @return bool True if success, false if error
     */
    static function add_taxonomy_tags($id, $taxonomy_tag_array){
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
    static function remove_taxonomy_tags($id, $taxonomy_tag_array){
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
    static function get_taxonomy_tags($id){
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
}