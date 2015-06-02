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

    public $rubric_item = 0;
    public $rubric_level = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->rubric_item = (array)$elgg_entity->get("rubric_item");
        $this->rubric_level = (array)$elgg_entity->get("rubric_level");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("rubric_item", (array)$this->rubric_item);
        $elgg_entity->set("rubric_level", (array)$this->rubric_level);
    }

}