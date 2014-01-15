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

/**
 * Class ClipitQuizQuestion
 *
 * @package clipit
 */
class ClipitQuizQuestion extends UBItem{
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
     * @var array Array of Stumbling Block Tags relevant to this question
     */
    public $tag_array = array();
    /**
     * @var int ID of ClipitVideo refered to by this question (optional)
     */
    public $video = -1;

    /**
     * Loads a ClipitQuizQuestion instance from the system.
     *
     * @param int $id Id of the ClipitQuiz to load from the system.
     * @return ClipitQuizQuestion|bool Returns ClipitQuiz instance, or false if error.
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
        $this->tag_array = (array) $elgg_object->tag_array;
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
        $elgg_object->tag_array = (array) $this->tag_array;
        $elgg_object->option_type = (string) $this->option_type;
        $elgg_object->video = (int) $this->video;
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    /**
     * Get all Quiz Results from a specified Quiz Question.
     *
     * @param int $id Id of Quiz Question to get Results form
     * @return array|bool Array of Quiz Results, or false if error
     */
    static function get_results($id){
        $quiz_result_array = ClipitQuizResult::get_by_question(array($id));
        return array_pop($quiz_result_array);
    }


    /**
     * Add a list of Stumbling Block Tags to a Quiz Question.
     *
     * @param int $id Id of the Quiz Question
     * @param array $tag_array Array of Stumbling Block Tags to add to the Quiz Question
     * @return bool True if success, false if error
     */
    static function add_tags($id, $tag_array){
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        if(!$quiz_question->tag_array){
            $quiz_question->tag_array = $tag_array;
        } else{
            $quiz_question->tag_array = array_merge($quiz_question->tag_array, $tag_array);
        }
        if(!$quiz_question->save()){
            return false;
        }
        return true;
    }

    /**
     * Remove a list of Stumbling Block Tags from a Quiz Question.
     *
     * @param int $id Id of the Quiz Question
     * @param array $tag_array Array of Stumbling Block Tags to remove from the Quiz Question
     * @return bool True if success, false if error
     */
    static function remove_tags($id, $tag_array){
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        if(!$quiz_question->tag_array){
            return false;
        }
        foreach($tag_array as $tag){
            $key = array_search($tag, $quiz_question->tag_array);
            if(isset($key)){
                unset($quiz_question->tag_array[$key]);
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
     * Get all Stumbling Block Tags for a Quiz Question.
     *
     * @param int $id Id from the Quiz Question to get Stumbling Block Tags from
     * @return array|bool Returns an array of Stumbling Block Tag items, or false if error
     */
    static function get_tags($id){
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        return $quiz_question->tag_array;
    }
}