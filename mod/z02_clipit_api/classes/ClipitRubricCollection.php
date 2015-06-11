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

class ClipitRubricCollection extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitRubricCollection";
    const REL_RUBRICCOLLECTION_RUBRICITEM = "ClipitRubricCollection-ClipitRubricItem";
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

    static function get_rubric_items($id){
        return UBCollection::get_items($id, static::REL_RUBRICCOLLECTION_RUBRICITEM);
    }

    static function add_rubric_items($id, $rubric_item_array){
        return UBCollection::add_items($id, $rubric_item_array, static::REL_RUBRICCOLLECTION_RUBRICITEM);
    }

    static function remove_rubric_items($id, $rubric_item_array){
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_RUBRICCOLLECTION_RUBRICITEM);
    }

    static function set_rubric_items($id, $rubric_item_array){
        return UBCollection::set_items($id, $rubric_item_array, static::REL_RUBRICCOLLECTION_RUBRICITEM);
    }

}
