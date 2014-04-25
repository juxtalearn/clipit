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
     * @const string SUBTYPE Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_activity";

    const REL_ACTIVITY_USER = "activity-user";
    const REL_ACTIVITY_GROUP = "activity-group";
    const REL_ACTIVITY_TASK = "activity-task";
    const REL_ACTIVITY_VIDEO = "activity-video";
    const REL_ACTIVITY_FILE = "activity-file";

    const STATUS_ENROLL = "enroll";
    const STATUS_ACTIVE = "active";
    const STATUS_CLOSED = "closed";

    public $color = "";
    public $status = "";
    public $called_users_array = array();
    public $group_array = array();
    public $task_array = array();
    public $video_array = array();
    public $file_array = array();

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->color = (string)$elgg_object->color;
        $this->status = (string)$elgg_object->status;
        $this->called_users_array = static::get_called_users($this->id, $this->called_users_array);
        $this->group_array = static::get_groups($this->id);
        $this->task_array = static::get_tasks($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
    }
    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->color = (string)$this->color;
        $elgg_object->status = (string)$this->status;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->id = $elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::add_called_users($this->id, $this->called_users_array);
        static::add_groups($this->id, $this->group_array);
        static::add_tasks($this->id, $this->task_array);
        static::add_videos($this->id, $this->video_array);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        foreach($rel_array as $rel){
            switch($rel->relationship){
                case ClipitActivity::REL_ACTIVITY_GROUP:
                    $group_array[] = $rel->guid_two;
                    break;
                case ClipitActivity::REL_ACTIVITY_TASK:
                    $task_array[] = $rel->guid_two;
                    break;
                case ClipitActivity::REL_ACTIVITY_VIDEO:
                    $video_array[] = $rel->guid_two;
                    break;
                case ClipitActivity::REL_ACTIVITY_FILE:
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

    /** STATIC FUNCTIONS */

    static function get_status($id){
        return ClipitActivity::get_properties($id, array("status"));
    }

    static function set_status_enroll($id){
        $prop_value_array["status"] = ClipitActivity::STATUS_ENROLL;
        return ClipitActivity::set_properties($id, $prop_value_array);
    }

    static function set_status_active($id){
        $prop_value_array["status"] = ClipitActivity::STATUS_ACTIVE;
        return ClipitActivity::set_properties($id, $prop_value_array);
    }

    static function set_status_closed($id){
        $prop_value_array["status"] = ClipitActivity::STATUS_CLOSED;
        return ClipitActivity::set_properties($id, $prop_value_array);
    }

    static function get_from_user($user_id){
        if(!$group_ids = ClipitUser::get_groups($user_id)){
            return false;
        }
        foreach($group_ids as $group_id){
            $activity_ids[] = ClipitGroup::get_activity($group_id);
        }
        if(!isset($activity_ids)){
            return false;
        }
        return ClipitActivity::get_by_id($activity_ids);
    }

    // USERS
    static function add_called_users($id, $user_array){
        return UBCollection::add_items($id, $user_array, ClipitActivity::REL_ACTIVITY_USER);
    }

    static function remove_called_users($id, $user_array){
        return UBCollection::remove_items($id, $user_array, ClipitActivity::REL_ACTIVITY_USER);
    }

    static function get_called_users($id){
        return UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_USER);
    }

    // GROUPS
    static function add_groups($id, $group_array){
        return UBCollection::add_items($id, $group_array, ClipitActivity::REL_ACTIVITY_GROUP, true);
    }

    static function remove_groups($id, $group_array){
        return UBCollection::remove_items($id, $group_array, ClipitActivity::REL_ACTIVITY_GROUP);
    }

    static function get_groups($id){
        return UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_GROUP);
    }

    // TASKS
    static function add_tasks($id, $task_array){
        return UBCollection::add_items($id, $task_array, ClipitActivity::REL_ACTIVITY_TASK, true);
    }

    static function remove_tasks($id, $task_array){
        return UBCollection::remove_items($id, $task_array, ClipitActivity::REL_ACTIVITY_TASK);
    }

    static function get_tasks($id){
        return UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_TASK);
    }

    // VIDEOS
    static function add_videos($id, $video_array){
        return UBCollection::add_items($id, $video_array, ClipitActivity::REL_ACTIVITY_VIDEO);
    }

    static function remove_videos($id, $video_array){
        return UBCollection::remove_items($id, $video_array, ClipitActivity::REL_ACTIVITY_VIDEO);
    }

    static function get_videos($id){
        return UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_VIDEO);
    }

    // FILES
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, ClipitActivity::REL_ACTIVITY_FILE);
    }

    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, ClipitActivity::REL_ACTIVITY_FILE);
    }

    static function get_files($id){
        return UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_FILE);
    }
}