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
    public $avatar;
    public $description;
    public $email;
    public $name;
    public $id;
    public $login;
    public $password;
    public $role;
    public $creation_date;

    function __construct($id = null){
        $this->avatar = ""; //@todo insert ClipitFile instance
        $this->description = "";
        $this->email = "";
        $this->name = "";
        $this->id = $id;
        $this->login = "";
        $this->password = "";
        $this->role = "basic";
        $date = new DateTime();
        $this->creation_date = (int) $date->getTimestamp();
        if(!$id){
            $elgg_user = new ElggUser();
            $id = $elgg_user->save();
            $this->id = $id;
            $this->login = "user_".$id;
            $this->save();
        }
        $this->load($id);
    }

    function load($id){
        $elgg_user = new ElggUser($id);
        if(!$elgg_user || !is_a($elgg_user, "ElggUser")){
            return null;
        }
        $this->avatar = $elgg_user->get("avatar");
        $this->description = $elgg_user->get("description");
        $this->email = $elgg_user->get("email");
        $this->name = $elgg_user->get("name");
        $this->id = $elgg_user->get('guid');
        $this->login = $elgg_user->get("username");
        $this->password = $elgg_user->get("password");
        $this->role = $elgg_user->get("role");
        $this->creation_date = $elgg_user->get("creation_date");
        return $this;
    }

    function save(){
        $elgg_user = new ElggUser($this->id);
        if(!$elgg_user){
            return false;
        }
        $elgg_user->set("avatar", $this->avatar);
        $elgg_user->set("description", $this->description);
        $elgg_user->set("email", $this->email);
        $elgg_user->set("name", $this->name);
        $elgg_user->set("username",$this->login);
        $elgg_user->set("password", $this->password);
        $elgg_user->set("role", $this->role);
        $elgg_user->set("creation_date", $this->creation_date);
        return $elgg_user->save();
    }

    static function exposeFunctions(){
        expose_function("clipit.user.getProperties",
            "ClipitUser::getProperties",
            array(
                "id" => array(
                    "type" => "int",
                    "required" => true),
                "prop_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>",
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
            "<description>",
            'GET',
            true,
            false);
        expose_function("clipit.user.getAllUsers",
            "ClipitUser::getAllUsers",
            NULL,
            "<description>",
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersById",
            "ClipitUser::getUsersById",
            array(
                "id_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>",
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersByLogin",
            "ClipitUser::getUsersByLogin",
            array(
                "login_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>",
            'GET',
            true,
            false);
        expose_function("clipit.user.getUsersByEmail",
            "ClipitUser::getUsersByEmail",
            array(
                "email_array" => array(
                    "type" => "array",
                    "required" => true)),
            "<description>",
            'GET',
            true,
            false);
    }

    static function getProperties($id, $prop_array){
        $user = new ClipitUser($id);
        if(!$user){
            return null;
        }
        $value_array = array();
        for($i=0; $i<count($prop_array); $i++){
            $value_array[$i] = $user->$prop_array[$i];
        }
        return array_combine($prop_array, $value_array);
    }

    static function setProperties($id, $prop_array, $value_array){
        if(count($prop_array)!=count($value_array)){
            return null;
        }
        $user = new ClipitUser($id);
        if(!$user){
            return null;
        }
        for($i=0; $i<count($prop_array); $i++){
            $user->$prop_array[$i] = $value_array[$i];
        }
        return $user->save();
    }

    static function getAllUsers(){
        $elgg_user_array = elgg_get_entities(array('types'=>'user'));
        $user_array = array();
        for($i = 0; $i < count($elgg_user_array); $i++){
            $user_array[$i] = new ClipitUser((int) $elgg_user_array[$i]->get("guid"));
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

    static function getUsersById($id_array){
        for($i = 0; $i < count($id_array); $i++){
            $user_array[$i] = new ClipitUser((int) $id_array[$i]);
        }
        if(!$user_array){
            return null;
        }
        return $user_array;
    }

    static function getUsersByLogin($login_array){
        for($i = 0; $i < count($login_array); $i++){
            $elgg_user = get_user_by_username($login_array[$i]);
            $users[$i] = new ClipitUser($elgg_user->get("guid"));
        }
        if(!$users){
            return null;
        }
        return $users;
    }

    static function getUsersByEmail($email_array){
        $users = array();
        for($i = 0; $i < count($email_array); $i++){
            $elgg_users = get_user_by_email($email_array[$i]);
            for($j = 0; $j < count($elgg_users); $j++){
                $temp_array[$j] = new ClipitUser($elgg_users[$j]->get("guid"));
            }
            if(isset($temp_array)){
                $users = array_merge($users, $temp_array);
                unset($temp_array);
            }
        }
        if(!$users){
            return null;
        }
        return $users;
    }

}