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
 * A Quiz Question containing a main question (in the "name" and "description" properties), with a set of Options,
 * a Validation array with the correct pattern of Options, a Difficulty value, can be Tagged, can be linked to a Video,
 * and contains links to all Results submitted by Students to this Question.
 */
class ClipitQuizQuestion extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitQuizQuestion";
    const REL_QUIZQUESTION_TAG = "ClipitQuizQuestion-ClipitTag";
    const REL_QUIZQUESTION_QUIZRESULT = "ClipitQuizQuestion-ClipitQuizResult";
    const REL_QUIZQUESTION_IMAGE = "ClipitQuizQuestion-ClipitFile";
    const TYPE_TRUE_FALSE = "true_false";
    const TYPE_SELECT_ONE = "select_one";
    const TYPE_SELECT_MULTI = "select_multi";
    const TYPE_NUMBER = "number";

    /**
     * @var array Array of options to chose from as an answer to the question
     */
    public $option_array = array();
    /**
     * @var array Array for validation of the options
     */
    public $validation_array = array();
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
     * @var string URL of ClipitVideo refered to by this question (optional)
     */
    public $video = "";
    /**
     * @var int ID of image file (ClipitFile) to show next to the Quiz Question (optional)
     */
    public $image = 0;
    /**
     * @var int Difficulty of the QuizQuestion, in an integer scale from 1 to 10.
     */
    public $difficulty = 0;
    /**
     * @var int Order in which this QuizQuestion will be displayed to students
     */
    public $order = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tag_array = static::get_tags($this->id);
        $this->quiz_result_array = static::get_quiz_results($this->id);
        $this->option_array = (array)$elgg_entity->get("option_array");
        $this->validation_array = (array)$elgg_entity->get("validation_array");
        $this->option_type = (string)$elgg_entity->get("option_type");
        $this->video = (string)$elgg_entity->get("video");
        $this->image = static::get_image((int)$this->id);
        $this->difficulty = (int)$elgg_entity->get("difficulty");
        $this->order = (int)$elgg_entity->get("order");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("option_array", (array)$this->option_array);
        $elgg_entity->set("validation_array", (array)$this->validation_array);
        $elgg_entity->set("option_type", (string)$this->option_type);
        $video_metadata = ClipitVideo::video_url_parser($this->video);
        $elgg_entity->set("video", (string)$video_metadata["url"]);
        $elgg_entity->set("difficulty", (int)$this->difficulty);
        $elgg_entity->set("order", (int)$this->order);
    }

    /**
    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_tags($this->id, $this->tag_array);
        static::set_quiz_results($this->id, $this->quiz_result_array);
        static::set_image($this->id, $this->image);
        return $this->id;
    }

    /**
     * Get all Questions from a Quiz ID
     *
     * @param int $quiz_id Quiz ID
     * @return static[] Quiz question array
     */
    static function get_from_quiz($quiz_id){
        $quiz_question_ids = ClipitQuiz::get_quiz_questions($quiz_id);
        return static::get_by_id($quiz_question_ids);
    }

    /**
     * Get the image ID (ClipitFile) linked to a Quiz Question
     *
     * @param int $id ID of the ClipitQuizQuestion
     * @return int|null ID of linked image file (ClipitFile)
     */
    static function get_image($id){
        $temp = UBCollection::get_items($id, static::REL_QUIZQUESTION_IMAGE);
        if(!empty($temp)){
            return (int)array_pop($temp);
        }
        return null;
    }

    /**
     * Set the image (ClipitFile) linked to a Quiz Question
     *
     * @param int $id ID of Quiz Question
     * @param int $image_id ID of image file (ClipitFile)
     * @return bool True if ok, False if error.
     */
    static function set_image($id, $image_id){
        return UBCollection::set_items($id, array($image_id), static::REL_QUIZQUESTION_IMAGE);
    }

    /**
     * Get Quiz Questions linked to a Video URL
     *
     * @param $video_url URL of video
     * @return static[] Array of Quiz Questions
     */
    static function get_from_video($video_url){
        $video_url = base64_decode($video_url);
        $video_metadata = ClipitVideo::video_url_parser($video_url);
        $video_url = $video_metadata["url"];
        $return_quiz_question_array = array();
        $quiz_array = ClipitQuiz::get_all(0, 0, "", true, true);
        foreach($quiz_array as $quiz_id){
            $quiz_question_array = static::get_from_quiz($quiz_id);
            foreach($quiz_question_array as $quiz_question){
                if(strcmp($video_url, $quiz_question->video) === 0){
                    $return_quiz_question_array[] = $quiz_question;
                }
            }
        }
        return $return_quiz_question_array;
    }

    /**
     * @param int   $id
     * @param array $result_array
     *
     * @return bool
     */
    static function add_quiz_results($id, $result_array) {
        return UBCollection::add_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT, true);
    }

    /**
     * @param int   $id
     * @param array $result_array
     *
     * @return bool
     */
    static function set_quiz_results($id, $result_array) {
        return UBCollection::set_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT, true);
    }

    /**
     * @param $id
     * @param $result_array
     *
     * @return bool
     */
    static function remove_quiz_results($id, $result_array) {
        return UBCollection::remove_items($id, $result_array, static::REL_QUIZQUESTION_QUIZRESULT);
    }

    /**
     * Get all Quiz Results from a specified Quiz Question.
     *
     * @param int $id Id of Quiz Question to get Results form
     *
     * @return array|bool Array of Quiz Result IDs, or false if error
     */
    static function get_quiz_results($id) {
        return UBCollection::get_items($id, static::REL_QUIZQUESTION_QUIZRESULT);
    }

    /**
     * Add a list of Stumbling Block Tags to a Quiz Question.
     *
     * @param int   $id        Id of the Quiz Question
     * @param array $tag_array Array of Tags to add to the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Set a list of Stumbling Block Tags to a Quiz Question.
     *
     * @param int   $id        Id of the Quiz Question
     * @param array $tag_array Array of Tags to set to the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Remove a list of Stumbling Block Tags from a Quiz Question.
     *
     * @param int   $id        Id of the Quiz Question
     * @param array $tag_array Array of Tags to remove from the Quiz Question
     *
     * @return bool True if success, false if error
     */
    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_QUIZQUESTION_TAG);
    }

    /**
     * Get all Stumbling Block Tags for a Quiz Question.
     *
     * @param int $id Id from the Quiz Question to get Stumbling Block Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_QUIZQUESTION_TAG);
    }

    static function set_type_true_false($id) {
        $prop_value_array = array();
        $prop_value_array["option_type"] = static::TYPE_TRUE_FALSE;
        return static::set_properties($id, $prop_value_array);
    }

    static function set_type_select_one($id) {
        $prop_value_array = array();
        $prop_value_array["option_type"] = static::TYPE_SELECT_ONE;
        return static::set_properties($id, $prop_value_array);
    }

    static function set_type_select_multi($id) {
        $prop_value_array = array();
        $prop_value_array["option_type"] = static::TYPE_SELECT_MULTI;
        return static::set_properties($id, $prop_value_array);
    }

    static function set_type_number($id) {
        $prop_value_array = array();
        $prop_value_array["option_type"] = static::TYPE_NUMBER;
        return static::set_properties($id, $prop_value_array);
    }

}