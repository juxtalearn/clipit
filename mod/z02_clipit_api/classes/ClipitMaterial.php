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
 * Class ClipitMaterial
 *
 */
class ClipitMaterial extends UBItem{
    const SUBTYPE = "ClipitMaterial";

    const REL_MATERIAL_TAG = "material-tag";
    const REL_MATERIAL_LABEL = "material-label";
    const REL_MATERIAL_COMMENT = "material-comment";
    const REL_MATERIAL_PERFORMANCE = "material-performance";

    const REL_GROUP_MATERIAL = "group-material";
    const REL_ACTIVITY_MATERIAL = "activity-material";
    const REL_SITE_MATERIAL = "site-material";

    public $tag_array = array();
    public $label_array = array();
    public $performance_item_array = array();
    public $comment_array = array();

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->label_array = (array)static::get_labels($this->id);
        $this->performance_item_array = (array)static::get_performance_items($this->id);
        $this->comment_array = (array)static::get_comments($this->id);
    }

    protected function save(){
        parent::save();
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_labels($this->id, (array)$this->label_array);
        static::set_performance_items($this->id, (array)$this->performance_item_array);
        static::set_comments($this->id, (array)$this->comment_array);
        return $this->id;
    }

    protected function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        $comment_array = array();
        foreach($rel_array as $rel){
            // Delete comments hanging from the Material to be deleted
            if($rel->relationship == static::REL_MATERIAL_COMMENT){
                $comment_array[] = $rel->guid_two;
            }
        }
        if(!empty($comment_array)){
            ClipitComment::delete_by_id($comment_array);
        }
        parent::delete();
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
        $material = new static($id);
        if(!empty($material->cloned_from)){
            return static::get_group($material->cloned_from);
        }
        $group = UBCollection::get_items($id, static::REL_GROUP_MATERIAL, true);
        return array_pop($group);
    }

    static function get_activity($id){
        $activity = UBCollection::get_items($id, static::REL_ACTIVITY_MATERIAL, true);
        return array_pop($activity);
    }

    static function get_site($id){
        $site = UBCollection::get_items($id, static::REL_SITE_MATERIAL, true);
        return array_pop($site);
    }

    /**
     * Adds Tags to a Material, referenced by Id.
     *
     * @param int   $id Id from the Material to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Material
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_MATERIAL_TAG);
    }

    /**
     * Sets Tags to a Material, referenced by Id.
     *
     * @param int   $id Id from the Material to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Material
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_MATERIAL_TAG);
    }

    /**
     * Remove Tags from a Material.
     *
     * @param int   $id Id from Material to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Material
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_MATERIAL_TAG);
    }

    /**
     * Get all Tags from a Material
     *
     * @param int $id Id of the Material to get Tags from
     *
     * @return array|bool Returns an array of Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_MATERIAL_TAG);
    }

    /**
     * Add Labels to a Material.
     *
     * @param int   $id Id of the Material to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Material.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array){
        return UBCollection::add_items($id, $label_array, static::REL_MATERIAL_LABEL);
    }

    /**
     * Set Labels to a Material.
     *
     * @param int   $id Id of the Material to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Material.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array){
        return UBCollection::set_items($id, $label_array, static::REL_MATERIAL_LABEL);
    }

    /**
     * Remove Labels from a Material.
     *
     * @param int   $id Id of the Material to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Material.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array){
        return UBCollection::remove_items($id, $label_array, static::REL_MATERIAL_LABEL);
    }

    /**
     * Get Label Ids from a Material.
     *
     * @param int $id Id of the Material to get Labels from.
     *
     * @return bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id){
        return UBCollection::get_items($id, static::REL_MATERIAL_LABEL);
    }

    static function add_performance_items($id, $performance_item_array){
        return UBCollection::add_items($id, $performance_item_array, static::REL_MATERIAL_PERFORMANCE);
    }

    static function set_performance_items($id, $performance_item_array){
        return UBCollection::set_items($id, $performance_item_array, static::REL_MATERIAL_PERFORMANCE);
    }

    static function remove_performance_items($id, $performance_item_array){
        return UBCollection::remove_items($id, $performance_item_array, static::REL_MATERIAL_PERFORMANCE);
    }

    static function get_performance_items($id){
        return UBCollection::get_items($id, static::REL_MATERIAL_PERFORMANCE);
    }

    /**
     * Adds Comments to a Material, referenced by Id.
     *
     * @param int   $id Id from the Material to add Comments to
     * @param array $comment_array Array of Comment Ids to be added to the Material
     *
     * @return bool Returns true if success, false if error
     */
    static function add_comments($id, $comment_array){
        return UBCollection::add_items($id, $comment_array, static::REL_MATERIAL_COMMENT);
    }

    /**
     * Sets Comments to a Material, referenced by Id.
     *
     * @param int   $id Id from the Material to set Comments to
     * @param array $comment_array Array of Comment Ids to be set to the Material
     *
     * @return bool Returns true if success, false if error
     */
    static function set_comments($id, $comment_array){
        return UBCollection::set_items($id, $comment_array, static::REL_MATERIAL_COMMENT);
    }

    /**
     * Remove Comments from a Material.
     *
     * @param int   $id Id from Material to remove Comments from
     * @param array $comment_array Array of Comment Ids to remove from Material
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_comments($id, $comment_array){
        return UBCollection::remove_items($id, $comment_array, static::REL_MATERIAL_COMMENT);
    }

    /**
     * Get all Comments for a Material
     *
     * @param int $id Id of the Material to get Comments from
     *
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        return UBCollection::get_items($id, static::REL_MATERIAL_COMMENT);
    }


}