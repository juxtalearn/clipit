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
 * Class ClipitTask
 */
class ClipitTask extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTask";

    // Task types
    const TYPE_QUIZ_ANSWER = "quiz_answer";
    const TYPE_STORYBOARD_UPLOAD = "storyboard_upload";
    const TYPE_VIDEO_UPLOAD = "video_upload";
    const TYPE_STORYBOARD_FEEDBACK = "storyboard_feedback";
    const TYPE_VIDEO_FEEDBACK = "video_feedback";
    const TYPE_OTHER = "other";

    const REL_TASK_STORYBOARD = "task-storyboard";
    const REL_TASK_VIDEO = "task-video";
    const REL_TASK_FILE = "task-file";
    const REL_TASK_QUIZ = "task-quiz";

    public $task_type = "";
    public $start = 0;
    public $end = 0;
    public $parent_task = 0;
    public $task_count = 0;

    public $activity = 0;
    public $storyboard_array = array();
    public $video_array = array();
    public $file_array = array();
    public $quiz_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->task_type = (string)$elgg_entity->get("task_type");
        $this->start = (int)$elgg_entity->get("start");
        $this->end = (int)$elgg_entity->get("end");
        $this->parent_task = (int)$elgg_entity->get("parent_task");
        $this->task_count = (int)$elgg_entity->get("task_count");
        if($this->end == 0){
            $activity_id = static::get_activity($this->id);
            if(!empty($activity_id)){
                $prop_value_array = (int) ClipitActivity::get_properties($activity_id, array("deadline"));
                $this->end = $prop_value_array["deadline"];
            }
        }
        $this->activity = static::get_activity((int)$this->id);
        $this->storyboard_array = static::get_storyboards((int)$this->id);
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
        $this->quiz_array = static::get_quizzes($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_entity){
        parent::save_to_elgg($elgg_entity);
        $elgg_entity->set("task_type", (string)$this->task_type);
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
        $elgg_entity->set("parent_task", (int)$this->parent_task);
        $elgg_entity->set("task_count", (int)$this->task_count);
    }

    protected function save(){
        parent::save();
        static::set_activity($this->id, $this->activity);
        static::set_storyboards($this->id, $this->storyboard_array);
        static::set_videos($this->id, $this->video_array);
        static::set_files($this->id, $this->file_array);
        static::set_quizzes($this->id, $this->quiz_array);
        return $this->id;
    }

    // ACTIVITY
    /**
     * Get the Activity Id in which a Task is contained in.
     *
     * @param int $id Id of the Task to get Activity from.
     *
     * @return int Returns an the Activity Id for the Task.
     */
    static function get_activity($id){
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_pop($activity);
    }

    static function set_activity($id, $activity_id){
        return UBCollection::add_items($activity_id, array($id), ClipitActivity::REL_ACTIVITY_TASK, true);

    }

    // STORYBOARDS
    static function add_storyboards($id, $storyboard_array){
        return UBCollection::add_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array){
        return UBCollection::set_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array){
        return UBCollection::remove_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function get_storyboards($id){
        return UBCollection::get_items($id, static::REL_TASK_STORYBOARD);
    }

    // VIDEOS
    static function add_videos($id, $video_array){
        return UBCollection::add_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function set_videos($id, $video_array){
        return UBCollection::set_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function remove_videos($id, $video_array){
        return UBCollection::remove_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function get_videos($id){
        return UBCollection::get_items($id, static::REL_TASK_VIDEO);
    }

    // FILES
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function set_files($id, $file_array){
        return UBCollection::set_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function get_files($id){
        return UBCollection::get_items($id, static::REL_TASK_FILE);
    }

    // QUIZZES
    static function add_quizzes($id, $quiz_array){
        return UBCollection::add_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function set_quizzes($id, $quiz_array){
        return UBCollection::set_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function remove_quizzes($id, $quiz_array){
        return UBCollection::remove_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function get_quizzes($id){
        return UBCollection::get_items($id, static::REL_TASK_QUIZ);
    }
} 