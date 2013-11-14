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
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggObject
 */
use \ElggObject;
use pebs\PebsItem;

/**
 * Class ClipitQuiz
 *
 * @package clipit\quiz
 */
class ClipitQuiz extends PebsItem{
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
     * @return $this|bool Returns ClipitQuiz instance, or false if error.
     */
    function load($id){
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
        return $this->id = $elgg_object->save();
    }

    function setProperties($prop_value_array){
        foreach($prop_value_array as $prop => $value){
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
}