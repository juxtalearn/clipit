<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */

/**
 * Class ClipitQuiz
 *
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

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->public = (bool)$elgg_object->public;
        $this->question_array = (array)$elgg_object->question_array;
        $this->taxonomy = (int)$elgg_object->taxonomy;
        $this->target = (string)$elgg_object->target;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->public = (bool)$this->public;
        $elgg_object->question_array = (array)$this->question_array;
        $elgg_object->taxonomy = (int)$this->taxonomy;
        $elgg_object->target = (string)$this->target;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = $elgg_object->guid;
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
            $this->public = (bool)$value;
        }
    }

    /**
     * Sets values to specified properties of an Item
     *
     * @param int   $id Id of Item to set property valyes
     * @param array $prop_value_array Array of property=>value pairs to set into the Item
     *
     * @return int|bool Returns Id of Item if correct, or false if error
     */
    static function set_properties($id, $prop_value_array){
        $called_class = get_called_class();
        if(!$item = new $called_class($id)){
            return false;
        }
        $new_prop_value_array = array();
        foreach($prop_value_array as $prop => $value){
            if($prop == "public"){
                $item->setPrivacy($value);
            } else{
                $new_prop_value_array[$prop] = $value;
            }
        }
        return parent::set_properties($id, $new_prop_value_array);
    }

    /**
     * Adds Quiz Questions to a Quiz.
     *
     * @param int   $id Id from Quiz to add Questions to
     * @param array $question_array Array of Questions to add
     *
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
     * @param int   $id Id from Quiz to remove Questions from
     * @param array $question_array Array of Questions to remove
     *
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
     *
     * @return array|bool Returns an array of ClipitQuizQuestion objects, or false if error
     */
    static function get_questions($id){
        if(!$quiz = new ClipitQuiz($id)){
            return false;
        }
        $quiz_question_array = array();
        foreach($quiz->question_array as $quiz_question_id){
            if(!$quiz_question = new ClipitQuizQuestion($quiz_question_id)){
                $quiz_question_array[$quiz_question_id] = null;
            } else{
                $quiz_question_array[$quiz_question_id] = $quiz_question;
            }
        }
        return $quiz_question_array;

    }
}