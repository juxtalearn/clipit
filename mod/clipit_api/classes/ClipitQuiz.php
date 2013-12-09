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
 * Class ClipitQuiz
 *
 * @package clipit
 */
class ClipitQuiz extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz";
    /**
     * @var string Target interface for Quiz display (e.g.: "web space", "large display"...)
     */
    public $target = "";
    /**
     * @var bool Specifies whether the Quiz can be reused by other teachers (optional, default = false)
     */
    public $public = false;
    /**
     * @var array Array of ClipitQuizQuestion ids (int) included in this Quiz (optional)
     */
    public $question_array = array();
    /**
     * @var int Id of Taxonomy used as topic for this Quiz (optional)
     */
    public $taxonomy = -1;

    /**
     * Loads a ClipitQuiz from the system.
     *
     * @param int $id IF of the ClipitQuiz to load from the system.
     * @return ClipitQuiz|bool Returns ClipitQuiz instance, or false if error.
     */
    protected function _load($id){
        if(!($elgg_object = new ElggObject((int) $id))){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int) $elgg_object->guid;
        $this->description = (string) $elgg_object->description;
        $this->name = (string) $elgg_object->name;
        $this->public = (bool)$elgg_object->public;
        $this->question_array = (array) $elgg_object->question_array;
        $this->taxonomy = (int) $elgg_object->taxonomy;
        $this->target = (string) $elgg_object->target;
        return $this;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)$this::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->public = (bool) $this->public;
        $elgg_object->question_array = (array) $this->question_array;
        $elgg_object->taxonomy = (int) $this->taxonomy;
        $elgg_object->target = (string) $this->target;
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    /**
     * Sets values into specified properties of the instance
     *
     * @param array $prop_value_array Array of prop=>value pairs to set into the instance
     * @return int Returns instance Id, or false if error
     * @throws InvalidParameterException
     */
    function setProperties($prop_value_array){
        foreach($prop_value_array as $prop => $value){
            if(!array_key_exists($prop, $this->list_properties())){
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }
            if($prop == "id"){
                throw new InvalidParameterException("ERROR: Cannot modify 'id' of instance.");
            }
            if($prop == "public"){
                $this->setPrivacy($value);
            } else{
                $this->$prop = $value;
            }
        }
        return $this->save();
    }

    /**
     * Set Quiz privacy into "public" property (true = public, false = private)
     *
     * @param string $value Flag specifying if the quiz is public or not
     */
    function setPrivacy($value){
        if($value == "true"){
            $this->public = true;
        } elseif($value == "false"){
            $this->public = false;
        } else{
            $this->public = (bool) $value;
        }
    }

    /**
     * Adds Quiz Questions to a Quiz.
     *
     * @param int $id Id from Quiz to add Questions to
     * @param array $question_array Array of Questions to add
     * @return bool Returns true if success, false if error
     */
    static function add_questions($id, $question_array){
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
    static function remove_questions($id, $question_array){
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
    static function get_questions($id){
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
}