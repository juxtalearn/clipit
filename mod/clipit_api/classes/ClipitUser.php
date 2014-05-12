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
     * @const Default cookie token duration in minutes
     */
    const COOKIE_TOKEN_DURATION = 60;

    static function login($login, $password, $persistent = false){
        if(!parent::login($login, $password, $persistent)){
            return false;
        }
        static::create_cookies($login, $password);
        return true;
    }

    static function logout(){
        static::delete_cookies();
        return parent::logout();
    }

    static function create_cookies($login, $password){
        global $CONFIG;
        $site = elgg_get_site_entity();
        $user = static::get_by_login(array($login));
        $user = $user[$login];
        $token = UBSite::get_token($login, $password, static::COOKIE_TOKEN_DURATION);
        try {
            $jxl_cookie_auth = new JuxtaLearn_Cookie_Authentication(
                    $CONFIG->JXL_COOKIE_SECRET, $CONFIG->JXL_COOKIE_DOMAIN);
        } catch (Exception $ex) {
            // Error - I don't know how to hook into Elgg error handling/reporting.
            die(get_class($jxl_cookie_auth) .': '. $ex->getMessage());
        }
        $jxl_cookie_auth->set_required_cookie($user->login, $user->role, $user->id);
        $jxl_cookie_auth->set_name_cookie($user->name);
        $jxl_cookie_auth->set_token_cookie($token);
    }

    static function delete_cookies(){
        global $CONFIG;
        UBSite::remove_token($_COOKIE["clipit_token"]);
        try {
            $jxl_cookie_auth = new JuxtaLearn_Cookie_Authentication(
                    $CONFIG->JXL_COOKIE_SECRET, $CONFIG->JXL_COOKIE_DOMAIN);
        } catch (Exception $ex) {
            die(get_class($jxl_cookie_auth) .': '. $ex->getMessage());
        }
        $jxl_cookie_auth->delete_cookies();
    }

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