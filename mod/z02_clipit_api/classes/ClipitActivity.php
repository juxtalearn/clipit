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
 * Contains all elements required to carry out the JuxtaLearn learning method in which Student work in Groups around a
 * selected Tricky Topic.
 *
 * It contains a list of enrolled/called Students, Groups (that actually participate in the activity), Tasks (set by the
 * teacher/s), support Resources and student Publications.
 *
 * An Activity can have different statuses: "enroll" state, "active" state and "closed" state, marked by start and
 * end dates which define the current status.
 */
class ClipitActivity extends UBItem {
    /**
     * @const string SUBTYPE Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitActivity";
    // Relationship names
    const REL_ACTIVITY_TRICKYTOPIC = "ClipitActivity-ClipitTrickyTopic";
    const REL_ACTIVITY_TEACHER = "ClipitActivity-teacher";
    const REL_ACTIVITY_STUDENT = "ClipitActivity-student";
    const REL_ACTIVITY_GROUP = "ClipitActivity-ClipitGroup";
    const REL_ACTIVITY_TASK = "ClipitActivity-ClipitTask";
    const REL_ACTIVITY_VIDEO = "ClipitActivity-ClipitVideo";
    const REL_ACTIVITY_FILE = "ClipitActivity-ClipitFile";
    // Status values
    const STATUS_ENROLL = "enroll";
    const STATUS_ACTIVE = "active";
    const STATUS_CLOSED = "closed";
    // Grouping modes
    const GROUP_MODE_TEACHER = "teacher";
    const GROUP_MODE_SYSTEM = "system";
    const GROUP_MODE_STUDENT = "student";
    // Activity properties
    public $color = "";
    public $status = "";
    public $tricky_topic = 0;
    public $start = 0;
    public $end = 0;
    public $group_mode = "";
    public $max_group_size = 0;
    public $teacher_array = array();
    public $student_array = array();
    public $group_array = array();
    public $task_array = array();
    // Activity Teacher Resources (cloned from TT Teacher Resources)
    public $video_array = array();
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->color = (string)$elgg_entity->get("color");
        $this->tricky_topic = (int)static::get_tricky_topic($this->id);
        $this->start = (int)$elgg_entity->get("start");
        $this->end = (int)$elgg_entity->get("end");
        $this->group_mode = (string)$elgg_entity->get("group_mode");
        $this->max_group_size = (int)$elgg_entity->get("max_group_size");
        $this->status = (string)static::calc_status($this->start, $this->end);
        $this->teacher_array = static::get_teachers($this->id);
        $this->student_array = static::get_students($this->id);
        $this->group_array = static::get_groups($this->id);
        $this->task_array = static::get_tasks($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
    }

    /**
     * Calculate the Activity Status depending on the current date, and the Start and End of the activity.
     *
     * @param int $start Activity Start timestamp
     * @param int $end   Activity End timestamp
     *
     * @return string The status of the activity: STATUS_ENROLL, STATUS_ACTIVE or STATUS_CLOSED
     */
    private function calc_status($start, $end) {
        $date = new DateTime();
        $now = (int)$date->getTimestamp();
        if($now < $start) {
            return static::STATUS_ENROLL;
        } elseif($now >= $start && $now <= $end) {
            return static::STATUS_ACTIVE;
        } else {
            return static::STATUS_CLOSED;
        }
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        if(!empty($this->color)) {
            $elgg_entity->set("color", (string)$this->color);
        } else {
            $elgg_entity->set("color", $this->get_rand_color());
        }
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
        $elgg_entity->set("group_mode", (string)$this->group_mode);
        $elgg_entity->set("max_group_size", (int)$this->max_group_size);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_tricky_topic($this->id, (int)$this->tricky_topic);
        static::set_teachers($this->id, $this->teacher_array);
        static::set_students($this->id, $this->student_array);
        static::set_groups($this->id, $this->group_array);
        static::set_tasks($this->id, $this->task_array);
        static::set_videos($this->id, $this->video_array);
        static::set_files($this->id, $this->file_array);
        return $this->id;
    }

    static function get_tricky_topic($id) {
        $ret_array = UBCollection::get_items($id, static::REL_ACTIVITY_TRICKYTOPIC);
        if(!empty($ret_array)){
            return array_pop($ret_array);
        }
        return 0;
    }

    static function set_tricky_topic($id, $tricky_topic) {
        return UBCollection::set_items($id, array($tricky_topic), static::REL_ACTIVITY_TRICKYTOPIC);
    }

