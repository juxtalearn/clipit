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
 * Class ClipitUser
 *
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
     * @param int $user_id Id of the user to get groups from.
     *
     * @return array Returns an array of Group Ids the user is member of.
     */
    static function get_groups($user_id){
        $rel_array = get_entity_relationships($user_id, true);
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
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_student($user_id){
        remove_user_admin($user_id);
        $prop_value_array["role"] = static::ROLE_STUDENT;
        return static::set_properties($user_id, $prop_value_array);
    }

    /**
     * Sets a User role to Teacher.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_teacher($user_id){
        make_user_admin($user_id);
        $prop_value_array["role"] = static::ROLE_TEACHER;
        return static::set_properties($user_id, $prop_value_array);
    }

    /**
     * Sets a User role to Admin.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_admin($user_id){
        make_user_admin($user_id);
        $prop_value_array["role"] = static::ROLE_ADMIN;
        return static::set_properties($user_id, $prop_value_array);
    }

}