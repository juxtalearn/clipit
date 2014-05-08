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
    public $tricky_topic = 0;

    public $embed_url = "";
    public $scores_url = "";
    public $author_name = "";

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->public = (bool)$elgg_object->public;
        $this->question_array = (array)$elgg_object->question_array;
        $this->tricky_topic = (int)$elgg_object->tricky_topic;
        $this->target = (string)$elgg_object->target;
        $this->embed_url = (string) $elgg_object->embed_url;
        $this->scores_url = (string) $elgg_object->scores_url;
        $this->author_name = (string) $elgg_object->author_name;
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->public = (bool)$this->public;
        $elgg_object->question_array = (array)$this->question_array;
        $elgg_object->tricky_topic = (int)$this->tricky_topic;
        $elgg_object->target = (string)$this->target;
        $elgg_object->embed_url = (string) $this->embed_url;
        $elgg_object->scores_url = (string) $this->scores_url;
        $elgg_object->author_name = (string) $this->author_name;
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
        $new_prop_value_array = array();
        foreach($prop_value_array as $prop => $value){
            if($prop == "public"){
                if($value == "true"){
                    $new_prop_value_array["public"] = true;
                } elseif($value == "false"){
                    $new_prop_value_array["public"] = false;
                } else{
                    $new_prop_value_array["public"] = (bool)$value;
                }
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