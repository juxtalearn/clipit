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
 * An Example experience in which students have trouble understanding a Stumbling Block (or Tag).
 */
class ClipitExample extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitExample";
    const REL_EXAMPLE_TAG = "ClipitExample-ClipitTag";
    const REL_EXAMPLE_REFLECTION_ITEM = "ClipitExample-ClipitReflectionItem";
    const REL_EXAMPLE_RESOURCE = "ClipitExample-ClipitResource";
    const REL_EXAMPLE_STORYBOARD = "ClipitExample-ClipitStoryboard";
    const REL_EXAMPLE_VIDEO = "ClipitExample-ClipitVideo";
    const REL_EXAMPLE_FILE = "ClipitExample-ClipitFile";
    public $tag_array = array();
    public $reflection_item_array = array();
    public $subject = "";
    public $education_level = 0;
    public $country = "";
    public $location = "";
    // Example Resources
    public $resource_array = array();
    public $storyboard_array = array();
    public $video_array = array();
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->reflection_item_array = (array)static::get_reflection_items($this->id);
        $this->subject = (string)$elgg_entity->get("subject");
        $this->education_level = (int)$elgg_entity->get("education_level");
        $this->country = (string)$elgg_entity->get("country");
        $this->location = (string)$elgg_entity->get("location");
        $this->resource_array = static::get_resources($this->id);
        $this->video_array = static::get_videos($this->id);
        $this->storyboard_array = static::get_storyboards($this->id);
        $this->file_array = static::get_files($this->id);
    }

    /**
     * Copy $this object's parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("subject", (string)$this->subject);
        $elgg_entity->set("education_level", (int)$this->education_level);
        $elgg_entity->set("country", (string)$this->country);
        $elgg_entity->set("location", (string)$this->location);
    }

    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_reflection_items($this->id, (array)$this->reflection_item_array);
        static::set_resources($this->id, $this->resource_array);
        static::set_videos($this->id, $this->video_array);
        static::set_storyboards($this->id, $this->storyboard_array);
        static::set_files($this->id, $this->file_array);
        return $this->id;
    }

    static function get_by_tags($tag_array){
        $return_examples = array();
        $example_array = static::get_all(0);
        if(empty($example_array) || empty($tag_array)){
            return $return_examples;
        }
        foreach($example_array as $example){
            foreach($example->tag_array as $tag){
                if(array_search($tag, $tag_array) !== false){
                    $return_examples[] = $example;
                    break;
                }
            }
        }
        return $return_examples;
    }

    /**
     * Adds Tags to an Example, referenced by Id.
     *
     * @param int   $id        Id from the Example to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_EXAMPLE_TAG);
    }

    /**
     * Sets Tags to an Example, referenced by Id.
     *
     * @param int   $id        Id from the Example to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_EXAMPLE_TAG);
    }

    /**
     * Remove Tags from an Example.
     *
     * @param int   $id        Id from Example to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Example
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_EXAMPLE_TAG);
    }

    /**
     * Get all Tags from an Example
     *
     * @param int $id Id of the Example to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_TAG);
    }

    /**
     * Adds Reflection Items to an Example, referenced by Id.
     *
     * @param int   $id        Id from the Example to add Reflection Items to
     * @param array $reflection_item_array Array of Reflection Item Ids to be added to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function add_reflection_items($id, $reflection_item_array) {
        return UBCollection::add_items($id, $reflection_item_array, static::REL_EXAMPLE_REFLECTION_ITEM);
    }

    /**
     * Sets Reflection Items to an Example, referenced by Id.
     *
     * @param int   $id        Id from the Example to set Reflection Items to
     * @param array $reflection_item_array Array of Reflection Item Ids to be set to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function set_reflection_items($id, $reflection_item_array) {
        return UBCollection::set_items($id, $reflection_item_array, static::REL_EXAMPLE_REFLECTION_ITEM);
    }

    /**
     * Remove Reflection Items from an Example.
     *
     * @param int   $id        Id from Example to remove Reflection Items from
     * @param array $reflection_item_array Array of Reflection Item Ids to remove from Example
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_reflection_items($id, $reflection_item_array) {
        return UBCollection::remove_items($id, $reflection_item_array, static::REL_EXAMPLE_REFLECTION_ITEM);
    }

    /**
     * Get all Reflection Items from an Example
     *
     * @param int $id Id of the Example to get Reflection Items from
     *
     * @return array|bool Returns an array of Reflection Item IDs, or false if error
     */
    static function get_reflection_items($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_REFLECTION_ITEM);
    }

    // Resources methods
    static function add_resources($id, $resource_array) {
        return UBCollection::add_items($id, $resource_array, static::REL_EXAMPLE_RESOURCE);
    }

    static function set_resources($id, $resource_array) {
        return UBCollection::set_items($id, $resource_array, static::REL_EXAMPLE_RESOURCE);
    }

    static function remove_resources($id, $resource_array) {
        return UBCollection::remove_items($id, $resource_array, static::REL_EXAMPLE_RESOURCE);
    }

    static function get_resources($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_RESOURCE);
    }

    // Videos methods
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_EXAMPLE_VIDEO);
    }

    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_EXAMPLE_VIDEO);
    }

    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_EXAMPLE_VIDEO);
    }
    
    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_VIDEO);
    }

    // Storyboards methods
    static function add_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_EXAMPLE_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_EXAMPLE_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_EXAMPLE_STORYBOARD);
    }

    static function get_storyboards($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_STORYBOARD);
    }

    // Files methods
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_EXAMPLE_FILE);
    }

    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_EXAMPLE_FILE);
    }

    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_EXAMPLE_FILE);
    }
    
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_FILE);
    }
}