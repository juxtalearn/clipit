<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      urjc_backend
 */

/**
 * Class UBUser
 *
 */
class UBUser extends UBItem{
    /**
     * @const string Elgg entity type for this class
     * @const string Elgg entity subtype for this class
     * @const string Default User Role if not specified
     */
    const TYPE = "user";
    const SUBTYPE = "";

    /**
     * @var string Login name used to authenticate
     * @var string Login password (md5 of password + password_hash)
     * @var string Random string to encode password
     * @var string User email
     * @var string User role (default: "user")
     */
    public $login = "";
    public $password = "";
    public $email = "";
    public $role = "user";
    public $language = "";
    public $last_login = 0;
    private $hash = "";

    function __construct($id = null){
        if(!empty($id)){
            if(!($elgg_user = new ElggUser($id))){
                throw new APIException("ERROR: Id '" . $id . "' does not correspond to a " . get_called_class() . " object.");
            }
            $this->load_from_elgg($elgg_user);
        }
    }

    /**
     * Loads a User instance from the system.
     *
     * @param ElggUser $elgg_user User to load from the system.
     *
     * @return UBUser|bool Returns User instance, or false if error.
     */
    protected function load_from_elgg($elgg_user){
        parent::load_from_elgg($elgg_user);
        $this->email = (string)$elgg_user->email;
        $this->login = (string)$elgg_user->username;
        $this->password = (string)$elgg_user->password;
        $this->hash = (string)$elgg_user->salt;
        $this->role = (string)$elgg_user->role;
        $this->language = (string)$elgg_user->language;
        $this->last_login = (int)$elgg_user->last_login;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        if(empty($this->id)){
            $elgg_user = new ElggUser();
            $elgg_user->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_user = new ElggUser($this->id)){
            return false;
        }
        $this->copy_to_elgg($elgg_user);
        $elgg_user->save();
        return $this->id = $elgg_user->guid;
    }

    /**
     * Deletes an instance from the system.
     *
     * @return bool True if success, false if error.
     */
    protected function delete(){
        if(!$elgg_user = new ElggUser((int)$this->id)){
            return false;
        }
        return $elgg_user->delete();
    }

    protected function copy_to_elgg($elgg_user){
        parent::copy_to_elgg($elgg_user);
        $elgg_user->email = $this->email;
        $elgg_user->username = $this->login;
        $elgg_user->password = $this->password;
        $elgg_user->salt = $this->hash;
        $elgg_user->role = $this->role;
        if($this->language == ""){
            $elgg_user->language = get_language();
        } else{
            $elgg_user->language = $this->language;
        }
        $elgg_user->owner_guid = 0;
        $elgg_user->container_guid = 0;
    }
    /**
     * Creates an encoded user password using a random hash for encoding.
     *
     * @param string $clear_password The new user password in clear text.
     *
     * @return bool 'true' if success, 'false' if error.
     */
    protected static function create_password($clear_password){
        if(!$clear_password){
            return false;
        }
        $new_password = array();
        $new_password["hash"] = generate_random_cleartext_password();
        $new_password["password"] = md5($clear_password . $new_password["hash"]);
        return $new_password;
    }

    /**
     * Sets values to specified properties of an Item
     *
     * @param int   $id Id of Item to set property valyes
     * @param array $prop_value_array Array of property=>value pairs to set into the Item
     *
     * @return int|bool Returns Id of Item if correct, or false if error
     * @throws InvalidParameterException
     */
    static function set_properties($id, $prop_value_array){
        if(!$item = new static($id)){
            return false;
        }
        foreach($prop_value_array as $prop => $value){
            if($prop == "id"){
                throw new InvalidParameterException("ERROR: Cannot modify 'id' of instance.");
            }
            if($prop == "password"){
                $new_password = static::create_password($value);
                $item->password = $new_password["password"];
                $item->hash = $new_password["hash"];
                continue;
            } if(!array_key_exists($prop, self::list_properties())){
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }else{
                $item->$prop = $value;
            }
        }
        return $item->save();
    }

    /**
     * Authenticate a user and log him into the system.
     *
     * @param string $login User login
     * @param string $password User password
     * @param bool   $persistent Determines whether to make the session persistent
     *
     * @return bool Returns true if ok, or false if error
     */
    static function login($login, $password, $persistent = false){
        if(!elgg_authenticate($login, $password)){
            return false;
        }
        $elgg_user = get_user_by_username($login);
        return login($elgg_user, $persistent);
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
     *
     * @return UBUser[] Returns an array of User objects
     */
    static function get_by_login($login_array){
        $user_array = array();
        foreach($login_array as $login){
            $elgg_user = get_user_by_username($login);
            if(!$elgg_user){
                $user_array[$login] = null;
            } else{
                $user_array[$login] = new static((int)$elgg_user->guid);
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
     *
     * @return UBUser[] Returns an array of arrays of User objects
     */
    static function get_by_email($email_array){
        $user_array = array();
        foreach($email_array as $email){
            $elgg_user_array = get_user_by_email($email);
            if(!$elgg_user_array){
                $user_array[$email] = null;
            } else{
                $temp_array = array();
                foreach($elgg_user_array as $elgg_user){
                    $temp_array[] = new static((int)$elgg_user->guid);
                }
                $user_array[$email] = $temp_array;
            }
        }
        return $user_array;
    }

    /**
     * Get users with role contained in a given list of roles.
     *
     * @param array $role_array Array of user roles
     *
     * @return UBUser[] Returns an array of arrays of User objects
     */
    static function get_by_role($role_array){
        $user_array = array();
        foreach($role_array as $role){
            $elgg_user_array = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE,
                    'subtype' => static::SUBTYPE,
                    'metadata_names' => array("role"),
                    'metadata_values' => array($role)
                )
            );
            if(!$elgg_user_array){
                $user_array[$role] = null;
            } else{
                $temp_array = array();
                foreach($elgg_user_array as $elgg_user){
                    $temp_array[] = new static($elgg_user->guid);
                }
                $user_array[$role] = $temp_array;
            }
        }
        return $user_array;
    }

    static function get_last_login($id){
        $user = new static($id);
        return $user->last_login;
    }
}