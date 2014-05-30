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
    const SUBTYPE = "ClipitQuiz";
    const REL_QUIZ_QUIZQUESTION = "quiz-quiz_question";
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
    public $quiz_question_array = array();
    /**
     * @var int Id of Taxonomy used as topic for this Quiz (optional)
     */
    public $tricky_topic = 0;

    public $embed_url = "";
    public $scores_url = "";
    public $author_name = "";

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->quiz_question_array = static::get_quiz_questions($this->id);
        $this->public = (bool) $elgg_object->get("public");
        $this->tricky_topic = (int) $elgg_object->get("tricky_topic");
        $this->target = (string) $elgg_object->get("target");
        $this->embed_url = (string) $elgg_object->get("embed_url");
        $this->scores_url = (string) $elgg_object->get("scores_url");
        $this->author_name = (string) $elgg_object->get("author_name");
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("public", (bool)$this->public);
        $elgg_object->set("tricky_topic", (int)$this->tricky_topic);
        $elgg_object->set("target", (string)$this->target);
        $elgg_object->set("embed_url", (string) $this->embed_url);
        $elgg_object->set("scores_url", (string) $this->scores_url);
        $elgg_object->set("author_name", (string) $this->author_name);
    }

    protected function save(){
        parent::save();
        static::set_quiz_questions($this->id, $this->quiz_question_array);
        return $this->id;
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
    static function add_quiz_questions($id, $question_array){
        return UBCollection::add_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }

    /**
     * Sets Quiz Questions to a Quiz.
     *
     * @param int   $id Id from Quiz to set Questions to
     * @param array $question_array Array of Questions to set
     *
     * @return bool Returns true if success, false if error
     */
    static function set_quiz_questions($id, $question_array){
        return UBCollection::set_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }


    /**
     * Remove Quiz Questions from a Quiz.
     *
     * @param int   $id Id from Quiz to remove Questions from
     * @param array $question_array Array of Questions to remove
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_quiz_questions($id, $question_array){
        return UBCollection::remove_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }

    /**
     * Get an array of Quiz Questions included in a Quiz.
     *
     * @param int $id The Id of the Quiz to get questions from
     *
     * @return array|bool Returns an array of ClipitQuizQuestion objects, or false if error
     */
    static function get_quiz_questions($id){
        return UBCollection::get_items($id, static::REL_QUIZ_QUIZQUESTION);
    }
}