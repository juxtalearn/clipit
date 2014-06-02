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
 * Class ClipitStoryboard
 *
 */
class ClipitStoryboard extends UBItem{
    const SUBTYPE = "ClipitStoryboard";

    const REL_STORYBOARD_TAG = "storyboard-tag";
    const REL_STORYBOARD_LABEL = "storyboard-label";
    const REL_STORYBOARD_COMMENT = "storyboard-comment";
    const REL_STORYBOARD_PERFORMANCE = "storyboard-performance";

    public $tag_array = array();
    public $label_array = array();
    public $performance_array = array();
    public $comment_array = array();

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->comment_array = (array)static::get_comments($this->id);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->label_array = (array)static::get_labels($this->id);
        $this->performance_array = (array)static::get_performance_items($this->id);
    }

    protected function save(){
        parent::save();
        static::set_comments($this->id, (array)$this->comment_array);
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_labels($this->id, (array)$this->label_array);
        static::set_performance_items($this->id, (array)$this->performance_array);
        return $this->id;
    }

    static function get_publish_level($id){
        $site = static::get_site($id);
        if(!empty($site)){
            return "site";
        }
        $activity = static::get_activity($id);
        if(!empty($activity)){
            return "activity";
        }
        $group = static::get_group($id);
        if(!empty($group)){
            return "group";
        }
        return null;
    }

    static function get_group($id){
        $storyboard = new static($id);
        if(!empty($storyboard->clone_id)){
            return static::get_group($storyboard->clone_id);
        }
        $group = UBCollection::get_items($id, ClipitGroup::REL_GROUP_STORYBOARD, true);
        return array_pop($group);
    }

    static function get_activity($id){
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_STORYBOARD, true);
        return array_pop($activity);
    }

    static function get_site($id){
        $site = UBCollection::get_items($id, ClipitSite::REL_SITE_STORYBOARD, true);
        return array_pop($site);
    }


    /**
     * Adds Comments to a Storyboard, referenced by Id.
     *
     * @param int   $id Id from the Storyboard to add Comments to
     * @param array $comment_array Array of Comment Ids to be added to the Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function add_comments($id, $comment_array){
        return UBCollection::add_items($id, $comment_array, static::REL_STORYBOARD_COMMENT);
    }

    /**
     * Sets Comments to a Storyboard, referenced by Id.
     *
     * @param int   $id Id from the Storyboard to set Comments to
     * @param array $comment_array Array of Comment Ids to be set to the Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function set_comments($id, $comment_array){
        return UBCollection::set_items($id, $comment_array, static::REL_STORYBOARD_COMMENT);
    }

    /**
     * Remove Comments from a Storyboard.
     *
     * @param int   $id Id from Storyboard to remove Comments from
     * @param array $comment_array Array of Comment Ids to remove from Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_comments($id, $comment_array){
        return UBCollection::remove_items($id, $comment_array, static::REL_STORYBOARD_COMMENT);
    }

    /**
     * Get all Comments for a Storyboard
     *
     * @param int $id Id of the Storyboard to get Comments from
     *
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        return UBCollection::get_items($id, static::REL_STORYBOARD_COMMENT);
    }

    /**
     * Adds Tags to a Storyboard, referenced by Id.
     *
     * @param int   $id Id from the Storyboard to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_STORYBOARD_TAG);
    }

    /**
     * Sets Tags to a Storyboard, referenced by Id.
     *
     * @param int   $id Id from the Storyboard to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_STORYBOARD_TAG);
    }

    /**
     * Remove Tags from a Storyboard.
     *
     * @param int   $id Id from Storyboard to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Storyboard
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_STORYBOARD_TAG);
    }

    /**
     * Get all Tags from a Storyboard
     *
     * @param int $id Id of the Storyboard to get Tags from
     *
     * @return array|bool Returns an array of Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_STORYBOARD_TAG);
    }

    /**
     * Add Labels to a Storyboard.
     *
     * @param int   $id Id of the Storyboard to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Storyboard.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array){
        return UBCollection::add_items($id, $label_array, static::REL_STORYBOARD_LABEL);
    }

    /**
     * Set Labels to a Storyboard.
     *
     * @param int   $id Id of the Storyboard to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Storyboard.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array){
        return UBCollection::set_items($id, $label_array, static::REL_STORYBOARD_LABEL);
    }

    /**
     * Remove Labels from a Storyboard.
     *
     * @param int   $id Id of the Storyboard to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Storyboard.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array){
        return UBCollection::remove_items($id, $label_array, static::REL_STORYBOARD_LABEL);
    }

    /**
     * Get Label Ids from a Storyboard.
     *
     * @param int $id Id of the Storyboard to get Labels from.
     *
     * @return bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id){
        return UBCollection::get_items($id, static::REL_STORYBOARD_LABEL);
    }

    static function add_performance_items($id, $performance_array){
        return UBCollection::add_items($id, $performance_array, static::REL_STORYBOARD_PERFORMANCE);
    }

    static function set_performance_items($id, $performance_array){
        return UBCollection::set_items($id, $performance_array, static::REL_STORYBOARD_PERFORMANCE);
    }

    static function remove_performance_items($id, $performance_array){
        return UBCollection::remove_items($id, $performance_array, static::REL_STORYBOARD_PERFORMANCE);
    }

    static function get_performance_items($id){
        return UBCollection::get_items($id, static::REL_STORYBOARD_PERFORMANCE);
    }

}