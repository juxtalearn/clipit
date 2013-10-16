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

class ClipitUser {

    // Class properties
    public $avatar;
    public $description;
    public $email;
    public $name;
    public $id;
    public $login;
    public $password;
    public $type;
    public $creationDate;

    static function getProperty($id, $prop) {
        $user = ClipitUser::getUsersById(array($id));
        return $user[0]->$prop;
    }

    static function setProperty($id, $prop, $value) {
        $user = ClipitUser::getUsersById(array($id));
        $user[0]->$prop = $value;
        $elgg_user = ClipitUser::clipit2Elgg($user[0]);
        return $elgg_user->save();
    }

    static function exposeFunctions() {
        expose_function("clipit.user.getProperty",
            "ClipitUser::getProperty",
            array(
                "id" => array(
                    "type" => "integer",
                    "required" => true),
                "prop" => array(
                    "type" => "string",
                    "required" => true)),
            "<description>", 'GET', true, false);
        
        expose_function("clipit.user.setProperty",
            "ClipitUser::setProperty",
            array(
                "id" => array(
                    "type" => "integer",
                    "required" => true),
                "prop" => array(
                    "type" => "string",
                    "required" => true),
                "value" => array(
                    "type" => "string",
                    "required" => true)), 
            "<description>", 'GET', true, false);
        
        expose_function("clipit.user.getAllUsers",
            "ClipitUser::getAllUsers",
            NULL, "<description>", 'GET', true, false);
        
        expose_function("clipit.user.getUsersById",
            "ClipitUser::getUsersById",
            array(
                "id_array" => array(
                    "type" => "array", 
                    "required" => true)),
            "<description>", 'GET', true, false);
        
        expose_function("clipit.user.getUsersByLogin",
            "ClipitUser::getUsersByLogin", 
            array(
                "login_array" => array(
                    "type" => "array", 
                    "required" => true)), 
            "<description>", 'GET', true, false);
        
        expose_function("clipit.user.getUsersByEmail", 
            "ClipitUser::getUsersByEmail", 
            array(
                "email_array" => array(
                    "type" => "array", 
                    "required" => true)), 
            "<description>", 'GET', true, false);
    }

    static function elgg2Clipit($elgg_user) {
        if(!$elgg_user || !is_a($elgg_user, "ElggUser")){
            return null;
        }
        $clipit_user = new ClipitUser();
        $clipit_user->avatar = "<TO-DO>";
        $clipit_user->description = "<TO-DO>";
        $clipit_user->email = $elgg_user->get("email");
        $clipit_user->name = $elgg_user->get("name");
        $clipit_user->id = $elgg_user->get("guid");
        $clipit_user->login = $elgg_user->get("username");
        $clipit_user->password = $elgg_user->get("password");
        $clipit_user->type = $elgg_user->get("type");
        $clipit_user->creationDate = "<TO-DO>";
        return $clipit_user;
    }
    
    static function clipit2Elgg(ClipitUser $clipit_user) {
        if(!$clipit_user){
            return null;
        }
        $elgg_user = get_user($clipit_user->id);
        $elgg_user->set("avatar", "<TO-DO>");
        $elgg_user->set("description", $clipit_user->description);
        $elgg_user->set("email", $clipit_user->email);
        $elgg_user->set("name", $clipit_user->name);
        $elgg_user->set("guid", $clipit_user->id);
        $elgg_user->set("username", $clipit_user->login);
        $elgg_user->set("password", $clipit_user->password);
        $elgg_user->set("type", $clipit_user->type);
        $elgg_user->set("creationDate", "<TO-DO>");
        return $elgg_user;
    }

    static function getAllUsers() {
        $user_list = elgg_get_entities(array('types' => 'user'));
        for ($i = 0; $i < count($user_list); $i++) {
            $user_array[$i] = ClipitUser::elgg2Clipit($user_list[$i]);
        }
        return $user_array;
    }

    static function getUsersById($id_array) {
        for($i=0; $i<count($id_array); $i++){
            $users[$i] = ClipitUser::elgg2Clipit(get_user($id_array[$i]));
        }
        if(!$users){return null;}
        return $users;
    }

    static function getUsersByLogin($login_array) {
        for($i=0; $i<count($login_array); $i++){
            $users[$i] = ClipitUser::elgg2Clipit(get_user_by_username($login_array[$i]));
        }
        if(!$users){return null;}
        return $users;
    }

    static function getUsersByEmail($email_array) {
        $users = array();
        for($i=0; $i<count($email_array); $i++){
            $elgg_users = get_user_by_email($email_array[$i]);
            for($j=0; $j<count($elgg_users); $j++){
                $temp_array[$j] = ClipitUser::elgg2Clipit($elgg_users[$j]);
            }
            $users = array_merge($users, $temp_array);
        }
        if(!$users){return null;}
        return $users;
    }

}