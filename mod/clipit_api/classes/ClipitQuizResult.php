<?php


/**
 * Class ClipitQuizResult
 *
 * @package clipit
 */
class ClipitQuizResult extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_quiz_result";
    /**
     * @var int Id of ClipitQuizQuestion this ClipitQuizResult is related to
     */
    public $quiz_question = -1;
    /**
     * @var array Array of results to the Quiz Question linked by $quiz_question
     */
    public $result_array = array();
    /**
     * @var int Id of User who posted this Quiz Result
     */
    public $user = -1;
    /**
     * @var bool Determines if this Result is correct (true) or incorrect (false)
     */
    public $correct = false;

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->result_array = (array)$elgg_object->result_array;
        $this->correct = (bool)$elgg_object->correct;
        $this->quiz_question = (int)$elgg_object->quiz_question;
        $this->user = (int)$elgg_object->user;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->result_array = (array)$this->result_array;
        $elgg_object->correct = (bool)$this->correct;
        $elgg_object->quiz_question = (int)$this->quiz_question;
        $elgg_object->user = (int)$this->user;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = $elgg_object->guid;
    }

    /**
     * Sets values into specified properties of the instance
     *
     * @param array $prop_value_array Array of prop=>value pairs to set into the instance
     *
     * @return int Returns instance Id, or false if error
     * @throws InvalidParameterException
     */
    function setProperties($prop_value_array){
        $new_prop_value_array = array();
        foreach($prop_value_array as $prop => $value){
            if($prop == "correct"){
                $this->setCorrect($value);
            } else{
                $new_prop_value_array[$prop] = $value;
            }
        }
        return parent::setProperties($new_prop_value_array);
    }

    /**
     * Set Quiz Result Correct flag into "correct" property (true = yes, false = no)
     *
     * @param string $value Flag specifying if the Quiz Result is correct or not
     */
    function setCorrect($value){
        if($value == "true"){
            $this->correct = true;
        } elseif($value == "false"){
            $this->correct = false;
        } else{
            $this->correct = (bool)$value;
        }
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