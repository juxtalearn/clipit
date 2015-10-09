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
    const REL_QUIZ_TRICKYTOPIC = "ClipitQuiz-ClipitTrickyTopic";
    const REL_QUIZ_QUIZQUESTION = "ClipitQuiz-ClipitQuizQuestion";
    const REL_QUIZ_USER = "ClipitQuiz-ClipitUser";
    const VIEW_MODE_LIST = "list";
    const VIEW_MODE_PAGED = "paged";
    const TARGET_CLIPIT = "clipit";
    const TARGET_LARGEDISPLAY = "large_display";
    /**
     * @var string Target interface for Quiz display (e.g.: "clipit", "large display"...)
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
     * @var int Id of tricky topic used for this Quiz (optional)
     */
    public $tricky_topic = 0;
    /**
     * @var string
     */
    public $view_mode = "";
    /**
     * @var int $max_time  Maximum time in seconds to perform the quiz since it's opened by a student (0 = unlimited)
     */
    public $max_time = 0;
    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->quiz_question_array = static::get_quiz_questions($this->id);
        $this->public = (bool)$elgg_entity->get("public");
        $this->tricky_topic = (int)static::get_tricky_topic($this->id);
        $this->target = (string)$elgg_entity->get("target");
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
        $elgg_entity->set("target", (string)$this->target);
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
        static::set_tricky_topic($this->id, (int)$this->tricky_topic);
        static::set_quiz_questions($this->id, $this->quiz_question_array);
        return $this->id;
    }

    /**
     * Clones a ClipitQuiz, including the contained ClipitQuizQuestions
     *
     * @param int $id ID of Quiz to clone
     * @param bool $linked Whether the clone will be linked to the parent object
     * @param bool $keep_owner Selects whether the clone will keep the parent item's owner (default: no)
     * @return bool|int ID of new cloned object
     * @throws InvalidParameterException if error
     */
    static function create_clone($id, $linked = true, $keep_owner = false) {
        $prop_value_array = static::get_properties($id);
        if($keep_owner === false){
            $prop_value_array["owner_id"] = elgg_get_logged_in_user_guid();
        }
        $quiz_question_array = $prop_value_array["quiz_question_array"];
        if(!empty($quiz_question_array)){
            $new_quiz_question_array = array();
            foreach($quiz_question_array as $quiz_question_id){
                $new_quiz_question_array[] = ClipitQuizQuestion::create_clone($quiz_question_id);
            }
            $prop_value_array["quiz_question_array"] = $new_quiz_question_array;
        }
        $clone_id = static::create($prop_value_array);
        if($linked) {
            static::link_parent_clone($id, $clone_id);
        }
        return $clone_id;
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

    static function get_task($id){
        $task_array = UBCollection::get_items((int)$id, ClipitTask::REL_TASK_QUIZ, true);
        if(empty($task_array)){
            return 0;
        }
        return (int)array_pop($task_array);
    }

    static function get_tricky_topic($id) {
        $ret_array = UBCollection::get_items($id, static::REL_QUIZ_TRICKYTOPIC);
        if(!empty($ret_array)){
            return array_pop($ret_array);
        }
        return 0;
    }

    static function set_tricky_topic($id, $tricky_topic) {
        return UBCollection::set_items($id, array($tricky_topic), static::REL_QUIZ_TRICKYTOPIC);
    }

    static function get_from_tricky_topic($tricky_topic_id) {
        $id_array = UBCollection::get_items($tricky_topic_id, static::REL_QUIZ_TRICKYTOPIC, true);
        $quiz_array = array();
        foreach($id_array as $quiz_id) {
            $quiz_array[] = new static($quiz_id);
        }
        return $quiz_array;
    }

    static function set_quiz_as_finished($id, $user_id){
        $start_timestamp = (int)static::get_quiz_start($id, $user_id);
        if(empty($start_timestamp)) {
            return null;
        }
        $prop_value_array = static::get_properties($id, array("max_time"));
        $max_time = (int)$prop_value_array["max_time"];
        $new_start_timestamp = (int)$start_timestamp - $max_time;
        return UBCollection::set_timestamp($id, $user_id, static::REL_QUIZ_USER, $new_start_timestamp);
    }

    static function set_quiz_start($id, $user_id){
        return UBCollection::add_items($id, array($user_id), static::REL_QUIZ_USER);
    }

    static function remove_quiz_start($id, $user_array){
        return UBCollection::remove_items($id, $user_array, static::REL_QUIZ_USER);
    }

    /**
     * @param $id
     * @param $user_id
     * @return int|null
     */
    static function get_quiz_start($id, $user_id){
        return UBCollection::get_timestamp($id, $user_id, static::REL_QUIZ_USER);
    }

    static function get_started_users($id){
        return UBCollection::get_items($id, static::REL_QUIZ_USER);
    }

    /**
     * Returns whether a user has finished a Quiz
     *
     * @param int $id The Quiz ID
     * @param int $user_id The User ID
     * @return bool 'true' if yes, 'false' if no
     */
    static function has_finished_quiz($id, $user_id){
        // check if quiz has been started, and if max_time is over
        $start_time = (int)static::get_quiz_start($id, $user_id);
        if(empty($start_time)){
            return false;
        }
        // If task has ended, quiz is finished
        $task_id = static::get_task($id);
        if(ClipitTask::get_status($task_id) !== ClipitTask::STATUS_ACTIVE){
            return true;
        }
        $prop_value_array = (array)static::get_properties($id, array("max_time"));
        $max_time = (int)$prop_value_array["max_time"];
        if($max_time == 0){
            return false;
        }
        $current_time = (int)time();
        if($start_time + $max_time <= $current_time){
            return true;
        }
        // else, quiz is still ongoing
        return false;
    }

    static function questions_answered_by_user($id, $user_id){
        if(empty($id) || empty($user_id)){
            return null;
        }
        $quiz = new static($id);
        $answered_questions = 0;
        $user_results = ClipitQuizResult::get_by_owner(array($user_id));
        $user_results = $user_results[$user_id];
        if(empty($user_results)){
            return $answered_questions;
        }
        foreach($user_results as $result){
            if(in_array($result->quiz_question, $quiz->quiz_question_array)){
                $answered_questions++;
            }
        }
        return $answered_questions;
    }

    /**
     * Returns the average results by Question for a Quiz for a User, normalized from 0 to 1.
     *
     * @param int $id Quiz ID
     * @param int $user_id User ID
     * @return array Array of question_id=>$result, where the result is a float from 0 to 1. Empty array if the user has not
     * finished the Quiz.
     */
    static function get_user_results_by_question($id, $user_id){
        $result_array = array();
        if(!static::has_finished_quiz($id, $user_id)){
            return $result_array;
        }
        $quiz_question_array = static::get_quiz_questions($id);
        if(empty($quiz_question_array)){
            return $result_array;
        }
        foreach($quiz_question_array as $quiz_question_id){
            $quiz_question = new ClipitQuizQuestion($quiz_question_id);
            $quiz_result = ClipitQuizResult::get_from_question_user($quiz_question_id, $user_id);
                if(!empty($quiz_result)) {
                    if ($quiz_result->correct) {
                        $result_array[$quiz_question->id]=1;
                    } else {
                        $result_array[$quiz_question->id]=0;
                    }
                }
        }
        return $result_array;
    }

    /**
     * Returns the average results by Question for a Quiz among a Group. Students who have not finished the Quiz will not
     * be counted.
     *
     * @param int $id Quiz ID
     * @param int $group_id Group ID
     *
     * @return array Array of $question_id=>$result, where the result is a float from 0 to 1. Empty array if none of the
     * students in the group have answered the Quiz.
     */
    static function get_group_results_by_question($id, $group_id){
        $group = new ClipitGroup($group_id);
        $user_results = array();
        foreach($group->user_array as $user_id){
            $user_results[$user_id] = static::get_user_results_by_question($id, $user_id);
        }
        $group_results = array();
        $user_count = 0;
        foreach($user_results as $user=>$results){
            if(empty($results)){
                continue;
            }
            $user_count++;
            foreach($results as $question_id=>$result){
                if(!isset($group_results[$question_id])){
                    $group_results[$question_id] = (float)0.0;
                }
                $group_results[$question_id] += $result;
            }
        }
        foreach($group_results as $question_id=>$result){
            $group_results[$question_id] = (float)$result/$user_count;
        }
        return $group_results;
    }


    /**
     * Returns the average results by Tag for a Quiz for a User, normalized from 0 to 1.
     *
     * @param int $id Quiz ID
     * @param int $user_id User ID
     * @return array Array of tag_id=>$result, where the result is a float from 0 to 1. Empty array if the user has not
     * finished the Quiz.
     */
    static function get_user_results_by_tag($id, $user_id){
        $result_array = array();
        if(!static::has_finished_quiz($id, $user_id)){
            return $result_array;
        }
        $tag_count_array = array();
        $quiz_question_array = static::get_quiz_questions($id);
        if(empty($quiz_question_array)){
            return $result_array;
        }
        foreach($quiz_question_array as $quiz_question_id){
            $quiz_question = new ClipitQuizQuestion($quiz_question_id);
            $quiz_result = ClipitQuizResult::get_from_question_user($quiz_question_id, $user_id);
            foreach($quiz_question->tag_array as $tag_id){
                if(!isset($tag_count_array[$tag_id])){
                    $tag_count_array[$tag_id] = (int)1;
                    $result_array[$tag_id] = (int)0;
                } else {
                    $tag_count_array[$tag_id]++;
                }
                if(!empty($quiz_result)) {
                    if ($quiz_result->correct) {
                        $result_array[$tag_id]++;
                    }
                }
            }
        }
        // transform to [0..1] scale
        foreach($result_array as $tag_id=>$correct_answers){
            $result_array[$tag_id] = (float)$correct_answers/$tag_count_array[$tag_id];
        }
        ksort($result_array);
        return $result_array;
    }

    /**
     * Returns the average results by Tag for a Quiz among a Group. Students who have not finished the Quiz will not
     * be counted.
     *
     * @param int $id Quiz ID
     * @param int $group_id Group ID
     *
     * @return array Array of $tag_id=>$result, where the result is a float from 0 to 1. Empty array if none of the
     * students in the group have answered the Quiz.
     */
    static function get_group_results_by_tag($id, $group_id){
        $group = new ClipitGroup($group_id);
        $user_results = array();
        foreach($group->user_array as $user_id){
            $user_results[$user_id] = static::get_user_results_by_tag($id, $user_id);
        }
        $group_results = array();
        $user_count = 0;
        foreach($user_results as $user=>$results){
            if(empty($results)){
                continue;
            }
            $user_count++;
            foreach($results as $tag_id=>$result){
                if(!isset($group_results[$tag_id])){
                    $group_results[$tag_id] = (float)0.0;
                }
                $group_results[$tag_id] += $result;
            }
        }
        foreach($group_results as $tag_id=>$result){
            $group_results[$tag_id] = (float)$result/$user_count;
        }
        ksort($group_results);
        return $group_results;
    }

    /**
     * Returns the average results by Tag for a Quiz among all the results. Results from students who have not finished
     * the Quiz will not be counted.
     *
     * @param int $id Quiz ID
     * @return array Array of $tag_id=>$result where the result is a float from 0 to 1. Empty array of there are no
     * results for the Quiz.
     */
    static function get_quiz_results_by_tag($id){
        $task_id = static::get_task($id);
        $activity_id = ClipitTask::get_activity($task_id);
        $user_array = ClipitActivity::get_students($activity_id);
        $user_results = array();
        foreach($user_array as $user_id){
            $user_results[$user_id] = static::get_user_results_by_tag($id, $user_id);
        }
        $quiz_results = array();
        $user_count = 0;
        foreach($user_results as $user=>$results){
            if(empty($results)){
                continue;
            }
            $user_count++;
            foreach($results as $tag_id=>$result){
                if(!isset($quiz_results[$tag_id])){
                    $quiz_results[$tag_id] = (float)0.0;
                }
                $quiz_results[$tag_id] += $result;
            }
        }
        foreach($quiz_results as $tag_id=>$result){
            $quiz_results[$tag_id] = (float)$result/$user_count;
        }
        ksort($quiz_results);
        return $quiz_results;
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
        return UBCollection::add_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION, true);
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
        return UBCollection::set_items($id, $question_array, static::REL_QUIZ_QUIZQUESTION, true);
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

    static function export_to_excel($id){
        $ROW_HEIGHT = -1;
        $ROW_WIDTH = 30;
        $H_ALIGN = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
        $WRAP_TEXT = true;

        $quiz = static::get_by_id(array($id));
        if(empty($quiz)){
            return null;
        }
        $quiz = array_pop($quiz);
        $task_id = ClipitQuiz::get_task($id);
        $activity_id = ClipitTask::get_activity($task_id);
        $user_ids = ClipitActivity::get_students($activity_id);
        $quiz_question_array = ClipitQuizQuestion::get_by_id(ClipitQuiz::get_quiz_questions($id));

        // New Excel object
        $php_excel = new PHPExcel();

        // Set document properties
        $php_excel->getProperties()->setCreator(elgg_echo("clipit:quiz:export:creator"))
            ->setTitle(elgg_echo("clipit:quiz:export:title") . " - " . $quiz->name)
            ->setKeywords(elgg_echo("clipit:quiz:export:keywords"));

        // Set Scores sheet properties
        $sheet_0 = $php_excel->getSheet(0);
        $sheet_0->setTitle(elgg_echo("clipit:quiz:export:scores"));
        $sheet_0->getStyle('A1:Z1000')->getAlignment()->setHorizontal($H_ALIGN);
        $sheet_0->getDefaultStyle()->getAlignment()->setWrapText($WRAP_TEXT);
        $sheet_0->getDefaultRowDimension()->setRowHeight($ROW_HEIGHT);
        $sheet_0->getDefaultColumnDimension()->setWidth($ROW_WIDTH);



        // Quiz info title row
        $col_0 = 0; $row_0 = 1;
        $sheet_0->getStyle("A".$row_0.":Z".$row_0)->getFont()->setBold(true);
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:quiz_name"));
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:tricky_topic"));
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:max_time"));

        // Quiz info
        $col_0=0; $row_0++;
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, $quiz->name);
        $tricky_topic = ClipitTrickyTopic::get_by_id(array($quiz->tricky_topic));
        if(!empty($tricky_topic)) {
            $tricky_topic = array_pop($tricky_topic);
            $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, $tricky_topic->name);
        } else{
            $col_0++;
        }
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, ((int)$quiz->max_time)/60);

        // Student Scores title row
        $col_0 = 0; $row_0 += 2;
        $sheet_0->getStyle("A".$row_0.":Z".$row_0)->getFont()->setBold(true);
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:student_name"));
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:num_correct"));
        $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, elgg_echo("clipit:quiz:export:score"));

        // Student Scores
        $col_0 = 0; $row_0++;
        foreach($user_ids as $user_id){
            $pv_array = ClipitUser::get_properties($user_id, array("name"));
            $user_names[$user_id] = $pv_array["name"];
            $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, $pv_array["name"]);
            $results_by_question = ClipitQuiz::get_user_results_by_question($id, $user_id);
            $total_correct = 0;
            foreach($results_by_question as $question_id => $result){
                $total_correct += (int)$result;
            }
            $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, $total_correct.elgg_echo("clipit:quiz:export:out_of").count($quiz->quiz_question_array));
            $percentage = (float)($total_correct / count($quiz->quiz_question_array) * 100.0);
            $percentage = round($percentage, 2);
            $sheet_0->setCellValueByColumnAndRow($col_0++, $row_0, $percentage."%");
            $col_0 = 0; $row_0++;
        }

        // Set Answers sheet properties
        $sheet_1 = $php_excel->createSheet(1);
        $sheet_1->setTitle(elgg_echo("clipit:quiz:export:answers"));
        $sheet_1->getStyle('A1:Z1000')->getAlignment()->setHorizontal($H_ALIGN);
        $sheet_1->getDefaultStyle()->getAlignment()->setWrapText($WRAP_TEXT);
        $sheet_1->getDefaultRowDimension()->setRowHeight($ROW_HEIGHT);
        $sheet_1->getDefaultColumnDimension()->setWidth($ROW_WIDTH);

        // Quiz Questions header
        $col_1 = 0; $row_1 = 1;
        $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFont()->setBold(true);
        $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, elgg_echo("clipit:quiz:export:question_number"));
        $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFont()->setBold(true);
        $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, elgg_echo("clipit:quiz:export:question_title"));
        $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFont()->setBold(true);
        $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, elgg_echo("clipit:quiz:export:correct_answer"));
        $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFont()->setBold(true);
        $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, elgg_echo("clipit:quiz:export:student_name"));

        /// Quiz Questions
        $col_1 = 1; $row_1 = 1;
        foreach($quiz_question_array as $quiz_question){
            $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, (int)$quiz_question->order);
            $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, (string)$quiz_question->name);
            $correct_answer = "";
            switch($quiz_question->option_type){
                case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                case ClipitQuizQuestion::TYPE_SELECT_ONE:
                    $i = 0;
                    $multi = false;
                    $num_options = count($quiz_question->option_array);
                    while($i < $num_options){
                        if($quiz_question->validation_array[$i]){
                            if($multi) {
                                $correct_answer = $correct_answer."\n ";
                            } else{
                                $multi = true;
                            }
                            $correct_answer = $correct_answer.$quiz_question->option_array[$i];
                        }
                        $i++;
                    }
                    break;
                case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                    if($quiz_question->validation_array[0]){
                        $correct_answer = elgg_echo("clipit:quiz:export:true");
                    } elseif($quiz_question->validation_array[1]){
                        $correct_answer = elgg_echo("clipit:quiz:export:false");
                    } else{
                        $correct_answer = elgg_echo("clipit:quiz:export:undefined");
                    }
                    break;
                case ClipitQuizQuestion::TYPE_NUMBER:
                    $correct_answer = $quiz_question->validation_array[0];
                    break;
                default:
                    $correct_answer = ("<ERROR>");
            }
            $fill_color = new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_GREEN);
            $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFill()->setStartColor($fill_color);
            $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, (string)$correct_answer);
            $sheet_1->setCellValueByColumnAndRow($col_1, $row_1, elgg_echo("clipit:quiz:export:student_answer"));
            $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFont()->setBold(true);
            $col_1++; $row_1 = 1;
        }

        // Student Names
        $col_1 = 0; $row_1 = 5;
        foreach($user_ids as $user_id){
            $sheet_1->setCellValueByColumnAndRow($col_1, $row_1++, $user_names[$user_id]);
        }

        // Student Answers
        $col_1 = 1; $row_1 = 5;
        foreach($user_ids as $user_id){
            foreach($quiz_question_array as $quiz_question){
                $quiz_result = ClipitQuizResult::get_from_question_user($quiz_question->id, $user_id);
                if(empty($quiz_result)){
                    $sheet_1->setCellValueByColumnAndRow($col_1, $row_1, elgg_echo("clipit:quiz:export:not_answered"));
                    $col_1++;
                    continue;
                }
                $answer = "";
                switch($quiz_question->option_type){
                    case ClipitQuizQuestion::TYPE_SELECT_MULTI:
                    case ClipitQuizQuestion::TYPE_SELECT_ONE:
                        $i = 0;
                        $multi = false;
                        $num_options = count($quiz_question->option_array);
                        while($i < $num_options){
                            if($quiz_result->answer[$i]){
                                if($multi) {
                                    $answer = $answer."\n ";
                                } else{
                                    $multi = true;
                                }
                                $answer = $answer.$quiz_question->option_array[$i];
                            }
                            $i++;
                        }
                        break;
                    case ClipitQuizQuestion::TYPE_TRUE_FALSE:
                        if($quiz_result->answer[0]){
                            $answer = elgg_echo("clipit:quiz:export:true");
                        } elseif($quiz_result->answer[1]){
                            $answer = elgg_echo("clipit:quiz:export:false");
                        } else{
                            $answer = elgg_echo("clipit:quiz:export:undefined");
                        }
                        break;
                    case ClipitQuizQuestion::TYPE_NUMBER:
                        $answer = $quiz_result->answer;
                        break;
                    default:
                        $answer = ("<ERROR>");
                }
                $sheet_1->setCellValueByColumnAndRow($col_1, $row_1, (string)$answer);
                if($quiz_result->correct){
                    $fill_color = new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_GREEN);
                } else{
                    $fill_color = new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED);
                }
                $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $sheet_1->getStyleByColumnAndRow($col_1, $row_1)->getFill()->setStartColor($fill_color);
                $col_1++;
            }
            $col_1 = 1; $row_1++;
        }

        // Write to file
        $php_excel->setActiveSheetIndex(0);
        $date_obj = new DateTime();
        $timestamp = $date_obj->getTimestamp();
        $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
        $filename = (string)"/tmp/".$timestamp."_quiz_export.xlsx";
        $objWriter->save($filename);
        return $filename;
    }
}

