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
    public $id = -1;
    public $login = "";
    public $password = "";
    public $password_hash = "";
    public $description = "";
    public $email = "";
    public $name = "";
    public $role = "user";
    public $time_created = -1;

    function __construct($id = null){
        if($id){
            $this->load($id);
        }
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
        $elgg_user->set("description", $this->description);
        $elgg_user->set("email", $this->email);
        $elgg_user->set("name", $this->name);
        $elgg_user->set("username", $this->login);
        $elgg_user->set("password", $this->password);
        $elgg_user->set("salt", $this->password_hash);
        $elgg_user->set("role", $this->role);
        // To prevent from users being private
        $elgg_user->set("access_id", '2');
        return $elgg_user->save();
    }

    function load($id = null){
        $elgg_user = null;
        if($id){
            $elgg_user = new ElggUser($id);
        }
        if(!$elgg_user){
            return false;
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

    function delete(){
        $elgg_user = get_user($this->id);
        if(!$elgg_user){
            return false;
        }
        return $elgg_user->delete();
    }
}