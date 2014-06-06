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
 * Class ClipitTask
 */
class ClipitTask extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTask";

    public $type = "";
    public $deadline = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->type = (string)$elgg_object->get("type");
        $this->deadline = (int)$elgg_object->get("deadline");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("type", (string)$this->type);
        $elgg_entity->set("deadline", (int)$this->deadline);
    }

    /**
     * Get the Activity Id in which a Task is contained in.
     *
     * @param int $task_id Id of the Task to get Activity from.
     *
     * @return array Returns an the Activity Id for the Task.
     */
    static function get_activity($task_id){
        $activity = UBCollection::get_items($task_id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_pop($activity);
    }
} 