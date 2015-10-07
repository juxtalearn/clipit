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
 * A collection of Students contained inside an Activity. Also links to all Group Resources.
 */
class ClipitGroup extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitGroup";
    const REL_GROUP_USER = "ClipitGroup-ClipitUser";
    const REL_GROUP_FILE = "ClipitGroup-ClipitFile";
    const REL_GROUP_VIDEO = "ClipitGroup-ClipitText";
    const REL_GROUP_TEXT = "ClipitGroup-Clipit";
    const REL_GROUP_TAG = "ClipitGroup-ClipitTag";
    public $user_array = array();
    public $file_array = array();
    public $video_array = array();
    public $text_array = array();
    public $tag_array = array();
    public $activity = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->user_array = static::get_users($this->id);
        $this->file_array = static::get_files($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->text_array = static::get_texts($this->id);
        $this->tag_array = static::get_tags($this->id);
        $this->activity = static::get_activity($this->id);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_users($this->id, $this->user_array);
        static::set_files($this->id, $this->file_array);
        static::set_videos($this->id, $this->video_array);
        static::set_texts($this->id, $this->text_array);
        static::set_tags($this->id, $this->tag_array);
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

    // USERS
    static function add_users($id, $user_array) {
        return UBCollection::add_items($id, $user_array, static::REL_GROUP_USER);
    }

    static function set_users($id, $user_array) {
        return UBCollection::set_items($id, $user_array, static::REL_GROUP_USER);
    }

    static function remove_users($id, $user_array) {
        return UBCollection::remove_items($id, $user_array, static::REL_GROUP_USER);
    }

    static function get_users($id) {
        return UBCollection::get_items($id, static::REL_GROUP_USER);
    }

    // FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_GROUP_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_GROUP_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_GROUP_FILE);
    }

    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_GROUP_FILE);
    }

    // VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_GROUP_VIDEO);
    }

    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_GROUP_VIDEO);
    }

    // TEXTS
    static function add_texts($id, $text_array) {
        return UBCollection::add_items($id, $text_array, static::REL_GROUP_TEXT);
    }

    static function set_texts($id, $text_array) {
        return UBCollection::set_items($id, $text_array, static::REL_GROUP_TEXT);
    }

    static function remove_texts($id, $text_array) {
        return UBCollection::remove_items($id, $text_array, static::REL_GROUP_TEXT);
    }

    static function get_texts($id) {
        return UBCollection::get_items($id, static::REL_GROUP_TEXT);
    }

    //TAGS
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_GROUP_TAG);
    }

    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_GROUP_TAG);
    }

    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_GROUP_TAG);
    }

    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_GROUP_TAG);
    }
}
