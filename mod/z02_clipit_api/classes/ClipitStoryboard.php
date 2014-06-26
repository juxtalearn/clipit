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
 * Class ClipitStoryboard
 *
 */
class ClipitStoryboard extends ClipitPublication{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitStoryboard";

    const REL_PUBLICATION_TAG = "storyboard-tag";
    const REL_PUBLICATION_LABEL = "storyboard-label";
    const REL_PUBLICATION_COMMENT = "storyboard-comment";
    const REL_PUBLICATION_PERFORMANCE = "storyboard-performance";

    const REL_GROUP_PUBLICATION = ClipitGroup::REL_GROUP_STORYBOARD;
    const REL_TASK_PUBLICATION = ClipitTask::REL_TASK_STORYBOARD;
    const REL_ACTIVITY_PUBLICATION = ClipitActivity::REL_ACTIVITY_STORYBOARD;
    const REL_SITE_PUBLICATION = ClipitSite::REL_SITE_STORYBOARD;

    public $file = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->file = (int)$elgg_entity->get("file");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_entity){
        parent::save_to_elgg($elgg_entity);
        $elgg_entity->set("file", (int)$this->file);
    }
}