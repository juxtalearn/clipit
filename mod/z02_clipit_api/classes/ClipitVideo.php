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
class ClipitVideo extends ClipitMaterial{
    /**
     * @const string Elgg entity sybtype for this class
     */
    const SUBTYPE = "ClipitVideo";

    const REL_MATERIAL_TAG = "video-tag";
    const REL_MATERIAL_LABEL = "video-label";
    const REL_MATERIAL_COMMENT = "video-comment";
    const REL_MATERIAL_PERFORMANCE = "video-performance";

    const REL_GROUP_MATERIAL = "group-video";
    const REL_ACTIVITY_MATERIAL = "activity-video";
    const REL_SITE_MATERIAL = "site-video";

    public $preview = "";
    public $duration = 0;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->preview = (string)$elgg_object->get("preview");
        $this->duration = (int)$elgg_object->get("duration");
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("preview", (string)$this->preview);
        $elgg_object->set("duration", (int)$this->duration);
    }
}