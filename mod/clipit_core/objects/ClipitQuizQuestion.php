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

/**
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggObject
 */
use \ElggObject;

/**
 * Class ClipitQuizQuestion
 *
 * @package clipit\quiz\question
 */
class ClipitQuizQuestion{
    /**
     * @const string Subtype of the ClipitQuizQuestion class for ElggObject
     */
    const SUBTYPE = "quiz_question";
    /**
     * @var int Unique id of this ClipitQuizQuestion instance (-1 = unsaved)
     */
    public $id = -1;
    /**
     * @var string Main text question which will be shown to users taking the quiz
     */
    public $question = "";
    /**
     * @var array Array of options to chose from as an answer to the question
     */
    public $option_array = array();
    /**
     * @var string Type of question: single choice, multiple choice, select 2...
     */
    public $type = ""; // select only 1, multiple choice...
    /**
     * @var array Array of Taxonomy Tags relevant to this question
     */
    public $taxonomy_tag_array = array();
    /**
     * @var int ID of ClipitVideo refered to by this question (optional)
     */
    public $video = -1;

    /**
     * @param int $id If $id is null, create new instance, else load instance with id = $id.
     */
    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    /**
     * Loads a ClipitQuizQuestion instance from the system.
     *
     * @param int $id Id of the ClipitQuiz to load from the system.
     * @return $this|bool Returns ClipitQuiz instance, or false if error.
     */
    function load($id){
        $elgg_object = new ElggObject($id);
        if(!$elgg_object){
            return false;
        }
        $this->id = $elgg_object->guid;
        $this->option_array = $elgg_object->option_array;
        $this->question = $elgg_object->question;
        $this->taxonomy_tag_array = $elgg_object->taxonomy_tag_array;
        $this->type = $elgg_object->type;
        $this->video = $elgg_object->video;
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
            $elgg_object->subtype = $this::SUBTYPE;
            $this->id = $elgg_object->save();
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->option_array = $this->option_array;
        $elgg_object->question = $this->question;
        $elgg_object->taxonomy_tag_array = $this->taxonomy_tag_array;
        $elgg_object->type = $this->type;
        $elgg_object->video = $this->video;
        return $elgg_object->save();
    }

    /**
     * Deletes a Quiz Question from the system.
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