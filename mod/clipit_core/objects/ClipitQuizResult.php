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
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggObject
 */
use \ElggObject;

/**
 * Class ClipitQuizResult
 *
 * @package clipit\quiz\result
 */
class ClipitQuizResult{
    /**
     * @const string Elgg entity type for this class
     */
    const TYPE = "object";
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_result";
    /**
     * @var int Unique Id of saved ClipitQuizResult (-1 = unsaved)
     */
    public $id = -1;
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
     * ClipitQuizResult constructor
     *
     * @param int|null $id If $id is null, create new instance; else load instance with id = $id.
     */
    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    /**
     * Loads a ClipitQuizResult instance from the system.
     *
     * @param int $id Id of Quiz Result to load
     * @return $this|bool Returns Quiz Question instance, or false if error
     */
    function load($id){
        if(!$elgg_object = new ElggObject((int) $id)){
            return null;
        }
        if($elgg_object->type != ClipitQuizResult::TYPE
           || get_subtype_from_id($elgg_object->subtype) != ClipitQuizResult::SUBTYPE){
            return null;
        }
        $this->id = (int) $elgg_object->guid;
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
     * @return bool|int Returns the Id of the saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string) ClipitQuizResult::SUBTYPE;
        } else{
            $elgg_object = new ElggObject((int) $this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->result_array = (array) $this->result_array;
        $elgg_object->correct = (bool) $this->correct;
        $elgg_object->quiz_question = (int) $this->quiz_question;
        $elgg_object->user = (int) $this->user;
        if(!$this->id = $elgg_object->save()){
            return false;
        }
        return true;
    }

    /**
     * Deletes a Quiz Result from the system
     *
     * @return bool True if success, false if error.
     */
    function delete(){
        if(!$elgg_object = get_Entity((int) $this->id)){
            return false;
        }
        return $elgg_object->delete();
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

}