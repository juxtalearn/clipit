<?php
/**
 * @package clipit\user
 */
namespace clipit\user;

    /**
     * ClipIt - JuxtaLearn Web Space
     * PHP version:     >= 5.2
     * Creation date:   2013-10-10
     * Last update:     $Date$
     *
     * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://juxtalearn.org
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
 * Lists the properties contained in this class.
 *
 * @return array Array of properties with type and default value
 */
function list_properties(){
    return ClipitUser::listProperties();
}

/**
 * Get the values for the specified properties of a User.
 *
 * @param int $id Id from User
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of [property => value] pairs, or false if error.
 * If a property does not exist, the returned array will show null as that propertie's value.
 */
function get_properties($id, $prop_array){
    $user = new ClipitUser($id);
    if(!$user){
        return false;
    }
    return $user->getProperties($prop_array);
}

/**
 * Set values to specified properties of a User.
 *
 * @param int $id Id from User
 * @param array $prop_array Array of properties to set values into
 * @param array $value_array Array of associated values to set into properties
 * @return bool Returns true if success, false if error
 * @throws \InvalidParameterException If count(prop_array) != count(value_array)
 */
function set_properties($id, $prop_array, $value_array){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->setProperties($prop_array, $value_array);
}

/**
 * Create a new ClipItUser instance, and save it into the system.
 *
 * @param string $login User login
 * @param string $password User password (min length = 6)
 * @param string $name User full name
 * @param string $email User email
 * @param string $role User role (optional)
 * @param string $description User description (optional)
 * @return bool|int Returns the new User Id, or 'false' if error
 * @throws \InvalidParameterException
 */
function create($login,
                $password,
                $name,
                $email,
                $role = ClipitUser::DEFAULT_ROLE,
                $description = ""){
    if(get_user_by_username($login)){
        throw(new \InvalidParameterException("The user login already exists"));
    }
    $prop_value_array["login"] = $login;
    $prop_value_array["password"] = $password;
    $prop_value_array["name"] = $name;
    $prop_value_array["email"] = $email;
    $prop_value_array["role"] = $role;
    $prop_value_array["description"] = $description;
    $user = new ClipitUser();
    return $user->setProperties($prop_value_array);
}

/**
 * Delete a User from the system.
 *
 * @param int $id Id from User to delete
 * @return bool True if success, false if error.
 */
function delete($id){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->delete();
}

/**
 * Get all Users of this from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (optional)
 * @return array Returns an array of ClipitUsers
 */
function get_all($limit = 0){
    return ClipitUser::getAll($limit);
}

/**
 * Get Users with id contained in a given list.
 *
 * @param array $id_array Array of Object Ids
 * @return array Returns an array of ClipitUsers
 */
function get_by_id($id_array){
    return ClipitUser::getById($id_array);
}

/**
 * Get users with login contained in a given list of logins.
 *
 * @param array $login_array Array of user logins
 * @return array Returns an array of ClipitUser objects
 */
function get_by_login($login_array){
    return ClipitUser::getByLogin($login_array);
}

/**
 * Get users with email contained in a given list of emails.
 *
 * @param array $email_array Array of user emails
 * @return array Returns an array of ClipitUser objects
 */
function get_by_email($email_array){
    return ClipitUser::getByEmail($email_array);
}

/**
 * Get users with role contained in a given list of roles.
 *
 * @param array $role_array Array of user roles
 * @return array Returns an array of ClipitUser objects
 */
function get_by_role($role_array){
    return ClipitUser::getByRole($role_array);
}
