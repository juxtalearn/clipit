<?php


/**
 * Class ClipitEvent
 *
 * @package clipit
 */
class ClipitEvent extends UBEvent{

    static function get_recommended_events($user_id, $offset = 0, $limit = 10){
        $user_groups = ClipitUser::get_groups($user_id);
        $user_activities = array();
        foreach($user_groups as $group){
            if($activity_id = ClipitGroup::get_activity($group)){
                $user_activities[] = $activity_id;
            }
        }
        $object_array = array_merge($user_groups, $user_activities);
        return ClipitEvent::get_by_object($object_array, $offset, $limit);
    }
} 