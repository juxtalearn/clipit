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
    const REL_EXAMPLE_EXAMPLETYPE = "ClipitExample-ClipitExampleType";
    const REL_EXAMPLE_VIDEO = "ClipitExample-ClipitVideo";
    const REL_EXAMPLE_FILE = "ClipitExample-ClipitFile";
    public $tricky_topic = 0;
    public $tag_array = array();
    public $example_type_array = array();
    public $country = "";
    public $location = "";
    // Example Resources
    public $video_array = array();
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tricky_topic = (int)static::get_tricky_topic($this->id);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->example_type_array = (array)static::get_example_types($this->id);
        $this->country = (string)$elgg_entity->get("country");
        $this->location = (string)$elgg_entity->get("location");
        $this->video_array = static::get_videos($this->id);
        $this->file_array = static::get_files($this->id);
    }

    /**
     * Copy $this object's parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("country", (string)$this->country);
        $elgg_entity->set("location", (string)$this->location);
    }

    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_tricky_topic($this->id, (int)$this->tricky_topic);
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_example_types($this->id, (array)$this->example_type_array);
        static::set_videos($this->id, $this->video_array);
        static::set_files($this->id, $this->file_array);
        return $this->id;
    }

    static function get_by_tag($tag_array){
        $return_examples = array();
        $example_array = static::get_all(0);
        if(empty($example_array) || empty($tag_array)){
            return $return_examples;
        }
        foreach($example_array as $example){
            foreach($example->tag_array as $tag){
                if(in_array($tag, $tag_array)){
                    $return_examples[] = $example;
                    break;
                }
            }
        }
        return $return_examples;
    }

    static function get_tricky_topic($id) {
        $ret_array = UBCollection::get_items($id, ClipitTrickyTopic::REL_TRICKYTOPIC_EXAMPLE, true);
        if(!empty($ret_array)){
            return array_pop($ret_array);
        }
        return 0;
    }

    static function set_tricky_topic($id, $tricky_topic_id) {
        return ClipitTrickyTopic::add_examples($tricky_topic_id, array($id));
    }

    static function get_from_tricky_topic($tricky_topic_id) {
        return ClipitExample::get_by_id(ClipitTrickyTopic::get_examples($tricky_topic_id));
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
     * Adds Example Types to an Example, referenced by Id.
     *
     * @param int   $id                     Id from the Example to add Example Types to
     * @param array $example_type_array     Array of Example Type Ids to be added to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function add_example_types($id, $example_type_array) {
        return UBCollection::add_items($id, $example_type_array, static::REL_EXAMPLE_EXAMPLETYPE);
    }

    /**
     * Sets Example Types to an Example, referenced by Id.
     *
     * @param int   $id                     Id from the Example to set Example Types to
     * @param array $example_type_array     Array of Example Type Ids to be set to the Example
     *
     * @return bool Returns true if success, false if error
     */
    static function set_example_types($id, $example_type_array) {
        return UBCollection::set_items($id, $example_type_array, static::REL_EXAMPLE_EXAMPLETYPE);
    }

    /**
     * Remove Example Types from an Example.
     *
     * @param int   $id                         Id from Example to remove Example Types from
     * @param array $example_type_array      Array of Example Type Ids to remove from Example
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_example_types($id, $example_type_array) {
        return UBCollection::remove_items($id, $example_type_array, static::REL_EXAMPLE_EXAMPLETYPE);
    }

    /**
     * Get all Example Types from an Example
     *
     * @param int $id Id of the Example to get Example Types from
     *
     * @return array|bool Returns an array of Example Type IDs, or false if error
     */
    static function get_example_types($id) {
        return UBCollection::get_items($id, static::REL_EXAMPLE_EXAMPLETYPE);
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