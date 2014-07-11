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
class ClipitTask extends UBItem {
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
    protected function load_from_elgg($elgg_entity) {
        parent::load_from_elgg($elgg_entity);
        $this->task_type = (string)$elgg_entity->get("task_type");
        $this->start = (int)$elgg_entity->get("start");
        $this->end = (int)$elgg_entity->get("end");
        $this->parent_task = (int)$elgg_entity->get("parent_task");
        $this->task_count = (int)$elgg_entity->get("task_count");
        if($this->end == 0) {
            $activity_id = static::get_activity($this->id);
            if(!empty($activity_id)) {
                $prop_value_array = (int)ClipitActivity::get_properties($activity_id, array("end"));
                $this->end = $prop_value_array["end"];
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
    protected function save_to_elgg($elgg_entity) {
        parent::save_to_elgg($elgg_entity);
        $elgg_entity->set("task_type", (string)$this->task_type);
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
        $elgg_entity->set("parent_task", (int)$this->parent_task);
        $elgg_entity->set("task_count", (int)$this->task_count);
    }

    /**
     * Saves this instance to the system.
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save() {
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
     * Get the Activity in which a Task is contained.
     *
     * @param int $id Id of the Task.
     *
     * @return int Returns an the Activity Id for the Task.
     */
    static function get_activity($id) {
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_pop($activity);
    }

    /**
     * Set the Activity in which a Task is contained.
     *
     * @param int $id          Id of the Task.
     * @param int $activity_id ID of the Activity.
     *
     * @return bool Returns true if OK, or false if error.
     */
    static function set_activity($id, $activity_id) {
        return UBCollection::add_items($activity_id, array($id), ClipitActivity::REL_ACTIVITY_TASK, true);
    }

    // STORYBOARDS
    static function add_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_TASK_STORYBOARD);
    }

    static function get_storyboards($id) {
        return UBCollection::get_items($id, static::REL_TASK_STORYBOARD);
    }

    // VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_TASK_VIDEO);
    }

    // FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_TASK_FILE);
    }

    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_TASK_FILE);
    }

    // QUIZZES
    static function add_quizzes($id, $quiz_array) {
        return UBCollection::add_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function set_quizzes($id, $quiz_array) {
        return UBCollection::set_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function remove_quizzes($id, $quiz_array) {
        return UBCollection::remove_items($id, $quiz_array, static::REL_TASK_QUIZ);
    }

    static function get_quizzes($id) {
        return UBCollection::get_items($id, static::REL_TASK_QUIZ);
    }

    // TASK COMPLETION
    static function get_completed_status($id, $entity_id) {
        $task = new static($id);
        switch($task->task_type) {
            case static::TYPE_QUIZ_ANSWER:
                //@todo: ClipitQuiz::has_answered_quiz($id, $user_id);
                return false;
            case static::TYPE_STORYBOARD_UPLOAD:
                foreach($task->storyboard_array as $storyboard_id) {
                    if((int)ClipitStoryboard::get_group($storyboard_id) === (int)$entity_id) {
                        return true;
                    }
                }
                return false;
            case static::TYPE_STORYBOARD_FEEDBACK:
                $user_ratings = ClipitRating::get_by_owner(array($entity_id));
                $rating_targets = array();
                foreach($user_ratings[$entity_id] as $user_rating) {
                    $rating_targets[] = (int)$user_rating->target;
                }
                $parent_task = new static($task->parent_task);
                foreach($parent_task->storyboard_array as $storyboard_id) {
                    if(array_search((int)$storyboard_id, $rating_targets) === false) {
                        $storyboard_group = (int)ClipitStoryboard::get_group((int)$storyboard_id);
                        $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                        if($storyboard_group !== $user_group) {
                            // at least one of the targets was not rated
                            return false;
                        } // else the user is part of the group who published the storyboard, so no feedback required
                    }
                }
                return true;
            case static::TYPE_VIDEO_UPLOAD:
                foreach($task->video_array as $video_id) {
                    if((int)ClipitVideo::get_group($video_id) === (int)$entity_id) {
                        return true;
                    }
                }
                return false;
            case static::TYPE_VIDEO_FEEDBACK:
                $user_ratings = ClipitRating::get_by_owner(array($entity_id));
                $rating_targets = array();
                foreach($user_ratings[$entity_id] as $user_rating) {
                    $rating_targets[] = (int)$user_rating->target;
                }
                $parent_task = new static($task->parent_task);
                foreach($parent_task->video_array as $video_id) {
                    if(array_search((int)$video_id, $rating_targets) === false) {
                        $video_group = (int)ClipitVideo::get_group((int)$video_id);
                        $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                        if($video_group !== $user_group) {
                            // at least one of the targets was not rated
                            return false;
                        }
                        // else the user is part of the group who published the video, so no feedback required
                    }
                }
                return true;
            default:
                return false;
        }
    }
} 