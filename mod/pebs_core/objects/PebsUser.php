<?php
/**
 * @package pebs\user
 */
namespace pebs\user;

    /**
     * Pebs Core
     * PHP version:     >= 5.2
     * Creation date:   2013-11-01
     * Last update:     $Date$
     *
     * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://
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
 * Alias so classes outside of this namespace can be used without path.
 * @use \ElggUser
 */
use \ElggUser;
use pebs\PebsItem;

/**
 * Class PebsUser
 *
 * @package pebs\user
 */
class PebsUser extends PebsItem{
    /**
     * @const string Elgg entity type for this class
     * @const string Default User Role if not specified
     */
    const TYPE = "user";
    const DEFAULT_ROLE = "user";
    /**
     * @var string Login name used to authenticate
     * @var string Login password (md5 of password + password_hash)
     * @var string Random string to encode password
     * @var string User email
     * @var string User role (default: "user")
     * @var int Timestamp when the user was first saved
     */
    public $login = "";
    public $password = "";
    private $password_hash = "";
    public $email = "";
    public $role = PebsUser::DEFAULT_ROLE;
    public $time_created = -1;

    /**
     * Loads a User instance from the system.
     *
     * @param int $id Id of the User to load from the system.
     * @return $this|bool Returns User instance, or false if error.
     */
    function load($id){
        if(!$elgg_user = new ElggUser((int)$id)){
            return null;
        }
        $this->description = $elgg_user->description;
        $this->email = $elgg_user->email;
        $this->name = $elgg_user->name;
        $this->id = $elgg_user->guid;
        $this->login = $elgg_user->username;
        $this->password = $elgg_user->password;
        $this->password_hash = $elgg_user->salt;
        $this->role = $elgg_user->role;
        $this->time_created = $elgg_user->time_created;
        return true;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_user = new ElggUser();
        } elseif(!$elgg_user = new ElggUser($this->id)){
            return false;
        }
        $elgg_user->description = $this->description;
        $elgg_user->email = $this->email;
        $elgg_user->name = $this->name;
        $elgg_user->username = $this->login;
        $elgg_user->password = $this->password;
        $elgg_user->salt = $this->password_hash;
        $elgg_user->role = $this->role;
        return $this->id = $elgg_user->save();
    }

    function setProperties($prop_value_array){
        foreach($prop_value_array as $prop => $value){
            if($prop == "password"){
                $this->setPassword($value);
            } else{
                $this->$prop = $value;
            }
        }
        return $this->save();
    }

    /**
     * Creates an encoded user password using a random hash for encoding.
     *
     * @param string $password The new user password in clear text.
     * @return bool 'true' if success, 'false' if error.
     */
    function setPassword($password){
        if(!$password){
            return false;
        }
        $this->password_hash = generate_random_cleartext_password();
        $this->password = md5($password.$this->password_hash);
        return true;
    }

    /**
     * Get users with login contained in a given list of logins.
     *
     * @param array $login_array Array of user logins
     * @return array Returns an array of PebsUser objects
     */
    static function getByLogin($login_array){
        $called_class = (object)get_called_class();
        $user_array = array();
        for($i = 0; $i < count($login_array); $i++){
            $elgg_user = get_user_by_username($login_array[$i]);
            if(!$elgg_user){
                $user_array[$i] = null;
                continue;
            }
            $user_array[$i] = new $called_class($elgg_user->guid);
        }
        return $user_array;
    }

    /**
     * Get users with email contained in a given list of emails.
     *
     * @param array $email_array Array of user emails
     * @return array Returns an array of PebsUser objects
     */
    static function getByEmail($email_array){
        $called_class = (object)get_called_class();
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
                $temp_array[$j] = new $called_class($elgg_user->guid);
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
     * @return array Returns an array of PebsUser objects
     */
    static function getByRole($role_array){
        $called_class = (object)get_called_class();
        $user_array = array();
        foreach($role_array as $role){
            $elgg_user_array = elgg_get_entities_from_metadata(
                array(
                     'type' => $called_class::TYPE,
                     'subtype' => $called_class::SUBTYPE,
                     'metadata_names' => array('role'),
                     'metadata_values' => array($role)
                )
            );
            if(!$elgg_user_array){
                $user_array[] = null;
                continue;
            }
            $temp_array = array();
            foreach($elgg_user_array as $elgg_user){
                $temp_array[] = new $called_class($elgg_user->guid);
            }
            $user_array = array_merge($user_array, $temp_array);
        }
        return $user_array;
    }
}