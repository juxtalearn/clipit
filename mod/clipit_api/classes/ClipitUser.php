<?php


/**
 * Class ClipitUser
 *
 * @package clipit
 */
class ClipitUser extends UBUser{

    /**
     * @const Role name for Students
     */
    const ROLE_STUDENT = "student";
    /**
     * @const Role name for Teachers
     */
    const ROLE_TEACHER = "teacher";
    /**
     * @const Role name for Administrators
     */
    const ROLE_ADMIN = "admin";

    /**
     * Get all Group Ids in which a user is member of.
     *
     * @param int $id Id of the user to get groups from.
     *
     * @return array Returns an array of Group Ids the user is member of.
     */
    static function get_groups($id){
        $rel_array = get_entity_relationships($id, true);
        $group_ids = array();
        foreach($rel_array as $rel){
            if($rel->relationship == ClipitGroup::REL_GROUP_USER){
                $group_ids[] = (int)$rel->guid_one;
            }
        }
        return $group_ids;
    }

    /**
     * Sets a User role to Student.
     *
     * @param int $id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_student($id){
        $user = new ClipitUser($id);
        remove_user_admin($id);
        $prop_value_array["role"] = ClipitUser::ROLE_STUDENT;
        return $user->setProperties($prop_value_array);
    }

    /**
     * Sets a User role to Teacher.
     *
     * @param int $id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_teacher($id){
        $user = new ClipitUser($id);
        make_user_admin($id);
        $prop_value_array["role"] = ClipitUser::ROLE_TEACHER;
        return $user->setProperties($prop_value_array);
    }

    /**
     * Sets a User role to Admin.
     *
     * @param int $id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_admin($id){
        $user = new ClipitUser($id);
        make_user_admin($id);
        $prop_value_array["role"] = ClipitUser::ROLE_ADMIN;
        return $user->setProperties($prop_value_array);
    }

}