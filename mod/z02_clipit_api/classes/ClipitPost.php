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
 * A discussion forum Post which can be a topic starter or a reply to another Post. Contains Link to the topic starter
 * Post ID, and may have files and/or Resources as attachments.

 */
class ClipitPost extends UBMessage {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPost";
    const REL_MESSAGE_DESTINATION = "ClipitPost-destination";
    const REL_MESSAGE_FILE = "ClipitPost-ClipitFile";
    const REL_POST_RESOURCE = "ClipitPost-ClipitResource";
    const REL_POST_STORYBOARD = "ClipitPost-ClipitStoryboard";
    const REL_POST_VIDEO = "ClipitPost-ClipitVideo";
    public $topic_id = 0;
    public $resource_array = array();
    public $storyboard_array = array();
    public $video_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->topic_id = (int)$elgg_entity->get("topic_id");
        $this->resource_array = (array)static::get_resources((int)$this->id);
        $this->storyboard_array = (array)static::get_storyboards((int)$this->id);
        $this->video_array = (array)static::get_videos((int)$this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("topic_id", $this->topic_id);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_resources($this->id, $this->resource_array);
        static::set_storyboards($this->id, $this->storyboard_array);
        static::set_videos($this->id, $this->video_array);
        return $this->id;
    }

    // RESOURCES
    static function add_resources($id, $resource_array) {
        return UBCollection::add_items($id, $resource_array, static::REL_POST_RESOURCE);
    }

    static function set_resources($id, $resource_array) {
        return UBCollection::set_items($id, $resource_array, static::REL_POST_RESOURCE);
    }

    static function remove_resources($id, $resource_array) {
        return UBCollection::remove_items($id, $resource_array, static::REL_POST_RESOURCE);
    }

    static function get_resources($id) {
        return UBCollection::get_items($id, static::REL_POST_RESOURCE);
    }

    // STORYBOARDS
    static function add_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function get_storyboards($id) {
        return UBCollection::get_items($id, static::REL_POST_STORYBOARD);
    }

    // VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_POST_VIDEO);
    }
}