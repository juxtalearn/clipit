<?php

/**
 * [Short description/title for module]
 *
 * [Long description for module]
 *
 * PHP version:      >= 5.2
 *
 * Creation date:    [YYYY-MM-DD]
 * Last update:      $Date$
 *
 * @category         [name]
 * @package          [name]
 * @subpackage       [name]
 * @author           Pablo Llinás Arnaiz <pebs74@gmail.com>
 * @version          $Version$
 * @link             [URL description]
 *
 * @license          GNU Affero General Public License v3
 * http://www.gnu.org/licenses/agpl-3.0.txt
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

class ClipitUser{

    // Class properties
    public $id;
    public $login;
    public $password;
    public $password_hash;
    public $description;
    public $email;
    public $name;
    public $role;
    public $time_created;

    function __construct($id = null){
        $this->description = "";
        $this->email = "";
        $this->name = "";
        $this->id = -1;
        $this->login = "";
        $this->password = "";
        $this->password_hash = "";
        $this->role = "basic";
        $this->time_created = -1;
        if(!$id){
            $elgg_user = new ElggUser();
            $id = $elgg_user->save();
            $this->id = $id;
            $this->login = "user_".$id;
            $this->save();
        }
        $this->load($id);
    }

    function save(){
        $elgg_user = new ElggUser($this->id);
        if(!$elgg_user){
            return false;
        }
        $elgg_user->set("description", $this->description);
        $elgg_user->set("email", $this->email);
        $elgg_user->set("name", $this->name);
        $elgg_user->set("username", $this->login);
        $elgg_user->set("password", $this->password);
        $elgg_user->set("salt", $this->password_hash);
        $elgg_user->set("role", $this->role);
        return $elgg_user->save();
    }

    function load($id){
        $elgg_user = new ElggUser($id);
        if(!$elgg_user || !is_a($elgg_user, "ElggUser")){
            return null;
        }
        $this->description = $elgg_user->get("description");
        $this->email = $elgg_user->get("email");
        $this->name = $elgg_user->get("name");
        $this->id = $elgg_user->get('guid');
        $this->login = $elgg_user->get("username");
        $this->password = $elgg_user->get("password");
        $this->password_hash = $elgg_user->salt;
        $this->role = $elgg_user->get("role");
        $this->time_created = $elgg_user->get("time_created");
        return $this;
    }

    static function exposeFunctions(){
        expose_function("clipit.user.newUser",
            "ClipitUser::newUser",
            array(
                "login" => array(
                    "type" => "string",
                    "required" => true),
                "password" => array(
                    "type" => "string",
                    "required" => false),
                "name" => array(
                    "type" => "string",
                    "required" => false),
                "email" => array(
                    "type" => "string",
                    "required" => false),
                "role" => array(
                    "type" => "string",
                    "required" => false),
                "description" => array(
                    "type" => "string",
                    "required" => false)
                ),
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.getProperties",
            "ClipitUser::getProperties",
            array(
                "id" => array(
                    "type" => "int",
                    "required" => true),
                "prop_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.setProperties",
            "ClipitUser::setProperties",
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
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.getAllUsers",
            "ClipitUser::getAllUsers",
            NULL,
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersById",
            "ClipitUser::getUsersById",
            array(
                "id_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersByLogin",
            "ClipitUser::getUsersByLogin",
            array(
                "login_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>", //@todo
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersByEmail",
            "ClipitUser::getUsersByEmail",
            array(
                "email_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>", //@todo
            'GET',
            true,
            false);
    }

    static function newUser($login, $password = null, $name = null, $email = null, $role= null, $description= null){
        if(get_user_by_username($login)){
            throw(new InvalidParameterException("The user login already exists"));
        }
        if(!$user = new ClipitUser()){
            return null;
        }
        $user->login = $login;
        if($password){
            $user->password_hash = generate_random_cleartext_password();
            $user->password = md5($password.$user->password_hash);
        }
        if($name){
            $user->name = $name;
        }
        if($email){
            $user->email = $email;
        }
        if($role){
            $user->role = $role;
        }
        if($description){
            $user->description = $description;
        }
        return $user->save();
    }

    static function getProperties($id, $prop_array){
        $user = new ClipitUser($id);
        if(!$user){
            return null;
        }
        $value_array = array();
        for($i = 0; $i < count($prop_array); $i++){
            $value_array[$i] = $user->$prop_array[$i];
        }
        return array_combine($prop_array, $value_array);
    }

    static function setProperties($id, $prop_array, $value_array){
        if(count($prop_array) != count($value_array)){
            return null;
        }
        $user = new ClipitUser($id);
        if(!$user){
            return null;
        }
        for($i = 0; $i < count($prop_array); $i++){
            $user->$prop_array[$i] = $value_array[$i];
        }
        return $user->save();
    }

    static function getAllUsers(){
        $elgg_user_array = elgg_get_entities(array('type' => 'user'));
        $user_array = array();
        for($i = 0; $i < count($elgg_user_array); $i++){
            $user_array[$i] = new ClipitUser($elgg_user_array[$i]->guid);
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

    static function getUsersById($id_array){
        $user_array = array();
        for($i = 0; $i < count($id_array); $i++){
            $elgg_user = get_user($id_array[$i]);
            if(!$elgg_user){
                $user_array[$i] = null;
                continue;
            }
            $user_array[$i] = new ClipitUser($elgg_user->guid);
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

    static function getUsersByLogin($login_array){
        $user_array = array();
        for($i = 0; $i < count($login_array); $i++){
            $elgg_user = get_user_by_username($login_array[$i]);
            if(!$elgg_user){
                $user_array[$i] = null;
                continue;
            }
            $user_array[$i] = new ClipitUser($elgg_user->get("guid"));
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

    static function getUsersByEmail($email_array){
        $user_array = array(); // so that the first merge doesn't fail
        for($i = 0; $i < count($email_array); $i++){
            $elgg_user_array = get_user_by_email($email_array[$i]);
            if(!$elgg_user_array){
                $user_array[$i] = null;
                continue;
            }
            $temp_array = array();
            for($j = 0; $j < count($elgg_user_array); $j++){
                $temp_array[$j] = new ClipitUser($elgg_user_array[$j]->getguid);
            }
            if(!$temp_array){
                $user_array[$i] = null;
                continue;
            }
            $user_array = array_merge($user_array, $temp_array);
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

}