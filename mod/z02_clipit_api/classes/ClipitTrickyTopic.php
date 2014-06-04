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
 * Class ClipitTrickyTopic
 *
 */
class ClipitTrickyTopic extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTrickyTopic";

    public $subject = "";
    public $country = "";
    public $tag_array = array();


    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->subject = (string)$elgg_object->get("subject");
        $this->country = (string)$elgg_object->get("country");
        $this->tag_array = (array)$elgg_object->get("tag_array");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("subject", (string)$this->subject);
        $elgg_entity->set("country", (string)$this->country);
        $elgg_entity->set("tag_array", (array)$this->tag_array);
    }
}