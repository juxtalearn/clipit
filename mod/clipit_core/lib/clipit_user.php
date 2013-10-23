<?php
/**
 * ClipItUser functions package
 *
 * This package has functions to work with the ClipitUser class.
 *
 * PHP version:     >= 5.2
 *
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @category        Library
 * @package         clipit
 * @subpackage      user
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 *
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3. *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details. *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */
function clipit_user_expose_functions(){
    expose_function("clipit.user.list_properties",
        "clipit_user_list_properties",
        null, "description", 'GET', false, true);
    expose_function("clipit.user.get_properties",
        "clipit_user_get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.set_properties",
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
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.create_user",
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
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.delete_user",
        "clipit_user_delete_user",
        array(
            "id" => array(
                "type" => "int",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.get_all_users",
        "clipit_user_get_all_users",
        NULL,
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.get_users_by_id",
        "clipit_user_get_users_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.get_users_by_login",
        "clipit_user_get_users_by_login",
        array(
            "login_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.get_users_by_email",
        "clipit_user_get_users_by_email",
        array(
            "email_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.user.get_users_by_role",
        "clipit_user_get_users_by_role",
        array(
            "role_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
}

function clipit_user_list_properties(){
    return get_class_vars("ClipitUser");
}

function clipit_user_create_user($login, $password, $name, $email, $role = null, $description = null){
    if(empty($login)){
        throw(new InvalidParameterException("The user login cannot be empty"));
    }
    if(get_user_by_username($login)){
        throw(new InvalidParameterException("The user login already exists"));
    }
    if(!$user = new ClipitUser()){
        return false;
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
    if($user->save()){
        return "User with id = $user->id was created";
    }
    else{
        throw(new CallException("There was a problem creating the new user"));
    }
}

function clipit_user_delete_user($id){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->delete();
}

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
    return $user->save();
}

function clipit_user_get_all_users($limit = false){
    $elgg_user_array = elgg_get_entities(array('type' => 'user', 'limit' => $limit));
    $user_array = array();
    $i = 0;
    foreach($elgg_user_array as $elgg_user){
        $user_array[$i] = new ClipitUser($elgg_user->guid);
        $i++;
    }
    return $user_array;
}

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
