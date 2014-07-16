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
 * Class ClipitGroup

 */
class ClipitGroup extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitGroup";
    const REL_GROUP_USER = "group-user";
    const REL_GROUP_FILE = "group-file";
    const REL_GROUP_STORYBOARD = "group-storyboard";
    const REL_GROUP_VIDEO = "group-video";
    public $user_array = array();
    public $file_array = array();
    public $storyboard_array = array();
    public $video_array = array();
    public $activity = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity) {
        parent::load_from_elgg($elgg_entity);
        $this->user_array = static::get_users($this->id);
        $this->file_array = static::get_files($this->id);
        $this->storyboard_array = static::get_storyboards($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->activity = static::get_activity($this->id);
    }

    /**
     * Saves this instance to the system.
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save() {
        parent::save();
        static::set_users($this->id, $this->user_array);
        static::set_files($this->id, $this->file_array);
        static::set_videos($this->id, $this->video_array);
        static::set_storyboards($this->id, $this->storyboard_array);
        if($this->activity != 0) {
            ClipitActivity::add_groups($this->activity, array($this->id));
        }
        return $this->id;
    }

    /**
     * Returns the Group where a User is taking part in an Activity
     *
     * @param int $user_id     User ID
     * @param int $activity_id Activity ID
     *
     * @return bool|int Returns the Group ID, or false if not found
     */
    static function get_from_user_activity($user_id, $activity_id) {
        $user_groups = array_flip(ClipitUser::get_groups($user_id));
        $activity_groups = array_flip(ClipitActivity::get_groups($activity_id));
        $intersection = array_flip(array_intersect_key($user_groups, $activity_groups));
        if(empty($intersection) || count($intersection) != 1) {
            return false;
        }
        return (int)array_pop($intersection);
    }

    /**
     * Gets the Activity Id in which a Group takes part in.
     *
     * @param int $id Id from the Group.
     *
     * @return bool|int Returns an Activity Id.
     */
    static function get_activity($id) {
        $temp_array = get_entity_relationships($id, true);
        foreach($temp_array as $rel) {
            if($rel->relationship == ClipitActivity::REL_ACTIVITY_GROUP) {
                $rel_array[] = $rel;
            }
        }
        if(!isset($rel_array) || count($rel_array) != 1) {
            return false;
        }
        return array_pop($rel_array)->guid_one;
    }

    /**
     * Add Users to a Group.
     *
     * @param int   $id         Id of the Group to add Users to.
     * @param array $user_array Array of User Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_users($id, $user_array) {
        return UBCollection::add_items($id, $user_array, static::REL_GROUP_USER);
    }

    static function set_users($id, $user_array) {
        return UBCollection::set_items($id, $user_array, static::REL_GROUP_USER);
    }

    /**
     * Remove Users from a Group.
     *
     * @param int   $id         Id of the Group to remove Users from.
     * @param array $user_array Array of User Ids to remove from the Group.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_users($id, $user_array) {
        return UBCollection::remove_items($id, $user_array, static::REL_GROUP_USER);
    }

    /**
     * Get User Ids from a Group.
     *
     * @param int $id Id of the Group to get Users from.
     *
     * @return bool Returns array of User Ids, or false if error.
     */
    static function get_users($id) {
        return UBCollection::get_items($id, static::REL_GROUP_USER);
    }

    /**
     * Add Files to a Group.
     *
     * @param int   $id         Id of the Group to add Files to.
     * @param array $file_array Array of File Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_GROUP_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_GROUP_FILE);
    }

    /**
     * Remove Files from a Group.
     *
     * @param int   $id         Id of the Group to remove Files from.
     * @param array $file_array Array of File Ids to remove from the Group.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_GROUP_FILE);
    }

    /**
     * Get File Ids from a Group.
     *
     * @param int $id Id of the Group to get Files from.
     *
     * @return bool Returns array of User Ids, or false if error.
     */
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_GROUP_FILE);
    }

    /**
     * Add Storyboards to a Group.
     *
     * @param int   $id               Id of the Group to add Storyboards to.
     * @param array $storyboard_array Array of Storyboard Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_GROUP_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_GROUP_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_GROUP_STORYBOARD);
    }

    static function get_storyboards($id) {
        return UBCollection::get_items($id, static::REL_GROUP_STORYBOARD);
    }

    /**
     * Add Videos to a Group.
     *
     * @param int   $id          Id of the Group to add Videos to.
     * @param array $video_array Array of Video Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    /**
     * Remove Videos from a Group.
     *
     * @param int   $id          Id of the Group to remove Videos from.
     * @param array $video_array Array of Video Ids to remove from the Group.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    /**
     * Get Video Ids from a Group.
     *
     * @param int $id Id of the Group to get Videos from.
     *
     * @return bool Returns array of Video Ids, or false if error.
     */
    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_GROUP_VIDEO);
    }
}
