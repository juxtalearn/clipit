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
 * Class ClipitQuizQuestion
 *
 */
class ClipitQuizQuestion extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "ClipitQuizQuestion";
    const REL_QUIZQUESTION_TAG = "quiz_question-tag";
    const REL_QUIZQUESTION_QUIZRESULT = "quiz_question-quiz_result";

    /**
     * @var array Array of options to chose from as an answer to the question
     */
    public $option_array = array();
    /**
     * @var string Type of Question: single choice, multiple choice, select 2...
     */
    public $option_type = "";
    /**
     * @var array Array of Tags relevant to this question
     */
    public $tag_array = array();
    /**
     * @var array Array of Quiz Results which answer this Quiz Question
     */
    public $quiz_result_array = array();
    /**
     * @var int ID of ClipitVideo refered to by this question (optional)
     */
    public $video = 0;
    /**
     * @var int Difficulty of the QuizQuestion, in a numeric scale from X to Y.
     */
    public $difficulty = 0;


    /**
     * @param ElggObject $elgg_object
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->tag_array = static::get_tags($this->id);
        $this->quiz_result_array = static::get_quiz_results($this->id);
        $this->option_array = (array)$elgg_object->get("option_array");
        $this->option_type = (string)$elgg_object->get("option_type");
        $this->video = (int)$elgg_object->get("video");
        $this->difficulty = (int)$elgg_object->get("difficulty");
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("option_array", (array)$this->option_array);
        $elgg_object->set("option_type", (string)$this->option_type);
        $elgg_object->set("video", (int)$this->video);
        $elgg_object->set("difficulty", (int)$this->difficulty);
    }

    /**
     * @return bool|int
     */
    protected function save(){
        parent::save();
        static::set_tags($this->id, $this->tag_array);
        static::set_quiz_results($this->id, $this->quiz_result_array);
        return $this->id;
    }

    /**
     * @return bool|void
     */
    protected function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        $result_array = array();
        foreach($rel_array as $rel){
            if($rel->relationship == static::REL_QUIZQUESTION_QUIZRESULT){
                $result_array[] = $rel->guid_two;
            }
        }
        if(!empty($result_array)){
            ClipitQuizResult::delete_by_id($result_array);
        }
        parent::delete();
    }

    /**
     * @param int $id
     * @param array $result_array
     * @return bool
     */
    static function add_quiz_results($id, $result_array){
        return UBCollection::add_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT, true);
    }

    /**
     * @param int $id
     * @param array $result_array
     * @return bool
     */
    static function set_quiz_results($id, $result_array){
        return UBCollection::set_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT, true);
    }

    /**
     * @param $id
     * @param $result_array
     * @return bool
     */
    static function remove_quiz_results($id, $result_array){
        return UBCollection::remove_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT);
    }

    /**
     * Get all Quiz Results from a specified Quiz Question.
     *
     * @param int $id Id of Quiz Question to get Results form
     *
     * @return array|bool Array of Quiz Results, or false if error
     */
    static function get_quiz_results($id){
        return UBCollection::get_items($id, static::REL_QUIZQUESTION_QUIZRESULT);
    }


    /**
     * Add a list of Stumbling Block Tags to a Quiz Question.
     *
     * @param int   $id Id of the Quiz Question
     * @param array $tag_array Array of Stumbling Block Tags to add to the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Set a list of Stumbling Block Tags to a Quiz Question.
     *
     * @param int   $id Id of the Quiz Question
     * @param array $tag_array Array of Stumbling Block Tags to set to the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Remove a list of Stumbling Block Tags from a Quiz Question.
     *
     * @param int   $id Id of the Quiz Question
     * @param array $tag_array Array of Stumbling Block Tags to remove from the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Get all Stumbling Block Tags for a Quiz Question.
     *
     * @param int $id Id from the Quiz Question to get Stumbling Block Tags from
     *
     * @return array|bool Returns an array of Stumbling Block Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_QUIZQUESTION_TAG);
    }
}