    /**
     * Returns a random hex color, from a predefined palette, to assign to an Activity
     * @return string Hex color.
     */
    protected function get_rand_color() {
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
        $pos = (int)rand(0, count($color_array)-1);
        return $color_array[$pos];
    }

    /** STATIC FUNCTIONS */
    /**
     * Get the Status for an Activity
     * @param int $id ID of Activity
     *
     * @return string Status
     * @throws InvalidParameterException
     */
    public function get_status($id){
        $prop_value_array = static::get_properties($id, array("status"));
        return $prop_value_array["status"];
    }
    /**
     * Returns the Activities where a User has been called in, or has joined.
     *
     * @param int  $user_id     ID of the User to get Activities from
     * @param bool $joined_only Only return Activities where the User has joined to a Group
     *
     * @return static[] Array of Activities
     */
    static function get_from_user($user_id, $joined_only = false) {
        $activity_id_array = ClipitUser::get_activities($user_id, $joined_only);
        $activity_array = array();
        foreach($activity_id_array as $activity_id) {
            $activity_array[$activity_id] = new static($activity_id);
        }
        return $activity_array;
    }

    static function get_from_tricky_topic($tricky_topic_id) {
        $id_array = UBCollection::get_items($tricky_topic_id, static::REL_ACTIVITY_TRICKYTOPIC, true);
        $activity_array = array();
        foreach($id_array as $activity_id) {
            $activity_array[] = new static($activity_id);
        }
        return $activity_array;
    }

    // TEACHERS
    static function add_teachers($id, $teacher_array) {
        return UBCollection::add_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function set_teachers($id, $teacher_array) {
        return UBCollection::set_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function remove_teachers($id, $teacher_array) {
        return UBCollection::remove_items($id, $teacher_array, static::REL_ACTIVITY_TEACHER);
    }

    static function get_teachers($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_TEACHER);
    }

    // STUDENTS
    static function add_students($id, $user_array) {
        return UBCollection::add_items($id, $user_array, static::REL_ACTIVITY_STUDENT);
    }

    static function set_students($id, $user_array) {
        return UBCollection::set_items($id, $user_array, static::REL_ACTIVITY_STUDENT);
    }

    static function remove_students($id, $user_array) {
        return UBCollection::remove_items($id, $user_array, static::REL_ACTIVITY_STUDENT);
    }

    static function get_students($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_STUDENT);
    }

    // GROUPS
    static function add_groups($id, $group_array) {
        return UBCollection::add_items($id, $group_array, static::REL_ACTIVITY_GROUP, true);
    }

    static function set_groups($id, $group_array) {
        return UBCollection::set_items($id, $group_array, static::REL_ACTIVITY_GROUP, true);
    }

    static function remove_groups($id, $group_array) {
        return UBCollection::remove_items($id, $group_array, static::REL_ACTIVITY_GROUP);
    }

    static function get_groups($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_GROUP);
    }

    // TASKS
    static function add_tasks($id, $task_array) {
        return UBCollection::add_items($id, $task_array, static::REL_ACTIVITY_TASK, true);
    }

    static function set_tasks($id, $task_array) {
        return UBCollection::set_items($id, $task_array, static::REL_ACTIVITY_TASK, true);
    }

    static function remove_tasks($id, $task_array) {
        return UBCollection::remove_items($id, $task_array, static::REL_ACTIVITY_TASK);
    }

    static function get_tasks($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_TASK);
    }

    // TEACHER RESOURCE VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_ACTIVITY_VIDEO);
    }

    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_VIDEO);
    }

    // TEACHER RESOURCE FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_ACTIVITY_FILE);
    }

    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_ACTIVITY_FILE);
    }

    /**
     * Gets all published files from the Tasks contained inside an Activity
     *
     * @param int $id Activity ID
     *
     * @return ClipitFile[] Array of file objects
     */
    static function get_published_files($id) {
        $tasks = static::get_tasks($id);
        $file_array = array();
        foreach($tasks as $task_id) {
            $file_array = array_merge($file_array, ClipitTask::get_files($task_id));
        }
        return $file_array;
    }

    /**
     * Gets all published Videos from the Tasks contained inside an Activity
     *
     * @param int $id Activity ID
     *
     * @return ClipitVideo[] Array of Videos
     */
    static function get_published_videos($id) {
        $tasks = static::get_tasks($id);
        $video_array = array();
        foreach($tasks as $task_id) {
            $video_array = array_merge($video_array, ClipitTask::get_videos($task_id));
        }
        return $video_array;
    }
}