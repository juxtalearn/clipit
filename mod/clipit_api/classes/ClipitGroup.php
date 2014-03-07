<?php


/**
 * Class ClipitGroup
 *
 * @package clipit
 */
class ClipitGroup extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_group";

    const REL_GROUP_USER = "group-user";
    const REL_GROUP_FILE = "group-file";

    function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        foreach($rel_array as $rel){
            switch($rel->relationship){
                case ClipitGroup::REL_GROUP_FILE:
                    $file_array[] = $rel->guid_two;
                    break;
            }
        }
        if(isset($file_array)){
            ClipitFile::delete_by_id($file_array);
        }
        parent::delete();
    }

    static function get_from_user_activity($user_id, $activity_id){
        $user_groups = array_flip(ClipitUser::get_groups($user_id));
        $activity_groups = array_flip(ClipitActivity::get_groups($activity_id));
        $intersection = array_flip(array_intersect_key($user_groups, $activity_groups));
        if(empty($intersection) || count($intersection) != 1){
            return false;
        }
        return array_pop($intersection);
    }

    /**
     * Gets the Activity Id in which a Group takes part in.
     *
     * @param int $id Id from the Group.
     *
     * @return bool|int Returns an Activity Id.
     */
    static function get_activity($id){
        $temp_array = get_entity_relationships($id, true);
        foreach($temp_array as $rel){
            if($rel->relationship == ClipitActivity::REL_ACTIVITY_GROUP){
                $rel_array[] = $rel;
            }
        }
        if(!isset($rel_array) || count($rel_array) != 1){
            return false;
        }
        return array_pop($rel_array)->guid_one;
    }

    /**
     * Add Users to a Group.
     *
     * @param int   $id Id of the Group to add Users to.
     * @param array $user_array Array of User Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_users($id, $user_array){
        return UBCollection::add_items($id, $user_array, ClipitGroup::REL_GROUP_USER);
    }

    /**
     * Remove Users from a Group.
     *
     * @param int   $id Id of the Group to remove Users from.
     * @param array $user_array Array of User Ids to remove from the Group.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_users($id, $user_array){
        return UBCollection::remove_items($id, $user_array, ClipitGroup::REL_GROUP_USER);
    }

    /**
     * Get User Ids from a Group.
     *
     * @param int $id Id of the Group to get Users from.
     *
     * @return bool Returns array of User Ids, or false if error.
     */
    static function get_users($id){
        return UBCollection::get_items($id, ClipitGroup::REL_GROUP_USER);
    }

    /**
     * Add Files to a Group.
     *
     * @param int   $id Id of the Group to add Files to.
     * @param array $file_array Array of File Ids to add to the Group.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, ClipitGroup::REL_GROUP_FILE);
    }

    /**
     * Remove Files from a Group.
     *
     * @param int   $id Id of the Group to remove Files from.
     * @param array $file_array Array of File Ids to remove from the Group.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, ClipitGroup::REL_GROUP_FILE);
    }

    /**
     * Get File Ids from a Group.
     *
     * @param int $id Id of the Group to get Files from.
     *
     * @return bool Returns array of User Ids, or false if error.
     */
    static function get_files($id){
        return UBCollection::get_items($id, ClipitGroup::REL_GROUP_FILE);
    }
}
