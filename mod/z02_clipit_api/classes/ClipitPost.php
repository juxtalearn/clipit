<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
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
    const REL_MESSAGE_USER = "ClipitPost-ClipitUser";
    const REL_POST_VIDEO = "ClipitPost-ClipitVideo";
    const REL_POST_FILE = "ClipitPost-ClipitFile";
    const REL_POST_TEXT = "ClipitPost-ClipitText";

    public $topic_id = 0;
    public $video_array = array();
    public $file_array = array();
    public $text_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->topic_id = (int)$elgg_entity->get("topic_id");
        $this->file_array = (array)static::get_files((int)$this->id);
        $this->video_array = (array)static::get_videos((int)$this->id);
        $this->text_array = (array)static::get_texts((int)$this->id);
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
        static::set_files($this->id, $this->file_array);
        static::set_videos($this->id, $this->video_array);
        static::set_texts($this->id, $this->text_array);
        return $this->id;
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

    // FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_POST_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_POST_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_POST_FILE);
    }

    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_POST_FILE);
    }

    // TEXTS
    static function add_texts($id, $text_array) {
        return UBCollection::add_items($id, $text_array, static::REL_POST_TEXT);
    }

    static function set_texts($id, $text_array) {
        return UBCollection::set_items($id, $text_array, static::REL_POST_TEXT);
    }

    static function remove_texts($id, $text_array) {
        return UBCollection::remove_items($id, $text_array, static::REL_POST_TEXT);
    }

    static function get_texts($id) {
        return UBCollection::get_items($id, static::REL_POST_TEXT);
    }
}