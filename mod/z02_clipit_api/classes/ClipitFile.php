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
 * Class ClipitFile
 *
 */
class ClipitFile extends UBFile{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "ClipitFile";

    const REL_FILE_TAG = "file-tag";

    public $tag_array = array();

    /**
     * @param ElggObject $elgg_object Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->tag_array = static::get_tags($this->id);
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        parent::save();
        static::set_tags($this->id, $this->tag_array);
        return $this->id;
    }

    static function get_group($id){
        $file = new static($id);
        if(!empty($file->clone_id)){
            return static::get_group($file->clone_id);
        }
        $group = UBCollection::get_items($id, ClipitGroup::REL_GROUP_FILE, true);
        return array_pop($group);
    }

    static function get_activity($id){
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_FILE, true);
        return array_pop($activity);
    }

    static function get_site($id){
        $site = UBCollection::get_items($id, ClipitSite::REL_SITE_FILE, true);
        return array_pop($site);
    }

    /**
     * Add Tags to a File.
     *
     * @param int   $id Id of the File to add Tags to.
     * @param array $tag_array Array of Tag Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_FILE_TAG);
    }

    /**
     * Set Tags to a File.
     *
     * @param int   $id Id of the File to set Tags to.
     * @param array $tag_array Array of Tag Ids to set to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_FILE_TAG);
    }

    /**
     * Remove Tags from a File.
     *
     * @param int   $id Id of the File to remove Tags from.
     * @param array $tag_array Array of Tags Ids to remove from the File.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_FILE_TAG);
    }

    /**
     * Get Tag Ids from a File.
     *
     * @param int $id Id of the File to get Tags from.
     *
     * @return bool Returns array of Tag Ids, or false if error.
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_FILE_TAG);
    }

}
