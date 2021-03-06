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
 * A main topic to explain through videos, which can be decomposed into tags (Stumbling Blocks).
 */
class ClipitTrickyTopic extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTrickyTopic";
    const REL_TRICKYTOPIC_TAG = "ClipitTrickyTopic-ClipitTag";
    const REL_TRICKYTOPIC_FILE = "ClipitTrickyTopic-ClipitFile";
    const REL_TRICKYTOPIC_VIDEO = "ClipitTrickyTopic-ClipitVideo";
    const REL_TRICKYTOPIC_TEXT = "ClipitTrickyTopic-ClipitText";
    const REL_TRICKYTOPIC_EXAMPLE = "ClipitTrickyTopic-ClipitExample";
    const EDUCATION_LEVEL_PRIMARY = "primary";
    const EDUCATION_LEVEL_GCSE = "gcse";
    const EDUCATION_LEVEL_ALEVEL = "alevel";
    const EDUCATION_LEVEL_UNIVERSITY = "university";
    const EDUCATION_LEVEL_SPECIAL = "special";
    const EDUCATION_LEVEL_VOCATIONAL = "vocational";

    public $tag_array = array();
    public $subject = "";
    public $education_level = ""; // one of the EDUCATION_LEVEL_* constants
    // Linked Teacher Material
    public $video_array = array();
    public $file_array = array();
    public $text_array = array();
    // Linked Student Problem Examples
    public $example_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->subject = (string)$elgg_entity->get("subject");
        $this->education_level = (string)$elgg_entity->get("education_level");
        $this->tag_array = (array)static::get_tags((int)$this->id);
        $this->file_array = (array)static::get_files((int)$this->id);
        $this->video_array = (array)static::get_videos((int)$this->id);
        $this->text_array = (array)static::get_texts((int)$this->id);
        $this->example_array = (array)static::get_examples((int)$this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("subject", (string)$this->subject);
        $elgg_entity->set("education_level", (string)$this->education_level);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_tags((int)$this->id, (array)$this->tag_array);
        static::set_files((int)$this->id, (array)$this->file_array);
        static::set_videos((int)$this->id, (array)$this->video_array);
        static::set_texts((int)$this->id, (array)$this->text_array);
        static::set_examples((int)$this->id, (array)$this->example_array);
        return (int)$this->id;
    }

    /**
     * Clones a Tricky Topic, including the contained Stumbling Blocks, teacher Material and Examples
     *
     * @param int $id ID of Tricky Topic to clone
     * @param bool $linked Whether the clone will be linked to the parent object
     * @param bool $keep_owner Selects whether the clone will keep the parent item's owner (default: no)
     * @return bool|int ID of new cloned object
     * @throws InvalidParameterException if error
     */
    static function create_clone($id, $linked = true, $keep_owner = false) {
        $prop_value_array = static::get_properties($id);
        if($keep_owner === false){
            $prop_value_array["owner_id"] = elgg_get_logged_in_user_guid();
        }
        $example_array = $prop_value_array["example_array"];
        if(!empty($example_array)){
            $new_example_array = array();
            foreach($example_array as $example_id){
                $new_example_array[] = ClipitExample::create_clone($example_id);
            }
            $prop_value_array["example_array"] = $new_example_array;
        }
        $clone_id = static::create($prop_value_array);
        if($linked) {
            static::link_parent_clone($id, $clone_id);
        }
        return $clone_id;
    }

    /**
     * Adds Tags to a Tricky Topic, referenced by Id.
     *
     * @param int   $id        Id from the Tricky Topic to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_TRICKYTOPIC_TAG);
    }

    /**
     * Sets Tags to a Tricky Topic, referenced by Id.
     *
     * @param int   $id        Id from the Tricky Topic to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_TRICKYTOPIC_TAG);
    }

    /**
     * Remove Tags from a Tricky Topic.
     *
     * @param int   $id        Id from Tricky Topic to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_TRICKYTOPIC_TAG);
    }

    /**
     * Get all Tags from a Tricky Topic
     *
     * @param int $id Id of the Tricky Topic to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_TRICKYTOPIC_TAG);
    }

    // TEACHER RESOURCES: VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_TRICKYTOPIC_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_TRICKYTOPIC_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_TRICKYTOPIC_VIDEO);
    }

    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_TRICKYTOPIC_VIDEO);
    }

    // TEACHER RESOURCES: FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_TRICKYTOPIC_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_TRICKYTOPIC_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_TRICKYTOPIC_FILE);
    }

    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_TRICKYTOPIC_FILE);
    }

    // TEACHER RESOURCES: TEXTS
    static function add_texts($id, $text_array) {
        return UBCollection::add_items($id, $text_array, static::REL_TRICKYTOPIC_TEXT);
    }

    static function set_texts($id, $text_array) {
        return UBCollection::set_items($id, $text_array, static::REL_TRICKYTOPIC_TEXT);
    }

    static function remove_texts($id, $text_array) {
        return UBCollection::remove_items($id, $text_array, static::REL_TRICKYTOPIC_TEXT);
    }

    static function get_texts($id) {
        return UBCollection::get_items($id, static::REL_TRICKYTOPIC_TEXT);
    }

    // Student Problem Examples
    static function add_examples($id, $example_array) {
        return UBCollection::add_items($id, $example_array, static::REL_TRICKYTOPIC_EXAMPLE, true);
    }

    static function set_examples($id, $example_array) {
        return UBCollection::set_items($id, $example_array, static::REL_TRICKYTOPIC_EXAMPLE, true);
    }

    static function remove_examples($id, $example_array) {
        return UBCollection::remove_items($id, $example_array, static::REL_TRICKYTOPIC_EXAMPLE);
    }

    static function get_examples($id) {
        return UBCollection::get_items($id, static::REL_TRICKYTOPIC_EXAMPLE);
    }
}