<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * A system event triggered by any user action (directly or indirectly).
 */
class ClipitEvent extends UBEvent {
    /**
     * @param int $user_id ID of user to get recommended events from
     * @param int $offset Skip the first $offset events
     * @param int $limit Return at most $limit events
     * @param array|null $relationship_filter List of relationship names to filter events with
     * @return array Array of system events
     */
    static function get_recommended_events($user_id, $offset = 0, $limit = 10, $relationship_filter = null) {
        $user_groups = ClipitUser::get_groups($user_id);
        $user_activities = ClipitUser::get_activities($user_id);
        $user_tasks = array();
        foreach($user_activities as $activity_id){
            $user_tasks = array_merge($user_tasks, ClipitActivity::get_tasks($activity_id));
        }
        $object_array = array_merge($user_groups, $user_activities, $user_tasks);
        return static::get_by_object($object_array, $offset, $limit, $relationship_filter);
    }

    /**
     * @param int $offset Skip the first $offset events
     * @param int $limit Return at most $limit events
     * @return array Array of system events
     */
    static function get_all_events($offset = 0, $limit = 10){
        $all_groups = ClipitGroup::get_all(0, 0, "", true, true);
        $all_activities = ClipitActivity::get_all(0, 0, "", true, true);
        $all_tasks = ClipitTask::get_all(0, 0, "", true, true);
        $all_objects = array_merge($all_groups, $all_activities, $all_tasks);
        return static::get_by_object($all_objects, $offset, $limit);
    }
}