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
    const SUBTYPE = "clipit_task";

    /**
     * Get the Activity Id in which a Task is contained in.
     *
     * @param int $task_id Id of the Task to get Activity from.
     *
     * @return array Returns an the Activity Id for the Task.
     */
    static function get_activity($task_id){
        $activity = UBCollection::get_items($task_id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_poop($activity);
    }
} 