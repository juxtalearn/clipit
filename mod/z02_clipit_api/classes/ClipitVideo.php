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
 * Class ClipitVideo
 *
 */
class ClipitVideo extends ClipitPublication{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitVideo";

    const REL_PUBLICATION_TAG = "video-tag";
    const REL_PUBLICATION_LABEL = "video-label";
    const REL_PUBLICATION_COMMENT = "video-comment";
    const REL_PUBLICATION_PERFORMANCE = "video-performance";

    const REL_GROUP_PUBLICATION = "group-video";
    const REL_ACTIVITY_PUBLICATION = "activity-video";
    const REL_SITE_PUBLICATION = "site-video";

    public $preview = "";
    public $duration = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->preview = (string)$elgg_object->get("preview");
        $this->duration = (int)$elgg_object->get("duration");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("preview", (string)$this->preview);
        $elgg_entity->set("duration", (int)$this->duration);
    }
}