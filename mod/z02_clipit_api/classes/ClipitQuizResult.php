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
 * A Student Result for a Quiz Question, with a link to it, and a boolean value to show whether it is Correct or not.
 */
class ClipitQuizResult extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitQuizResult";
    /**
     * @var int Id of ClipitQuizQuestion this ClipitQuizResult is related to
     */
    public $quiz_question = 0;
    /**
     * @var int Id of User who posted this Quiz Result
     */
    public $user = 0;

    // can be different types, depending on the question type
    public $answer;
    /**
     * @var bool Determines if this Result is correct (true) or incorrect (false)
     */
    public $correct = false;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->user = (int)$elgg_entity->get("user");
        $this->answer = $elgg_entity->get("answer");
        $this->correct = (bool)$elgg_entity->get("correct");
        $this->quiz_question = (int)static::get_quiz_question($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("answer", $this->answer);
        $elgg_entity->set("correct", (bool)$this->correct);
        $elgg_entity->set("user", (int)$this->user);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        if($this->quiz_question != 0) {
            ClipitQuizQuestion::add_quiz_results($this->quiz_question, array($this->id));
        }
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
            if($prop == "correct") {
                if($value == "true") {
                    $new_prop_value_array["correct"] = true;
                } elseif($value == "false") {
                    $new_prop_value_array["correct"] = false;
                } else {
                    $new_prop_value_array["correct"] = (bool)$value;
                }
            } else {
                $new_prop_value_array[$prop] = $value;
            }
        }
        return parent::set_properties($id, $new_prop_value_array);
    }

    static function get_quiz_question($id) {
        $rel_array = get_entity_relationships($id, true);
        foreach($rel_array as $rel) {
            if($rel->relationship == ClipitQuizQuestion::REL_QUIZQUESTION_QUIZRESULT) {
                return $question_id = $rel->guid_one;
            }
        }
        return 0;
    }

    /**
     * Get Quiz Results by Quiz Questions
     *
     * @param array $quiz_question_array Array of Quiz Question IDs to get Results form
     *
     * @return array|bool Array of Quiz Results nested per Quiz Question IDs, or false if error
     */
    static function get_by_quiz_question($quiz_question_array) {
        $quiz_result_array = array();
        foreach($quiz_question_array as $quiz_question_id) {
            $result_array = ClipitQuizQuestion::get_quiz_results($quiz_question_id);
            $quiz_result_array[$quiz_question_id] = static::get_by_id($result_array);
        }
        return $quiz_result_array;
    }

    static function get_from_question_user($quiz_question_id, $user_id){
        $result_array = static::get_by_owner(array($user_id));
        foreach($result_array[$user_id] as $quiz_result){
            if($quiz_result->quiz_question === $quiz_question_id){
                return $quiz_result;
            }
        }
    }
}