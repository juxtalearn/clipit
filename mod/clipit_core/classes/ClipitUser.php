<?php

/**
 * ClipIt Core User class package
 *
 * This package defines the ClipIt User class which is instantiated to represent
 * each of the users which interact with the ClipIt Core.
 *
 * PHP version:     >= 5.2
 *
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @category        Class
 * @package         clipit
 * @subpackage      core
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

/**
 * Description for class
 *
 * @package     clipit
 * @subpackage  user
 */
class ClipitUser{
    /**
     * @var int ClipitUser instance unique ID (-1 = unsaved)
     */
    public $id = -1;
    /**
     * @var string Login name used to authenticate
     */
    public $login = "";
    /**
     * @var string Login password (md5 of password + password_hash)
     */
    public $password = "";
    /**
     * @var string Random string to encode password (do not edit)
     */
    public $password_hash = "";
    /**
     * @var string Free text for user description (optional)
     */
    public $description = "";
    /**
     * @var string User email
     */
    public $email = "";
    /**
     * @var string Full user name
     */
    public $name = "";
    /**
     * @var string User role: student, teacher, admin
     */
    public $role = "user";
    /**
     * @var int Timestamp when the user was first saved
     */
    public $time_created = -1;

    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    function load($id = null){
        $elgg_user = null;
        if($id){
            $elgg_user = new ElggUser($id);
        }
        if(!$elgg_user){
            return false;
        }
        $this->description      = $elgg_user->description;
        $this->email            = $elgg_user->email;
        $this->name             = $elgg_user->name;
        $this->id               = $elgg_user->guid;
        $this->login            = $elgg_user->username;
        $this->password         = $elgg_user->password;
        $this->password_hash    = $elgg_user->salt;
        $this->role             = $elgg_user->role;
        $this->time_created     = $elgg_user->time_created;
        return $this;
    }

    function save(){
        if($this->id == -1){
            $elgg_user = new ElggUser();
            $id = $elgg_user->save();
            $this->id = $id;
        } else{
            $elgg_user = new ElggUser($this->id);
        }
        if(!$elgg_user){
            return false;
        }
        $elgg_user->description     = $this->description;
        $elgg_user->email           = $this->email;
        $elgg_user->name            = $this->name;
        $elgg_user->username        = $this->login;
        $elgg_user->password        = $this->password;
        $elgg_user->salt            = $this->password_hash;
        $elgg_user->role            = $this->role;
        return $elgg_user->save();
    }

    function delete(){
        $elgg_user = get_user($this->id);
        if(!$elgg_user){
            return false;
        }
        return $elgg_user->delete();
    }
}