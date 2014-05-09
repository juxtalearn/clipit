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
 * Class ClipitQuizResult
 *
 */
class ClipitQuizResult extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_result";
    /**
     * @var int Id of ClipitQuizQuestion this ClipitQuizResult is related to
     */
    public $quiz_question = 0;
    /**
     * @var array Array of results to the Quiz Question linked by $quiz_question
     */
    public $result_array = array();
    /**
     * @var int Id of User who posted this Quiz Result
     */
    public $user = 0;
    /**
     * @var bool Determines if this Result is correct (true) or incorrect (false)
     */
    public $correct = false;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->result_array = (array)$elgg_object->result_array;
        $this->correct = (bool)$elgg_object->correct;
        $this->quiz_question = (int)$elgg_object->quiz_question;
        $this->user = (int)$elgg_object->user;
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->result_array = (array)$this->result_array;
        $elgg_object->correct = (bool)$this->correct;
        $elgg_object->quiz_question = (int)$this->quiz_question;
        $elgg_object->user = (int)$this->user;
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
            if($prop == "correct"){
                if($value == "true"){
                    $new_prop_value_array["correct"] = true;
                } elseif($value == "false"){
                    $new_prop_value_array["correct"] = false;
                } else{
                    $new_prop_value_array["correct"] = (bool)$value;
                }
            } else{
                $new_prop_value_array[$prop] = $value;
            }
        }
        return parent::set_properties($id, $new_prop_value_array);
    }

    /**
     * Get Quiz Results by Quiz Questions
     *
     * @param array $quiz_question_array Array of Quiz Question IDs to get Results form
     *
     * @return array|bool Array of nested arrays per question with Quiz Results, or false if error
     */
    static function get_by_question($quiz_question_array){
        $quiz_result_array = array();
        foreach($quiz_question_array as $quiz_question_id){
            $elgg_object_array = elgg_get_entities_from_metadata(
                array(
                    "type" => ClipitQuizResult::TYPE,
                    "subtype" => ClipitQuizResult::SUBTYPE,
                    "metadata_names" => array("quiz_question"),
                    "metadata_values" => array((int)$quiz_question_id)
                )
            );
            if(!$elgg_object_array){
                $quiz_result_array[$quiz_question_id] = null;
            } else{
                $temp_array = array();
                foreach($elgg_object_array as $elgg_object){
                    $temp_array[] = new ClipitQuizResult((int)$elgg_object->guid);
                }
                if(empty($temp_array)){
                    $quiz_result_array[$quiz_question_id] = null;
                } else{
                    $quiz_result_array[$quiz_question_id] = $temp_array;
                }
            }
        }
        return $quiz_result_array;
    }

}