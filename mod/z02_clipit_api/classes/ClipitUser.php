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
 * Represents each human user interacting directly or indirectly with the ClipIt.
 */
class ClipitUser extends UBUser {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitUser";
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
     * @const Default cookie token duration in minutes
     */
    const COOKIE_TOKEN_DURATION = 60;

    /**
     * Saves this instance into the system.
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save() {
        // If no role set, use "student" as default
        if(array_search($this->role, array(static::ROLE_STUDENT, static::ROLE_TEACHER, static::ROLE_ADMIN)) === false){
            $this->role = static::ROLE_STUDENT;
        }
        $id = parent::save();
        switch(strtolower($this->role)) {
            case static::ROLE_STUDENT:
                remove_user_admin($this->id);
                break;
            case static::ROLE_TEACHER:
                make_user_admin($this->id);
                break;
            case static::ROLE_ADMIN:
                make_user_admin($this->id);
                break;
        }
        return $id;
    }

    static function login($login, $password, $persistent = false) {
        if(!parent::login($login, $password, $persistent)) {
            return false;
        }
        //static::create_cookies($login, $password);
        return true;
    }

    static function logout() {
        return parent::logout();
    }

    /**
     * Get all Group Ids in which a user is member of.
     *
     * @param int $user_id Id of the user to get groups from.
     *
     * @return array Returns an array of Group IDs the user is member of.
     */
    static function get_groups($user_id) {
        return UBCollection::get_items($user_id, ClipitGroup::REL_GROUP_USER, true);
    }

    /**
     * Get all Activity Ids in which a Student is member of, or a Teacher is in charge of.
     *
     * @param int  $user_id     Id of the user to get activities from.
     * @param bool $joined_only Only returnes Activities where a Student user has joined to a group.
     *
     * @return array Returns an array of Activity IDs the user is member of.
     */
    static function get_activities($user_id, $joined_only = false) {
        $prop_value_array = static::get_properties($user_id, array("role"));
        $user_role = $prop_value_array["role"];
        switch($user_role) {
            case static::ROLE_STUDENT:
                if((bool)$joined_only) {
                    $group_ids = static::get_groups($user_id);
                    if(empty($group_ids)) {
                        return null;
                    }
                    foreach($group_ids as $group_id) {
                        $activity_array[] = ClipitGroup::get_activity($group_id);
                    }
                    if(!isset($activity_array)) {
                        return null;
                    }
                    return $activity_array;
                } else {
                    return UBCollection::get_items($user_id, ClipitActivity::REL_ACTIVITY_STUDENT, true);
                }
            case static::ROLE_TEACHER:
                return UBCollection::get_items($user_id, ClipitActivity::REL_ACTIVITY_TEACHER, true);
        }
        return null;
    }

    /**
     * Sets a User role to Student.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_student($user_id) {
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
    static function set_role_teacher($user_id) {
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
    static function set_role_admin($user_id) {
        $prop_value_array["role"] = static::ROLE_ADMIN;
        return static::set_properties($user_id, $prop_value_array);
    }
}