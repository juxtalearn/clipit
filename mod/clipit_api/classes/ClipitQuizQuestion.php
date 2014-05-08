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
    const SUBTYPE = "clipit_quiz_question";
    /**
     * @var array Array of options to chose from as an answer to the question
     */
    public $option_array = array();
    /**
     * @var string Type of Question: single choice, multiple choice, select 2...
     */
    public $option_type = "";
    /**
     * @var array Array of Stumbling Block Tags relevant to this question
     */
    public $tag_array = array();
    /**
     * @var int ID of ClipitVideo refered to by this question (optional)
     */
    public $video = 0;


    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->option_array = (array)$elgg_object->option_array;
        $this->tag_array = (array)$elgg_object->tag_array;
        $this->option_type = (string)$elgg_object->option_type;
        $this->video = (int)$elgg_object->video;
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->option_array = (array)$this->option_array;
        $elgg_object->tag_array = (array)$this->tag_array;
        $elgg_object->option_type = (string)$this->option_type;
        $elgg_object->video = (int)$this->video;
    }

    /**
     * Get all Quiz Results from a specified Quiz Question.
     *
     * @param int $id Id of Quiz Question to get Results form
     *
     * @return array|bool Array of Quiz Results, or false if error
     */
    static function get_results($id){
        $quiz_result_array = ClipitQuizResult::get_by_question(array($id));
        return array_pop($quiz_result_array);
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
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        if(!$quiz_question->tag_array){
            $quiz_question->tag_array = $tag_array;
        } else{
            $quiz_question->tag_array = array_merge($quiz_question->tag_array, $tag_array);
        }
        if(!$quiz_question->save()){
            return false;
        }
        return true;
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
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        if(!$quiz_question->tag_array){
            return false;
        }
        foreach($tag_array as $tag){
            $key = array_search($tag, $quiz_question->tag_array);
            if(isset($key)){
                unset($quiz_question->tag_array[$key]);
            } else{
                return false;
            }
        }
        if(!$quiz_question->save()){
            return false;
        }
        return true;
    }

    /**
     * Get all Stumbling Block Tags for a Quiz Question.
     *
     * @param int $id Id from the Quiz Question to get Stumbling Block Tags from
     *
     * @return array|bool Returns an array of Stumbling Block Tag items, or false if error
     */
    static function get_tags($id){
        if(!$quiz_question = new ClipitQuizQuestion($id)){
            return false;
        }
        return $quiz_question->tag_array;
    }
}