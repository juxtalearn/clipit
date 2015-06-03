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

class ClipitRubricRating extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitRubricRating";
    const REL_RUBRICRATING_RUBRICITEM = "ClipitRubricRating-ClipitRubricItem";

    public $rubric_item = 0;
    public $level = 0;
    public $score = 0.0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->rubric_item = (int)static::get_rubric_item($this->id);
        $this->level = (int)$elgg_entity->get("level");
        if (!empty($this->rubric_item)) {
            $rubric_item = array_pop(ClipitRubricItem::get_by_id(array($this->rubric_item)));
            $this->score = (float)$rubric_item->level_increment * $this->level;
        }
    }

    static function get_rubric_item($id)
    {
        return array_pop(UBCollection::get_items($id, static::REL_RUBRICRATING_RUBRICITEM));
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("level", (int)$this->level);
    }

    /**
     * Saves this instance to the system.
     *
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure
     * that all properties are updated properly. E.g. the time created property can only be set
     * on ElggObjects during an update. Defaults to false.
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_rubric_item($this->id, $this->rubric_item);
        return $this->id;
    }

    static function set_rubric_item($id, $rubric_id)
    {
        return UBCollection::set_items($id, array($rubric_id), static::REL_RUBRICRATING_RUBRICITEM);
    }

}