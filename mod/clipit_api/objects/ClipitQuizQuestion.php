<?php
/**
 * @package clipit\quiz\question
 */
namespace clipit\quiz\question;

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
     * @const string Elgg entity type for this class
     */
    const TYPE = "object";
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_question";
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
     * @var string Type of Question: single choice, multiple choice, select 2...
     */
    public $option_type = "";
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
        if(!$elgg_object = new ElggObject((int) $id)){
            return null;
        }
        if($elgg_object->type != ClipitQuizQuestion::TYPE
           || get_subtype_from_id($elgg_object->subtype) != ClipitQuizQuestion::SUBTYPE){
            return null;
        }
        $this->id = (int) $elgg_object->guid;
        $this->option_array = (array) $elgg_object->option_array;
        $this->question = (string) $elgg_object->question;
        $this->taxonomy_tag_array = (array) $elgg_object->taxonomy_tag_array;
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
            $elgg_object->subtype = (string) ClipitQuizQuestion::SUBTYPE;
        } else{
            $elgg_object = new ElggObject($this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->option_array = (array) $this->option_array;
        $elgg_object->question = (string) $this->question;
        $elgg_object->taxonomy_tag_array = (array) $this->taxonomy_tag_array;
        $elgg_object->option_type = (string) $this->option_type;
        $elgg_object->video = (int) $this->video;
        return $this->id = $elgg_object->save();
    }

    /**
     * Deletes a Quiz Question from the system.
     *
     * @return bool True if success, false if error.
     */
    function delete(){
        if(!$elgg_object = get_Entity((int) $this->id)){
            return false;
        }
        return $elgg_object->delete();
    }
}