<?php namespace clipit\quiz;
/**
 * JuxtaLearn ClipIt Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Class ClipitQuiz
 * @package clipit\quiz
 */
class ClipitQuiz{

    // Class properties
    public $description = "";
    public $id = -1;
    public $name = "";
    public $public = false;
    public $question_array = array();
    public $result_array = array();
    public $taxonomy = null;
    public $taxonomy_tag_array = array();
    public $type = "";
    public $video = null;

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
        $this->description = $elgg_object->description;
        $this->id = $elgg_object->id;
        $this->name = $elgg_object->name;
        $this->public = $elgg_object->public;
        $this->question_array = $elgg_object->question_array;
        $this->result_array = $elgg_object->result_array;
        $this->taxonomy = $elgg_object->taxonomy;
        $this->taxonomy_tag_array = $elgg_object->taxonomy_tag_array;
        $this->type = $elgg_object->type;
        $this->video = $elgg_object->video;
        return $this;
    }

    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $id = $elgg_object->save();
            $this->id = $id;
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->description = $this->description;
        $elgg_object->name = $this->name;
        $elgg_object->public = $this->public;
        $elgg_object->question_array = $this->question_array;
        $elgg_object->result_array = $this->result_array;
        $elgg_object->taxonomy = $this->taxonomy;
        $elgg_object->taxonomy_tag_array = $this->taxonomy_tag_array;
        $elgg_object->type = $this->type;
        $elgg_object->video = $this->video;
        return $elgg_object->save();
    }

    function delete(){
        if(!$elgg_object = get_Entity($this->id)){
            return false;
        }
        return $elgg_object->delete();
    }

}