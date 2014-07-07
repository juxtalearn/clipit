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
 * Class ClipitActivity
 *
 * Represents a JuxtaLearn cycle of tasks around a selected Tricky Tipic. It contains users (which
 * have been called to join the activity), groups (that actually participate in the activity),
 * tasks (set by the teacher/s), videos and files.
 *
 * An Activity can have different status: enroll state, active state and closed state.
 *
 */
class ClipitActivity extends UBItem{
    /**
     * @const string SUBTYPE Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitActivity";
    // Relationship names
    const REL_ACTIVITY_TEACHER = "activity-teacher";
    const REL_ACTIVITY_USER = "activity-user";
    const REL_ACTIVITY_GROUP = "activity-group";
    const REL_ACTIVITY_TASK = "activity-task";
    const REL_ACTIVITY_STORYBOARD = "activity-storyboard";
    const REL_ACTIVITY_VIDEO = "activity-video";
    const REL_ACTIVITY_FILE = "activity-file";
    // Status values
    const STATUS_ENROLL = "enroll";
    const STATUS_ACTIVE = "active";
    const STATUS_CLOSED = "closed";
    // Class variables
    public $color = "";
    public $status = "";
    public $tricky_topic = 0;
    public $start = 0;
    public $end = 0;
    public $teacher_array = array();
    public $called_users_array = array();
    public $group_array = array();
    public $task_array = array();
    public $storyboard_array = array();
    public $video_array = array();
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->color = (string)$elgg_entity->get("color");
        $this->tricky_topic = (int)$elgg_entity->get("tricky_topic");
        $this->status = static::get_status($this->id);
        $this->start = (int)$elgg_entity->get("start");
        $this->end = (int)$elgg_entity->get("end");
        $this->teacher_array = static::get_teachers($this->id);
        $this->called_users_array = static::get_called_users($this->id);
        $this->group_array = static::get_groups($this->id);
        $this->task_array = static::get_tasks($this->id);
        $this->storyboard_array = static::get_storyboards($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_entity){
        parent::save_to_elgg($elgg_entity);
        if(!empty($this->color)) {
            $elgg_entity->set("color", (string)$this->color);
        } else{
            $elgg_entity->set("color", $this->get_rand_color());
        }
        $elgg_entity->set("tricky_topic", (int)$this->tricky_topic);
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
    }

    /**
     * Saves this instance into the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        parent::save();
        static::set_teachers($this->id, $this->teacher_array);
        static::set_called_users($this->id, $this->called_users_array);
        static::set_groups($this->id, $this->group_array);
        static::set_tasks($this->id, $this->task_array);
        static::set_storyboards($this->id, $this->storyboard_array);
        static::set_videos($this->id, $this->video_array);
        static::set_files($this->id, $this->file_array);
        return $this->id;
    }

    /**
     * Deletes $this instance from the system.
     *
     * @return bool True if success, false if error.
     */
    protected function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        foreach($rel_array as $rel){
            switch($rel->relationship){
                case static::REL_ACTIVITY_GROUP:
                    $group_array[] = $rel->guid_two;
                    break;
                case static::REL_ACTIVITY_TASK:
                    $task_array[] = $rel->guid_two;
                    break;
                case static::REL_ACTIVITY_VIDEO:
                    $video_array[] = $rel->guid_two;
                    break;
                case static::REL_ACTIVITY_FILE:
                    $file_array[] = $rel->guid_two;
                    break;
            }
        }
        if(isset($group_array)){
            ClipitGroup::delete_by_id($group_array);
        }
        if(isset($task_array)){
            ClipitTask::delete_by_id($task_array);
        }
        if(isset($video_array)){
            ClipitVideo::delete_by_id($video_array);
        }
        if(isset($file_array)){
            ClipitFile::delete_by_id($file_array);
        }
        parent::delete();
    }

    /**
     * Returns a random hex color, from a predefined palette, to assign to an Activity
     *
     * @return string Hex color.
     */
    protected function get_rand_color(){
        $color_array = array(
            "E7DF1A", // yellow
            "98BF0E", // light green
            "ED1E79", // pink
            "4174B5", // purple
            "EC7227", // orange
            "019B67", // dark green
            "E4391B", // red
            "14B8DD", // light blue
        );
        $pos = (int) rand(0, count($color_array));
        return $color_array[$pos];
    }

    /** STATIC FUNCTIONS */
    /**
     * Returns the Activities where a User has been called in, or has joined.
     *
     * @param int $user_id ID of the User to get Activities from
     * @param bool $joined_only Only return Activities where the User has joined to a Group
     * @return static[] Array of Activities
     */
    static function get_from_user($user_id, $joined_only = false){
        $activity_id_array = ClipitUser::get_activities($user_id, $joined_only);
        $activity_array = array();
        foreach($activity_id_array as $activity_id){
            $activity_array[$activity_id] = new static($activity_id);
        }
        return $activity_array;
    }

    static function get_from_tricky_topic($tricky_topic_id){
        $elgg_objects = elgg_get_entities_from_metadata(
            array(
                'type' => static::TYPE,
                'subtype' => static::SUBTYPE,
                'metadata_names' => array("tricky_topic"),
                'metadata_values' => array($tricky_topic_id),
                'limit' => 0
            )
        );
        if(!empty($elgg_objects)){
            $activity_array = array();
        } else{
            return null;
        }
        foreach($elgg_objects as $elgg_object){
            $activity_array[] = new static($elgg_object->guid);
        }
        return $activity_array;
    }

    /**
     * Get the Activity Status depending on the current date, and the Start and End of the activity.
     * @param int $id Activity ID
     * @return string The status of the activity: STATUS_ENROLL, STATUS_ACTIVE or STATUS_CLOSED
     */
    static function get_status($id){
        $prop_value_array = static::get_properties($id, array("start", "end"));
        $start = (int)$prop_value_array["start"];
        $end = (int)$prop_value_array["end"];
        $date = new DateTime();
        $now = (int)$date->getTimestamp();
        if($now < $start){
            return static::STATUS_ENROLL;
        } elseif($now >= $start && $now <= $end){
            return static::STATUS_ACTIVE;
        } else{
            return static::STATUS_CLOSED;
        }
    }

    // TEACHERS
    static function add_teachers($id, $teacher_array){
        return UBCollection::add_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function set_teachers($id, $teacher_array){
        return UBCollection::set_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function remove_teachers($id, $teacher_array){
        return UBCollection::remove_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function get_teachers($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_TEACHER);
    }

    // CALLED USERS
    static function add_called_users($id, $user_array){
        return UBCollection::add_items($id, $user_array, static::REL_ACTIVITY_USER);
    }

    static function set_called_users($id, $user_array){
        return UBCollection::set_items($id, $user_array, static::REL_ACTIVITY_USER);
    }

    static function remove_called_users($id, $user_array){
        return UBCollection::remove_items($id, $user_array, static::REL_ACTIVITY_USER);
    }

    static function get_called_users($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_USER);
    }

    // GROUPS
    static function add_groups($id, $group_array){
        return UBCollection::add_items($id, $group_array, static::REL_ACTIVITY_GROUP, true);
    }

    static function set_groups($id, $group_array){
        return UBCollection::set_items($id, $group_array, static::REL_ACTIVITY_GROUP, true);
    }

    static function remove_groups($id, $group_array){
        return UBCollection::remove_items($id, $group_array, static::REL_ACTIVITY_GROUP);
    }

    static function get_groups($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_GROUP);
    }

    // TASKS
    static function add_tasks($id, $task_array){
        return UBCollection::add_items($id, $task_array, static::REL_ACTIVITY_TASK, true);
    }

    static function set_tasks($id, $task_array){
        return UBCollection::set_items($id, $task_array, static::REL_ACTIVITY_TASK, true);
    }

    static function remove_tasks($id, $task_array){
        return UBCollection::remove_items($id, $task_array, static::REL_ACTIVITY_TASK);
    }

    static function get_tasks($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_TASK);
    }

    // RESOURCE STORYBOARDS
    static function add_storyboards($id, $storyboard_array){
        return UBCollection::add_items($id, $storyboard_array, static::REL_ACTIVITY_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array){
        return UBCollection::set_items($id, $storyboard_array, static::REL_ACTIVITY_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array){
        return UBCollection::remove_items($id, $storyboard_array, static::REL_ACTIVITY_STORYBOARD);
    }

    static function get_storyboards($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_STORYBOARD);
    }

    // RESOURCE VIDEOS
    static function add_videos($id, $video_array){
        return UBCollection::add_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function set_videos($id, $video_array){
        return UBCollection::set_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function remove_videos($id, $video_array){
        return UBCollection::remove_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function get_videos($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_VIDEO);
    }

    // RESOURCE FILES
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function set_files($id, $file_array){
        return UBCollection::set_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function get_files($id){
        return UBCollection::get_items($id, static::REL_ACTIVITY_FILE);
    }

    // PUBLISHED STORYBOARDS
    /**
     * Gets all published Storyboards from the Tasks contained inside an Activity
     *
     * @param int $id Activity ID
     * @return ClipitStoryboard[] Array of Storyboards
     */
    static function get_published_storyboards($id){
        $tasks = static::get_tasks($id);
        $storyboard_array = array();
        foreach($tasks as $task_id){
            $storyboard_array = array_merge($storyboard_array, ClipitTask::get_storyboards($task_id));
        }
        return $storyboard_array;
    }

    // PUBLISHED VIDEOS
    /**
     * Gets all published Videos from the Tasks contained inside an Activity
     *
     * @param int $id Activity ID
     * @return ClipitVideo[] Array of Videos
     */
    static function get_published_videos($id)
    {
        $tasks = static::get_tasks($id);
        $video_array = array();
        foreach ($tasks as $task_id) {
            $video_array = array_merge($video_array, ClipitTask::get_videos($task_id));
        }
        return $video_array;
    }
}