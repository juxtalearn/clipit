<?php namespace clipit\quiz;

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
 * Class ClipitQuiz
 *
 * @package clipit\quiz
 */
class ClipitQuiz{
    /**
     * @const string Subtype of the ClipitQuiz class for ElggObject
     */
    const SUBTYPE = "quiz";
    /**
     * @var int Unique Id of saved ClipitQuiz (-1 = unsaved)
     */
    public $id = -1;
    /**
     * @var string Quiz name
     */
    public $name = "";
    /**
     * @var string Target interface for Quiz display (e.g.: "web space", "large display"...)
     */
    public $target = "";
    /**
     * @var string Quiz description free text (optional)
     */
    public $description = "";
    /**
     * @var bool Specifies whether the Quiz can be reused by other teachers (optional, default = false)
     */
    public $public = false;
    /**
     * @var array Array of ClipitQuizQuestion ids (int) included in this Quiz
     */
    public $question_array = array();
    /**
     * @var array Array of ClipitQuizResult ids (int) included in this Quiz
     */
    public $result_array = array();
    /**
     * @var null Taxonomy used as topic for this Quiz
     */
    public $taxonomy = null;

    /**
     * ClipitQuiz constructor
     *
     * @param int|null $id If $id is null then create new instance, else load instance with id = $id.
     */
    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    /**
     * Loads a ClipitQuiz from the system.
     *
     * @param int $id IF of the ClipitQuiz to load from the system.
     * @return $this|bool Returns ClipitQuiz instance, or false if error.
     */
    function load($id = null){
        $elgg_object = null;
        if($id){
            $elgg_object = new ElggObject($id);
        }
        if(!$elgg_object){
            return false;
        }
        $this->id = $elgg_object->guid;
        $this->description = $elgg_object->description;
        $this->name = $elgg_object->name;
        $this->public = (bool)$elgg_object->public;
        $this->question_array = $elgg_object->question_array;
        $this->result_array = $elgg_object->result_array;
        $this->taxonomy = $elgg_object->taxonomy;
        $this->target = $elgg_object->target;
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
            $elgg_object->subtype = $this::SUBTYPE;
            $this->id = $elgg_object->save();
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->description = $this->description;
        $elgg_object->name = $this->name;
        $elgg_object->public = (bool)$this->public;
        $elgg_object->question_array = $this->question_array;
        $elgg_object->result_array = $this->result_array;
        $elgg_object->taxonomy = $this->taxonomy;
        $elgg_object->target = $this->target;
        return $elgg_object->save();
    }

    /**
     * Deletes a quiz from the system.
     *
     * @return bool True if success, false if error.
     */
    function delete(){
        if(!$elgg_object = get_Entity($this->id)){
            return false;
        }
        return $elgg_object->delete();
    }
}