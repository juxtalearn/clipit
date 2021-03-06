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

class ClipitRubric extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitRubric";
    const REL_RUBRIC_RUBRICITEM = "ClipitRubric-ClipitRubricItem";
    // Contained Rubric Items
    public $rubric_item_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->rubric_item_array = (array)static::get_rubric_items($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_rubric_items($this->id, (array)$this->rubric_item_array);
        return $this->id;
    }

    /**
     * Clones a Rubric Collection, including the contained Rubric Items
     *
     * @param int $id ID of Rubric Collection to clone
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
        $rubric_item_array = $prop_value_array["rubric_item_array"];
        if(!empty($rubric_item_array)){
            $new_rubric_item_array = array();
            foreach($rubric_item_array as $rubric_item_id){
                $new_rubric_item_array[] = ClipitRubricItem::create_clone($rubric_item_id);
            }
            $prop_value_array["rubric_item_array"] = $new_rubric_item_array;
        }
        $clone_id = static::create($prop_value_array);
        if($linked) {
            static::link_parent_clone($id, $clone_id);
        }
        return $clone_id;
    }

    static function get_rubric_items($id){
        return UBCollection::get_items($id, static::REL_RUBRIC_RUBRICITEM);
    }

    static function add_rubric_items($id, $rubric_item_array){
        return UBCollection::add_items($id, $rubric_item_array, static::REL_RUBRIC_RUBRICITEM);
    }

    static function remove_rubric_items($id, $rubric_item_array){
        // Un-link from ratings the rubric ratings which point to the removed rubric items
        $rubric_rating_array = array_flatten(ClipitRubricRating::get_by_item($rubric_item_array));
        foreach($rubric_rating_array as $rubric_rating){
            $rating_array = UBCollection::get_items($rubric_rating->id, ClipitRating::REL_RATING_RUBRICRATING, true);
            if(empty($rating_array)){
                continue;
            }
            $rating_id = array_pop($rating_array);
            ClipitRating::remove_rubric_ratings($rating_id, array($rubric_rating->id));
        }
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_RUBRIC_RUBRICITEM);
    }

    static function set_rubric_items($id, $rubric_item_array){
        return UBCollection::set_items($id, $rubric_item_array, static::REL_RUBRIC_RUBRICITEM);
    }

}
