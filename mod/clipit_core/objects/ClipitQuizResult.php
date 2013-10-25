<?php namespace clipit\quiz\result;

    /**
     * JuxtaLearn ClipIt Web Space
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

// Alias so classes outside of this namespace can be used without path.
use \ElggObject as ElggObject;

/**
 * Class ClipitQuizResult
 *
 * @package clipit\quiz\result
 */
class ClipitQuizResult{
    // Class properties
    public $id = -1;
    public $result_array = array();
    public $correct = false;
    public $quiz = -1;
    public $quiz_question = -1;
    public $user = -1;
    public $time_created = -1;

    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    function load($id = null){
        $elgg_object = null;
        if($id){
            $elgg_object = new ElggObject($id);
        }
        if(!$elgg_object){
            return false;
        }
        $this->id = $elgg_object->guid;
        $this->result_array = $elgg_object->result_array;
        $this->correct = $elgg_object->correct;
        $this->quiz = $elgg_object->quiz;
        $this->quiz_question = $elgg_object->quiz_question;
        $this->user = $elgg_object->user;
        $this->time_created = $elgg_object->time_created;
        return $this;
    }

    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $this->id = $elgg_object->save();
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->result_array = $this->result_array;
        $elgg_object->correct = $this->correct;
        $elgg_object->quiz = $this->quiz;
        $elgg_object->quiz_question = $this->quiz_question;
        $elgg_object->user = $this->user;
        return $elgg_object->save();
    }

    function delete(){
        if(!$elgg_object = get_Entity($this->id)){
            return false;
        }
        return $elgg_object->delete();
    }

}