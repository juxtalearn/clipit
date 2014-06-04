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
 * Class ClipitExample
 *
 */
class ClipitExample extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitExample";

    public $tag = 0;

    public $resource_url = "";

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->resource_url = (string)$elgg_object->get("resource_url");
        $this->tag = (int)$elgg_object->get("tag");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("resource_url", (string)$this->resource_url);
        $elgg_entity->set("tag", (int)$this->tag);
    }

}