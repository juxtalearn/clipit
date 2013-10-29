<?php namespace clipit\user;
    /**
     * ClipIt - JuxtaLearn Web Space
     * PHP version:     >= 5.2
     * Creation date:   2013-10-10
     * Last update:     $Date$
     *
     * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://juxtalearn.org
     * @license         GNU Affero General Public License v3
     *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
     *                  This program is free software: you can redistribute it and/or modify
     *                  it under the terms of the GNU Affero General Public License as
     *                  published by the Free Software Foundation, version 3.
     *                  This program is distributed in the hope that it will be useful,
     *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     *                  GNU Affero General Public License for more details.
     *                  You should have received a copy of the GNU Affero General Public License
     *                  along with this program. If not, see
     *                  http://www.gnu.org/licenses/agpl-3.0.txt.
     */

/**
 * Expose library functions to REST API.
 */
function expose_functions(){
    expose_function(
        "clipit.user.list_properties",
        __NAMESPACE__."\\list_properties",
        null, "description", 'GET', false, true);
    expose_function(
        "clipit.user.get_properties",
        __NAMESPACE__."\\get_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.set_properties",
        __NAMESPACE__."\\set_properties",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true),
             "prop_array" => array(
                 "type" => "array",
                 "required" => true),
             "value_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.create_user",
        __NAMESPACE__."\\create_user",
        array(
             "login" => array(
                 "type" => "string",
                 "required" => true),
             "password" => array(
                 "type" => "string",
                 "required" => true),
             "name" => array(
                 "type" => "string",
                 "required" => true),
             "email" => array(
                 "type" => "string",
                 "required" => true),
             "role" => array(
                 "type" => "string",
                 "required" => false),
             "description" => array(
                 "type" => "string",
                 "required" => false)
        ),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.delete_user",
        __NAMESPACE__."\\delete_user",
        array(
             "id" => array(
                 "type" => "int",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_all_users",
        __NAMESPACE__."\\get_all_users",
        NULL,
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_users_by_id",
        __NAMESPACE__."\\get_users_by_id",
        array(
             "id_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_users_by_login",
        __NAMESPACE__."\\get_users_by_login",
        array(
             "login_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_users_by_email",
        __NAMESPACE__."\\get_users_by_email",
        array(
             "email_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function(
        "clipit.user.get_users_by_role",
        __NAMESPACE__."\\get_users_by_role",
        array(
             "role_array" => array(
                 "type" => "array",
                 "required" => true)),
        "description goes here", 'GET', false, true);
}

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties with type and default value
 */
function list_properties(){
    return get_class_vars(__NAMESPACE__."\\ClipitUser");
}

/**
 * Get the values for the specified properties of a User.
 *
 * @param int $id Id from User
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of 'property' => 'value', or 'false' if error.
 * If a property does not exist, the return will show null as that propertie's value.
 */
function get_properties($id, $prop_array){
    $user = new ClipitUser($id);
    if(!$user){
        return false;
    }
    $value_array = array();
    for($i = 0; $i < count($prop_array); $i++){
        $value_array[$i] = $user->$prop_array[$i];
    }
    return array_combine($prop_array, $value_array);
}

/**
 * Set values to specified properties of a User.
 *
 * @param int $id Id from User
 * @param array $prop_array Array of properties to set values into
 * @param array $value_array Array of associated values to set into properties
 * @return bool Returns true if success, false if error
 * @throws \InvalidParameterException If count(prop_array) != count(value_array)
 */
function set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        throw(new \InvalidParameterException(
            "ERROR: The length of prop_array and value_array must match."));
    }
    $user = new ClipitUser($id);
    if(!$user){
        return false;
    }
    for($i = 0; $i < count($prop_array); $i++){
        if($prop_array[$i] == "password"){
            $user->setPassword($value_array[$i]);
            continue;
        }
        $user->$prop_array[$i] = $value_array[$i];
    }
    if(!$user->save()){
        return false;
    }
    return true;
}

/**
 * Create a new ClipItUser instance, and save it into the system.
 *
 * @param string $login User login
 * @param string $password User password (min length = 6)
 * @param string $name User full name
 * @param string $email User email
 * @param string $role User role (optional)
 * @param string $description User description (optional)
 * @return bool|int Returns the new User Id, or 'false' if error
 * @throws \InvalidParameterException
 */
function create_user($login,
                     $password,
                     $name,
                     $email,
                     $role = null,
                     $description = null){
    if(get_user_by_username($login)){
        throw(new \InvalidParameterException("The user login already exists"));
    }
    $user = new ClipitUser();
    $user->login = $login;
    $user->setPassword($password);
    $user->name = $name;
    $user->email = $email;
    if($role){
        $user->role = $role;
    }
    if($description){
        $user->description = $description;
    }
    return $user->save();
}

/**
 * Delete a User from the system.
 *
 * @param int $id Id from User to delete
 * @return bool True if success, false if error.
 */
function delete_user($id){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->delete();
}

/**
 * Get all users from the system.
 *
 * @param int $limit Number of results to show, default: 0 (no limit) (optional)
 * @return array Returns an array of ClipitUser objects
 */
function get_all_users($limit = 0){
    $elgg_user_array = elgg_get_entities(array('type' => 'user',
                                               'limit' => $limit));
    $user_array = array();
    $i = 0;
    foreach($elgg_user_array as $elgg_user){
        $user_array[$i] = new ClipitUser($elgg_user->guid);
        $i++;
    }
    return $user_array;
}

/**
 * Get users with id contained in a given list of ids.
 *
 * @param array $id_array Array of user ids
 * @return array Returns an array of ClipitUser objects
 */
function get_users_by_id($id_array){
    $user_array = array();
    for($i = 0; $i < count($id_array); $i++){
        $elgg_user = get_user($id_array[$i]);
        if(!$elgg_user){
            $user_array[$i] = null;
            continue;
        }
        $user_array[$i] = new ClipitUser($elgg_user->guid);
    }
    return $user_array;
}

/**
 * Get users with login contained in a given list of logins.
 *
 * @param array $login_array Array of user logins
 * @return array Returns an array of ClipitUser objects
 */
function get_users_by_login($login_array){
    $user_array = array();
    for($i = 0; $i < count($login_array); $i++){
        $elgg_user = get_user_by_username($login_array[$i]);
        if(!$elgg_user){
            $user_array[$i] = null;
            continue;
        }
        $user_array[$i] = new ClipitUser($elgg_user->guid);
    }
    return $user_array;
}

/**
 * Get users with email contained in a given list of emails.
 *
 * @param array $email_array Array of user emails
 * @return array Returns an array of ClipitUser objects
 */
function get_users_by_email($email_array){
    $user_array = array();
    for($i = 0; $i < count($email_array); $i++){
        $elgg_user_array = get_user_by_email($email_array[$i]);
        if(!$elgg_user_array){
            $user_array[$i] = null;
            continue;
        }
        $temp_array = array();
        $j = 0;
        foreach($elgg_user_array as $elgg_user){
            $temp_array[$j] = new ClipitUser($elgg_user->guid);
            $j++;
        }
        $user_array = array_merge($user_array, $temp_array);
    }
    return $user_array;
}

/**
 * Get users with role contained in a given list of roles.
 *
 * @param array $role_array Array of user roles
 * @return array Returns an array of ClipitUser objects
 */
function get_users_by_role($role_array){
    $user_array = array();
    for($i = 0; $i < count($role_array); $i++){
        $elgg_user_array = elgg_get_entities_from_metadata(
            array(
                 'type' => 'user',
                 'metadata_names' => array('role'),
                 'metadata_values' => array($role_array[$i])
            ));
        if(!$elgg_user_array){
            $user_array[$i] = null;
            continue;
        }
        $temp_array = array();
        $j = 0;
        foreach($elgg_user_array as $elgg_user){
            $temp_array[$j] = new ClipitUser($elgg_user->guid);
            $j++;
        }
        $user_array = array_merge($user_array, $temp_array);
    }
    return $user_array;
}
