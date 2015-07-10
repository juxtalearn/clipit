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
 * An atomic set of work which composes activities.
 */
class ClipitTask extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTask";
    // Task types
    const TYPE_QUIZ_TAKE = "quiz_take";
    const TYPE_RESOURCE_DOWNLOAD = "resource_download";
    const TYPE_FILE_UPLOAD = "file_upload";
    const TYPE_FILE_FEEDBACK = "file_feedback";
    const TYPE_VIDEO_UPLOAD = "video_upload";
    const TYPE_VIDEO_FEEDBACK = "video_feedback";
    const TYPE_OTHER = "other";
    // Relationship names
    const REL_TASK_VIDEO = "ClipitTask-ClipitVideo";
    const REL_TASK_FILE = "ClipitTask-ClipitFile";
    const REL_TASK_QUIZ = "ClipitTask-ClipitQuiz";
    const REL_TASK_RUBRIC = "ClipitTask-ClipitRubricItem";
    const REL_PARENTTASK_CHILDTASK = "ClipitTask-ClipitTask";
    // Status values
    const STATUS_LOCKED = "locked";
    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finished";
    // Properties
    public $task_type = "";
    public $start = 0;
    public $end = 0;
    public $status = "";
    public $child_task = 0;
    public $parent_task = 0;
    public $task_count = 0;
    public $activity = 0;
    public $quiz = 0;
    public $rubric = 0;
    // Linked materials
    public $video_array = array();
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->task_type = (string)$elgg_entity->get("task_type");
        $this->start = (int)$elgg_entity->get("start");
        $this->end = (int)$elgg_entity->get("end");
        $this->status = (string)static::calc_status($this->start, $this->end);
        $this->task_count = (int)$elgg_entity->get("task_count");
        if ($this->end == 0) {
            $activity_id = static::get_activity($this->id);
            if (!empty($activity_id)) {
                $prop_value_array = (int)ClipitActivity::get_properties($activity_id, array("end"));
                $this->end = $prop_value_array["end"];
            }
        }
        $this->parent_task = (int)static::get_parent_task($this->id);
        $this->child_task = (int)static::get_child_task($this->id);
        $this->activity = (int)static::get_activity($this->id);
        $this->quiz = (int)static::get_quiz($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
        $this->rubric = (int)static::get_rubric($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("task_type", (string)$this->task_type);
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
        $elgg_entity->set("task_count", (int)$this->task_count);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_parent_task($this->id, $this->parent_task);
        static::set_child_task($this->id, $this->child_task);
        static::set_quiz($this->id, $this->quiz);
        static::set_activity($this->id, $this->activity);
        static::set_videos($this->id, $this->video_array);
        static::set_files($this->id, $this->file_array);
        static::set_rubric($this->id, (int)$this->rubric);
        return $this->id;
    }

    /**
     * Get the Child Task (if any)
     * @param int $id ID of parent task
     * @return int ID of child task
     */
    static function get_child_task($id){
        $task_array = UBCollection::get_items($id, static::REL_PARENTTASK_CHILDTASK);
        return (int)array_pop($task_array);
    }

    /**
     * Set the Child Task
     * @param int $id ID of parent task
     * @param int $child_task ID of child task
     * @return bool Returns true if success, false if error
     */
    static function set_child_task($id, $child_task){
        return UBCollection::set_items($id, array($child_task), static::REL_PARENTTASK_CHILDTASK, true);
    }

    /**
     * Get the Parent Task (if any)
     * @param int $id ID of child task
     * @return int ID of parent task
     */
    static function get_parent_task($id){
        $task_array = UBCollection::get_items($id, static::REL_PARENTTASK_CHILDTASK, true);
        return (int)array_pop($task_array);
    }

    /**
     * Set the Parent Task
     * @param int $id ID of child task
     * @param int $parent_task ID of parent task
     * @return bool Returns true if success, false if error
     */
    static function set_parent_task($id, $parent_task){
        return static::set_child_task($parent_task, $id);
    }

    /**
     * Get the Status for a Task
     * @param int $id ID of Task
     *
     * @return string Status
     * @throws InvalidParameterException
     */
    static function get_status($id)
    {
        $prop_value_array = static::get_properties($id, array("status"));
        return (string)$prop_value_array["status"];
    }

    /**
     * Calculate the Status depending on the current date, and the Start and End of the Task.
     *
     * @param int $start Task Start timestamp
     * @param int $end Task End timestamp
     *
     * @return string The status of the task: STATUS_LOCKED, STATUS_ACTIVE or STATUS_FINISHED
     */
    private function calc_status($start, $end)
    {
        $date = new DateTime();
        $now = (int)$date->getTimestamp();
        if ($now < $start) {
            return static::STATUS_LOCKED;
        } elseif ($now >= $start && $now <= $end) {
            return static::STATUS_ACTIVE;
        } else {
            return static::STATUS_FINISHED;
        }
    }

    static function get_completed_status($id, $entity_id)
    {
        $task = new static((int)$id);
        switch ($task->task_type) {
            case static::TYPE_QUIZ_TAKE:
                return ClipitQuiz::has_finished_quiz($task->quiz, $entity_id);
            case static::TYPE_RESOURCE_DOWNLOAD:
                $latest_timestamp = 0;
                $task_files = $task->file_array;
                foreach ($task_files as $file_id) {
                    $read_status = ClipitFile::get_read_status($file_id, array($entity_id));
                    if ((bool)$read_status[$entity_id] !== true) {
                        return false;
                    }
                    $timestamp = UBCollection::get_timestamp($file_id, $entity_id, ClipitFile::REL_FILE_USER);
                    $latest_timestamp = ($timestamp > $latest_timestamp ? $timestamp : $latest_timestamp);
                }
                $task_videos = $task->video_array;
                foreach ($task_videos as $video_id) {
                    $read_status = ClipitVideo::get_read_status($video_id, array($entity_id));
                    if ((bool)$read_status[$entity_id] !== true) {
                        return false;
                    }
                    $timestamp = UBCollection::get_timestamp($video_id, $entity_id, ClipitVideo::REL_VIDEO_USER);
                    $latest_timestamp = ($timestamp > $latest_timestamp ? $timestamp : $latest_timestamp);
                }
                return $latest_timestamp;
            case static::TYPE_FILE_UPLOAD:
                foreach ($task->file_array as $file_id) {
                    if ((int)ClipitFile::get_group($file_id) === (int)$entity_id) {
                        return true;
                    }
                }
                return false;
            case static::TYPE_FILE_FEEDBACK:
                $parent_task = new static($task->parent_task);
                // If there are no files to give feedback on, the status is false = uncompleted
                if (empty($parent_task->file_array)) {
                    return false;
                }
                $user_ratings = ClipitRating::get_by_owner(array($entity_id));
                $rating_targets = array();
                if (!empty($user_ratings[$entity_id])) {
                    foreach ($user_ratings[$entity_id] as $user_rating) {
                        $rating_targets[] = (int)$user_rating->target;
                    }
                }
                // If the only file was authored by the user's group
                if (count($parent_task->file_array) == 1) {
                    $file_id = array_pop($parent_task->file_array);
                    $file_group = (int)ClipitFile::get_group($file_id);
                    $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                    if ($file_group === $user_group) {
                        return false;
                    }
                    if (array_search((int)$file_id, $rating_targets) === false) {
                        return false;
                    }
                    return true;
                }
                foreach ($parent_task->file_array as $file_id) {
                    if (array_search((int)$file_id, $rating_targets) === false) {
                        $file_group = (int)ClipitFile::get_group((int)$file_id);
                        $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                        if ($file_group !== $user_group) {
                            // at least one of the targets was not rated
                            return false;
                        } // else the user is part of the group who published the file, so no feedback required
                    }
                }
                return true;
            case static::TYPE_VIDEO_UPLOAD:
                foreach ($task->video_array as $video_id) {
                    if ((int)ClipitVideo::get_group($video_id) === (int)$entity_id) {
                        return true;
                    }
                }
                return false;
            case static::TYPE_VIDEO_FEEDBACK:
                $parent_task = new static($task->parent_task);
                // If there are no videos to give feedback on, the status is false = uncompleted
                if (empty($parent_task->video_array)) {
                    return false;
                }
                $user_ratings = ClipitRating::get_by_owner(array($entity_id));
                $rating_targets = array();
                if (!empty($user_ratings[$entity_id])) {
                    foreach ($user_ratings[$entity_id] as $user_rating) {
                        $rating_targets[] = (int)$user_rating->target;
                    }
                }
                // If the only video was authored by the user's group
                if (count($parent_task->video_array) == 1) {
                    $video_id = array_pop($parent_task->video_array);
                    $video_group = (int)ClipitVideo::get_group($video_id);
                    $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                    if ($video_group === $user_group) {
                        return false;
                    }
                    if (array_search((int)$video_id, $rating_targets) === false) {
                        return false;
                    }
                    return true;
                }
                foreach ($parent_task->video_array as $video_id) {
                    if (array_search((int)$video_id, $rating_targets) === false) {
                        $video_group = (int)ClipitVideo::get_group((int)$video_id);
                        $user_group = (int)ClipitGroup::get_from_user_activity($entity_id, $task->activity);
                        if ($video_group !== $user_group) {
                            // at least one of the targets was not rated
                            return false;
                        }
                        // else the user is part of the group who published the video, so no feedback required
                    }
                }
                return true;
            case static::TYPE_OTHER:
                if (static::get_status($id) !== static::STATUS_FINISHED) {
                    return false;
                } else {
                    return true;
                }
            default:
                return false;
        }
    }

    /**
     * Get the Activity in which a Task is contained.
     *
     * @param int $id Id of the Task.
     *
     * @return int Returns an the Activity Id for the Task.
     */
    static function get_activity($id)
    {
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_pop($activity);
    }
    /**
     * Set the Activity in which a Task is contained.
     *
     * @param int $id Id of the Task.
     * @param int $activity_id ID of the Activity.
     *
     * @return bool Returns true if OK, or false if error.
     */
    static function set_activity($id, $activity_id)
    {
        return UBCollection::add_items($activity_id, array($id), ClipitActivity::REL_ACTIVITY_TASK, true);
    }

    // VIDEOS
    static function add_videos($id, $video_array)
    {
        return UBCollection::add_items($id, $video_array, static::REL_TASK_VIDEO);
    }
    static function remove_videos($id, $video_array)
    {
        return UBCollection::remove_items($id, $video_array, static::REL_TASK_VIDEO);
    }
    static function get_videos($id)
    {
        return UBCollection::get_items($id, static::REL_TASK_VIDEO);
    }
    static function set_videos($id, $video_array)
    {
        return UBCollection::set_items($id, $video_array, static::REL_TASK_VIDEO);
    }

    // FILES
    static function add_files($id, $file_array)
    {
        return UBCollection::add_items($id, $file_array, static::REL_TASK_FILE);
    }
    static function remove_files($id, $file_array)
    {
        return UBCollection::remove_items($id, $file_array, static::REL_TASK_FILE);
    }
    static function set_files($id, $file_array)
    {
        return UBCollection::set_items($id, $file_array, static::REL_TASK_FILE);
    }
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_TASK_FILE);
    }

    // RUBRIC
    static function get_rubric($id){
        $item_array =  UBCollection::get_items($id, static::REL_TASK_RUBRIC);
        if(empty($item_array)){
            return 0;
        }
        return (int)array_pop($item_array);
    }
    static function set_rubric($id, $rubric){
        return UBCollection::set_items($id, array($rubric), static::REL_TASK_RUBRIC);
    }

    // QUIZZES
    static function set_quiz($id, $quiz_id){
        return UBCollection::set_items((int)$id, array($quiz_id), static::REL_TASK_QUIZ, true);
    }

    static function get_quiz($id){
        $quiz_array = UBCollection::get_items((int)$id, static::REL_TASK_QUIZ);
        if(empty($quiz_array)) {
            return 0;
        }
        return (int)array_pop($quiz_array);
    }
} 