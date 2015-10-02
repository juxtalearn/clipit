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
 * A Storyboard object linking to a binary file to use with external authoring component.
 */
class ClipitStoryboard extends ClipitResource {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitStoryboard";
    const REL_RESOURCE_TAG = "ClipitStoryboard-ClipitTag";
    const REL_RESOURCE_PERFORMANCE = "ClipitStoryboard-ClipitPerformanceItem";
    const REL_RESOURCE_LABEL = "ClipitStoryboard-ClipitLabel";
    const REL_RESOURCE_USER = "ClipitStoryboard-ClipitUser";
    const REL_EXAMPLE_RESOURCE = ClipitExample::REL_EXAMPLE_STORYBOARD;
    const REL_GROUP_RESOURCE = ClipitGroup::REL_GROUP_STORYBOARD;
    const REL_TASK_RESOURCE = ClipitTask::REL_TASK_STORYBOARD;
    const REL_ACTIVITY_RESOURCE = ClipitActivity::REL_ACTIVITY_STORYBOARD;
    const REL_TRICKYTOPIC_RESOURCE = ClipitTrickyTopic::REL_TRICKYTOPIC_STORYBOARD;
    const REL_SITE_RESOURCE = ClipitSite::REL_SITE_STORYBOARD;
    public $file = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->file = (int)$elgg_entity->get("file");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("file", (int)$this->file);
    }
}