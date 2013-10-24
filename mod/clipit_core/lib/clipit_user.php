<?php
/**
 * ClipItUser functions package
 * This package has functions to work with the ClipitUser class.
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @category        Library
 * @package         clipit
 * @subpackage      user
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Expose library functions to REST API.
 * @return bool 'true' if success, 'false' if error.
 */
function clipit_user_expose_functions(){
    if(!expose_function(
        "clipit.user.list_properties",
        "clipit_user_list_properties",
        null, "description", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_properties",
        "clipit_user_get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.set_properties",
        "clipit_user_set_properties",
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
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.create_user",
        "clipit_user_create_user",
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
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.delete_user",
        "clipit_user_delete_user",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_all_users",
        "clipit_user_get_all_users",
        NULL,
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_users_by_id",
        "clipit_user_get_users_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_users_by_login",
        "clipit_user_get_users_by_login",
        array(
            "login_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_users_by_email",
        "clipit_user_get_users_by_email",
        array(
            "email_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    if(!expose_function(
        "clipit.user.get_users_by_role",
        "clipit_user_get_users_by_role",
        array(
            "role_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true)
    ){
        return false;
    }
    return true;
}

/**
 * List the properties contained in this class.
 * @return array Array of properties with type and default value.
 */
function clipit_user_list_properties(){
    return get_class_vars("ClipitUser");
}

/**
 * Create a new ClipIt user instance, and save it into the system.
 *
 * @param   string $login       User login
 * @param   string $password    User password (min length = 6)
 * @param   string $name        User full name
 * @param   string $email       User email
 * @param   string $role        User role (optional)
 * @param   string $description User description (optional)
 *
 * @return  bool|int Returns new user id, or 'false' if error.
 * @throws  InvalidParameterException
 * @throws  CallException
 */
function clipit_user_create_user($login, $password, $name, $email, $role = null, $description = null){
    if(empty($login)){
        throw(new InvalidParameterException("The user login cannot be empty"));
    }
    if(get_user_by_username($login)){
        throw(new InvalidParameterException("The user login already exists"));
    }
    if(!$user = new ClipitUser()){
        throw(new CallException("There was a problem creating the new user"));
    }
    $user->login = $login;
    $user->password_hash = generate_random_cleartext_password();
    $user->password = md5($password.$user->password_hash);
    $user->name = $name;
    $user->email = $email;
    if(is_not_null($role)){
        $user->role = $role;
    }
    if(is_not_null($description)){
        $user->description = $description;
    }
    return $user->save();
}

/**
 * Delete a user from the system.
 *
 * @param int $id Id from user to delete.
 *
 * @return bool 'true' if success, 'false' if error.
 */
function clipit_user_delete_user($id){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->delete();
}

/**
 * Get the values for the specified properties of a user.
 *
 * @param int   $id         Id from user
 * @param array $prop_array Array of property names to get values from
 *
 * @return array|bool   Returns array of 'property' => 'value', or 'false' if error. If a property does not exist
 * then the return array will contain 'null' in that property's position.
 */
function clipit_user_get_properties($id, $prop_array){
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
 * Set values to specified properties of a user.
 *
 * @param int   $id          Id from user
 * @param array $prop_array  Array of properties to set values into
 * @param array $value_array Array of associated values to set into properties
 *
 * @return bool Returns 'true' if success, 'false' if error.
 */
function clipit_user_set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        return false;
    }
    $user = new ClipitUser($id);
    if(!$user){
        return false;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $user->$prop_array[$i] = $value_array[$i];
    }
    if(!$user->save()){
        return false;
    }
    return true;
}

/**
 * Get all users from the system.
 *
 * @param int $limit Number of results to show, default: 0 (no limit) (optional)
 *
 * @return array Returns an array of ClipitUser objects
 */
function clipit_user_get_all_users($limit = 0){
    $elgg_user_array = elgg_get_entities(array('type' => 'user', 'limit' => $limit));
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
 *
 * @return array Returns an array of ClipitUser objects
 */
function clipit_user_get_users_by_id($id_array){
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
 *
 * @return array Returns an array of ClipitUser objects
 */
function clipit_user_get_users_by_login($login_array){
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
 *
 * @return array Returns an array of ClipitUser objects
 */
function clipit_user_get_users_by_email($email_array){
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
 *
 * @return array Returns an array of ClipitUser objects
 */
function clipit_user_get_users_by_role($role_array){
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
