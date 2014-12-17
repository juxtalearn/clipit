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
 * A collection of Quiz Questions, with a link to a Tricky Topic, links to the Tricky Topic Tool Quiz answering and
 * score review URLs, and Author name.
 */
class ClipitQuiz extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitQuiz";
    const REL_QUIZ_QUIZQUESTION = "ClipitQuiz-ClipitQuizQuestion";
    const REL_QUIZ_USER = "ClipitQuiz-ClipitUser";
    const VIEW_MODE_LIST = "list";
    const VIEW_MODE_PAGED = "paged";
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
    public $view_mode = "";
    public $max_time = 0; // Maximum time to perform the quiz since it's opened by a student (0 = unlimited)

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->quiz_question_array = static::get_quiz_questions($this->id);
        $this->public = (bool)$elgg_entity->get("public");
        $this->tricky_topic = (int)$elgg_entity->get("tricky_topic");
        $this->target = (string)$elgg_entity->get("target");
        $this->embed_url = (string)$elgg_entity->get("embed_url");
        $this->scores_url = (string)$elgg_entity->get("scores_url");
        $this->author_name = (string)$elgg_entity->get("author_name");
        $this->view_mode = (string)$elgg_entity->get("view_mode");
        $this->max_time = (int)$elgg_entity->get("max_time");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("public", (bool)$this->public);
        $elgg_entity->set("tricky_topic", (int)$this->tricky_topic);
        $elgg_entity->set("target", (string)$this->target);
        $elgg_entity->set("embed_url", (string)$this->embed_url);
        $elgg_entity->set("scores_url", (string)$this->scores_url);
        $elgg_entity->set("author_name", (string)$this->author_name);
        if((string)$this->view_mode == ""){
            $elgg_entity->set("view_mode", static::VIEW_MODE_LIST);
        }else{
            $elgg_entity->set("view_mode", (string)$this->view_mode);
        }
        $elgg_entity->set("max_time", (int)$this->max_time);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_quiz_questions($this->id, $this->quiz_question_array);
        return $this->id;
    }

    /**
     * Sets values to specified properties of an Item
     *
     * @param int   $id               Id of Item to set property values
     * @param array $prop_value_array Array of property=>value pairs to set into the Item
     *
     * @return int|bool Returns Id of Item if correct, or false if error
     * @throws InvalidParameterException
     */
    static function set_properties($id, $prop_value_array) {
        $new_prop_value_array = array();
        foreach($prop_value_array as $prop => $value) {
            if($prop == "public") {
                if($value == "true") {
                    $new_prop_value_array["public"] = true;
                } elseif($value == "false") {
                    $new_prop_value_array["public"] = false;
                } else {
                    $new_prop_value_array["public"] = (bool)$value;
                }
            } else {
                $new_prop_value_array[$prop] = $value;
            }
        }
        return parent::set_properties($id, $new_prop_value_array);
    }

    static function set_quiz_start($id, $user_id){
        return UBCollection::add_items($id, array($user_id), static::REL_QUIZ_USER);
    }

    static function get_quiz_start($id, $user_id){
        return UBCollection::get_timestamp($id, $user_id, static::REL_QUIZ_USER);
    }

    /**
     * Returns whether a user has finished a Quiz
     *
     * @param int $id The Quiz ID
     * @param int $user_id The User ID
     * @return bool 'true' if yes, 'false' if no
     */
    static function has_finished_quiz($id, $user_id){
        $start_time = (int)static::get_quiz_start($id, $user_id);
        if(empty($start_time)){
            return false;
        }
        $prop_value_array = (array)static::get_properties($id, array("max_time"));
        $current_time = (int)time();
        if($start_time + $prop_value_array["max_time"] <= $current_time){
            return true;
        }
        return false;
    }

    static function questions_answered_by_user($id, $user_id){
        if(empty($quiz) || empty($user_id)){
            return null;
        }
        $quiz = new static ($id);
        $answered_questions = (int)0;
        $user_results = ClipitQuizResult::get_by_owner(array($user_id));
        $user_results = $user_results[$user_id];
        if(empty($user_results)){
            return $answered_questions;
        }
        foreach($user_results as $result){
            if(array_search($result->quiz_question, $quiz->quiz_question_array) !== false){
                $answered_questions++;
            }
        }
        return $answered_questions;
    }

    /**
     * Adds Quiz Questions to a Quiz.
     *
     * @param int   $id             Id from Quiz to add Questions to
     * @param array $question_array Array of Questions to add
     *
     * @return bool Returns true if success, false if error
     */
    static function add_quiz_questions($id, $question_array) {
        return UBCollection::add_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }

    /**
     * Sets Quiz Questions to a Quiz.
     *
     * @param int   $id             Id from Quiz to set Questions to
     * @param array $question_array Array of Questions to set
     *
     * @return bool Returns true if success, false if error
     */
    static function set_quiz_questions($id, $question_array) {
        return UBCollection::set_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }

    /**
     * Remove Quiz Questions from a Quiz.
     *
     * @param int   $id             Id from Quiz to remove Questions from
     * @param array $question_array Array of Questions to remove
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_quiz_questions($id, $question_array) {
        return UBCollection::remove_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION);
    }

    /**
     * Get an array of Quiz Questions included in a Quiz.
     *
     * @param int $id The Id of the Quiz to get questions from
     *
     * @return array|bool Returns an array of ClipitQuizQuestion IDs, or false if error
     */
    static function get_quiz_questions($id) {
        return UBCollection::get_items($id, static::REL_QUIZ_QUIZQUESTION);
    }
}