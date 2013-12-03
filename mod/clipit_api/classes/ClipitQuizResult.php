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
 * Class ClipitQuizResult
 *
 * @package clipit
 */
class ClipitQuizResult extends PebsItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_result";
    /**
     * @var int Id of ClipitQuizQuestion this ClipitQuizResult is related to
     */
    public $quiz_question = -1;
    /**
     * @var array Array of results to the Quiz Question linked by $quiz_question
     */
    public $result_array = array();
    /**
     * @var int Id of User who posted this Quiz Result
     */
    public $user = -1;
    /**
     * @var bool Determines if this Result is correct (true) or incorrect (false)
     */
    public $correct = false;
    /**
     * @var int Timestamp when the user submitted this Quiz Result
     */
    public $time_created = -1;

    /**
     * Loads a ClipitQuizResult instance from the system.
     *
     * @param int $id Id of Quiz Result to load
     * @return ClipitQuizResult|null Returns Quiz Question instance, or null if error
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
        $this->result_array = (array) $elgg_object->result_array;
        $this->correct = (bool) $elgg_object->correct;
        $this->quiz_question = (int) $elgg_object->quiz_question;
        $this->user = (int) $elgg_object->user;
        $this->time_created = (int) $elgg_object->time_created;
        return $this;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
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
        $elgg_object->result_array = (array) $this->result_array;
        $elgg_object->correct = (bool) $this->correct;
        $elgg_object->quiz_question = (int) $this->quiz_question;
        $elgg_object->user = (int) $this->user;
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
            if($prop == "correct"){
                $this->setCorrect($value);
            } else{
                $this->$prop = $value;
            }
        }
        return $this->save();
    }

    /**
     * Set Quiz Result Correct flag into "correct" property (true = yes, false = no)
     *
     * @param string $value Flag specifying if the Quiz Result is correct or not
     */
    function setCorrect($value){
        if($value =="true"){
            $this->correct = true;
        } elseif($value == "false"){
            $this->correct = false;
        } else{
            $this->correct = (bool) $value;
        }
    }

    /**
     * Get Quiz Results by Quiz Questions
     *
     * @param array $quiz_question_array Array of Quiz Question IDs to get Results form
     * @return array|bool Array of nested arrays per question with Quiz Results, or false if error
     */
    static function get_by_question($quiz_question_array){
        $quiz_result_array = array();
        foreach($quiz_question_array as $quiz_question_id){
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
            $temp_array = array();
            foreach($elgg_object_array as $elgg_object){
                $temp_array[] =  new ClipitQuizResult($elgg_object->guid);
            }
            if(!$temp_array){
                $quiz_result_array[] = null;
            } else{
                $quiz_result_array[] = $temp_array;
            }
        }
        return $quiz_result_array;
    }

}