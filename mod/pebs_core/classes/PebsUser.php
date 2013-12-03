<?php
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

class PebsUser extends PebsItem{
    //    Inherited properties:
    //    /**
    //    * @const string Elgg entity TYPE for this class
    //    */
    //    const TYPE = "object";
    //    /**
    //    * @const string Elgg entity SUBTYPE for this class
    //    */
    //    const SUBTYPE = "";
    //    /**
    //    * @var int Unique Id of this instance
    //    */
    //    public $id = -1;
    //    /**
    //    * @var string Name of this instance
    //    */
    //    public $name = "";
    //    /**
    //    * @var string Description of this instance
    //    */
    //    public $description = "";
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
    public $email = "";
    public $role = self::DEFAULT_ROLE;
    public $time_created = -1;

    private $password_hash = "";

    /**
     * Loads a User instance from the system.
     *
     * @param int $id Id of the User to load from the system.
     * @return PebsUser|bool Returns User instance, or false if error.
     */
    protected function _load($id){
        if(!$elgg_user = new ElggUser((int)$id)){
            return null;
        }
        $this->description = (string)$elgg_user->description;
        $this->email = (string)$elgg_user->email;
        $this->name = (string)$elgg_user->name;
        $this->id = (int)$elgg_user->guid;
        $this->login = (string)$elgg_user->username;
        $this->password = (string)$elgg_user->password;
        $this->password_hash = (string)$elgg_user->salt;
        $this->role = (string)$elgg_user->role;
        $this->time_created = (int)$elgg_user->time_created;
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
        $elgg_user->name = $this->name;
        $elgg_user->description = $this->description;
        $elgg_user->email = $this->email;
        $elgg_user->username = $this->login;
        $elgg_user->password = $this->password;
        $elgg_user->salt = $this->password_hash;
        $elgg_user->role = $this->role;
        $elgg_user->save();
        return $this->id = $elgg_user->guid;
    }

    /**
     * Sets values into specified properties of the instance
     *
     * @param array $prop_value_array Array of prop=>value pairs to set into the instance
     * @return int Returns instance Id, or false if error
     * @throws InvalidParameterException
     */
    function setProperties($prop_value_array){
        foreach($prop_value_array as $prop => $value){
            if(!array_key_exists($prop, $this->list_properties())){
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }
            if($prop == "id"){
                throw new InvalidParameterException("ERROR: Cannot modify 'id' of instance.");
            }
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
     * Authenticate a user and log him into the system.
     *
     * @param string $login User login
     * @param string $password User password
     * @param bool $persistent Determines whether to make the session persistent
     * @return bool Returns true if ok, or false if error
     */
    static function login($login, $password, $persistent = false){
        if(!elgg_authenticate($login, $password)){
            return false;
        }
        $elgg_user = get_user_by_username($login);
        login($elgg_user, $persistent);
    }

    /**
     * Logs out a user from the system.
     *
     * @return bool Returns true if ok, or false if error.
     */
    static function logout(){
        return logout();
    }

    /**
     * Get users with login contained in a given list of logins.
     *
     * @param array $login_array Array of user logins
     * @return array Returns an array of User objects
     */
    static function get_by_login($login_array){
        $called_class = get_called_class();
        $user_array = array();
        foreach($login_array as $login){
            $elgg_user = get_user_by_username($login);
            if(!$elgg_user){
                $user_array[] = null;
            } else{
                $user_array[] = new $called_class((int)$elgg_user->guid);
            }
        }
        return $user_array;
    }

    /**
     * Get users with email contained in a given list of emails. Each email can be associated
     * with multiple users. The output will be an array of Users per login, nested inside a main
     * array.
     *
     * @param array $email_array Array of user emails
     * @return array Returns an array of arrays of User objects
     */
    static function get_by_email($email_array){
        $called_class = get_called_class();
        $user_array = array();
        foreach($email_array as $email){
            $elgg_user_array = get_user_by_email($email);
            if(!$elgg_user_array){
                $user_array[] = null;
            } else{
                $temp_array = array();
                foreach($elgg_user_array as $elgg_user){
                    $temp_array[] = new $called_class((int)$elgg_user->guid);
                }
                $user_array[] = $temp_array;
            }
        }
        return $user_array;
    }

    /**
     * Get users with role contained in a given list of roles.
     *
     * @param array $role_array Array of user roles
     * @return array Returns an array of arrays of User objects
     */
    static function get_by_role($role_array){
        $called_class = get_called_class();
        $user_array = array();
        foreach($role_array as $role){
            $elgg_user_array = elgg_get_entities_from_metadata(
                array(
                     'type' => $called_class::TYPE,
                     'subtype' => $called_class::SUBTYPE,
                     'metadata_names' => array("role"),
                     'metadata_values' => array($role)
                )
            );
            if(!$elgg_user_array){
                $user_array[] = null;
            } else{
                $temp_array = array();
                foreach($elgg_user_array as $elgg_user){
                    $temp_array[] = new $called_class($elgg_user->guid);
                }
                $user_array[] = $temp_array;
            }
        }
        return $user_array;
    }
}