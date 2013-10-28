<?php namespace clipit\quiz\question;

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

// Alias so classes outside of this namespace can be used without path.
use \ElggObject as ElggObject;

/**
 * Class ClipitQuizQuestion
 *
 * @package clipit\quiz\question
 */
class ClipitQuizQuestion{
    // Class properties
    public $id = -1;
    public $question = "";
    public $option_array = array();
    public $type = ""; // select only 1, multiple choice...
    public $quiz = -1;
    public $taxonomy_tag_array = array();
    public $video = -1;


    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    function load($id){
        $elgg_object = new ElggObject($id);
        if(!$elgg_object){
            return false;
        }
        $this->id = $elgg_object->guid;
        $this->option_array = $elgg_object->option_array;
        $this->question = $elgg_object->question;
        $this->quiz = $elgg_object->quiz;
        $this->taxonomy_tag_array = $elgg_object->taxonomy_tag_array;
        $this->type = $elgg_object->type;
        $this->video = $elgg_object->video;
        return $this;
    }

    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = "quiz_question";
            $this->id = $elgg_object->save();
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->option_array = $this->option_array;
        $elgg_object->question = $this->question;
        $elgg_object->quiz = $this->quiz;
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