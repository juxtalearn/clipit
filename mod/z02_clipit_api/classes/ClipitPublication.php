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
 * Class ClipiPublication
 *
 */
class ClipitPublication extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPublication";

    const REL_PUBLICATION_TAG = "publication-tag";
    const REL_PUBLICATION_LABEL = "publication-label";
    const REL_PUBLICATION_COMMENT = "publication-comment";
    const REL_PUBLICATION_PERFORMANCE = "publication-performance";

    const REL_GROUP_PUBLICATION = "group-publication";
    const REL_ACTIVITY_PUBLICATION = "activity-publication";
    const REL_SITE_PUBLICATION = "site-publication";
    const REL_TASK_PUBLICATION = "task-publication";

    public $tag_array = array();
    public $label_array = array();
    public $performance_item_array = array();
    public $comment_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->label_array = (array)static::get_labels($this->id);
        $this->performance_item_array = (array)static::get_performance_items($this->id);
        $this->comment_array = (array)static::get_comments($this->id);
    }

    /**
     * Saves this instance into the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        parent::save();
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_labels($this->id, (array)$this->label_array);
        static::set_performance_items($this->id, (array)$this->performance_item_array);
        static::set_comments($this->id, (array)$this->comment_array);
        return $this->id;
    }

    /**
     * Deletes $this instance from the system.
     *
     * @return bool True if success, false if error.
     */
    protected function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        $comment_array = array();
        foreach($rel_array as $rel){
            // Delete comments hanging from the Publication to be deleted
            if($rel->relationship == static::REL_PUBLICATION_COMMENT){
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
        $task = static::get_task($id);
        if(!empty($task)){
            return "task";
        }
        $group = static::get_group($id);
        if(!empty($group)){
            return "group";
        }
        return null;
    }

    static function get_group($id){
        $publication = new static($id);
        if(!empty($publication->cloned_from)){
            return static::get_group($publication->cloned_from);
        }
        $group = UBCollection::get_items($id, static::REL_GROUP_PUBLICATION, true);
        if(!empty($group)){
            return array_pop($group);
        } else{
            return null;
        }
    }

    static function get_task($id){
        $task = UBCollection::get_items($id, static::REL_TASK_PUBLICATION, true);
        if(!empty($task)){
            return array_pop($task);
        } else{
            return null;
        }
    }

    static function get_activity($id){
        $group_id = static::get_group($id);
        if(!empty($group_id)){
            return ClipitGroup::get_activity($group_id);
        } else{
            $activity = UBCollection::get_items($id, static::REL_ACTIVITY_PUBLICATION, true);
            if(!empty($activity)){
                return array_pop($activity);
            }
        }
        return null;
    }

    static function get_site($id){
        $site = UBCollection::get_items($id, static::REL_SITE_PUBLICATION, true);
        if(!empty($site)){
            return array_pop($site);
        } else{
            return null;
        }
    }

    /**
     * Adds Tags to a Publication, referenced by Id.
     *
     * @param int   $id Id from the Publication to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_PUBLICATION_TAG);
    }

    /**
     * Sets Tags to a Publication, referenced by Id.
     *
     * @param int   $id Id from the Publication to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_PUBLICATION_TAG);
    }

    /**
     * Remove Tags from a Publication.
     *
     * @param int   $id Id from Publication to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_PUBLICATION_TAG);
    }

    /**
     * Get all Tags from a Publication
     *
     * @param int $id Id of the Publication to get Tags from
     *
     * @return array|bool Returns an array of Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_PUBLICATION_TAG);
    }

    /**
     * Add Labels to a Publication.
     *
     * @param int   $id Id of the Publication to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Publication.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array){
        return UBCollection::add_items($id, $label_array, static::REL_PUBLICATION_LABEL);
    }

    /**
     * Set Labels to a Publication.
     *
     * @param int   $id Id of the Publication to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Publication.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array){
        return UBCollection::set_items($id, $label_array, static::REL_PUBLICATION_LABEL);
    }

    /**
     * Remove Labels from a Publication.
     *
     * @param int   $id Id of the Publication to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Publication.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array){
        return UBCollection::remove_items($id, $label_array, static::REL_PUBLICATION_LABEL);
    }

    /**
     * Get Label Ids from a Publication.
     *
     * @param int $id Id of the Publication to get Labels from.
     *
     * @return bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id){
        return UBCollection::get_items($id, static::REL_PUBLICATION_LABEL);
    }

    static function add_performance_items($id, $performance_item_array){
        return UBCollection::add_items($id, $performance_item_array, static::REL_PUBLICATION_PERFORMANCE);
    }

    static function set_performance_items($id, $performance_item_array){
        return UBCollection::set_items($id, $performance_item_array, static::REL_PUBLICATION_PERFORMANCE);
    }

    static function remove_performance_items($id, $performance_item_array){
        return UBCollection::remove_items($id, $performance_item_array, static::REL_PUBLICATION_PERFORMANCE);
    }

    static function get_performance_items($id){
        return UBCollection::get_items($id, static::REL_PUBLICATION_PERFORMANCE);
    }

    /**
     * Adds Comments to a Publication, referenced by Id.
     *
     * @param int   $id Id from the Publication to add Comments to
     * @param array $comment_array Array of Comment Ids to be added to the Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function add_comments($id, $comment_array){
        return UBCollection::add_items($id, $comment_array, static::REL_PUBLICATION_COMMENT);
    }

    /**
     * Sets Comments to a Publication, referenced by Id.
     *
     * @param int   $id Id from the Publication to set Comments to
     * @param array $comment_array Array of Comment Ids to be set to the Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function set_comments($id, $comment_array){
        return UBCollection::set_items($id, $comment_array, static::REL_PUBLICATION_COMMENT);
    }

    /**
     * Remove Comments from a Publication.
     *
     * @param int   $id Id from Publication to remove Comments from
     * @param array $comment_array Array of Comment Ids to remove from Publication
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_comments($id, $comment_array){
        return UBCollection::remove_items($id, $comment_array, static::REL_PUBLICATION_COMMENT);
    }

    /**
     * Get all Comments for a Publication
     *
     * @param int $id Id of the Publication to get Comments from
     *
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        return UBCollection::get_items($id, static::REL_PUBLICATION_COMMENT);
    }


}