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
 * @subpackage      clipit_api
 */

/**
 * Class ClipitUser
 *
 */
class ClipitUser extends UBUser{
    /**
     * @const Role name for Students
     */
    const ROLE_STUDENT = "student";
    /**
     * @const Role name for Teachers
     */
    const ROLE_TEACHER = "teacher";
    /**
     * @const Role name for Administrators
     */
    const ROLE_ADMIN = "admin";
    /**
     * @const Default cookie token duration in minutes
     */
    const COOKIE_TOKEN_DURATION = 60;

    /**
     * Saves this instance into the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        $id = parent::save();
        switch(strtolower($this->role)){
            case static::ROLE_STUDENT:
                remove_user_admin($this->id);
                break;
            case static::ROLE_TEACHER:
                make_user_admin($this->id);
                break;
            case static::ROLE_ADMIN:
                make_user_admin($this->id);
                break;
        }
        return $id;
    }

    static function save_to_excel($id_array = null){
        // New Excel object
        $php_excel = new PHPExcel();
        // Set document properties
        $php_excel->getProperties()->setCreator("ClipIt")
            ->setTitle("ClipIt User Accounts")
            ->setKeywords("clipit user account");
        // Add table title and columns
        $active_sheet = $php_excel->setActiveSheetIndex(0);
        $row = 1;
        $col = 0;
        $values = array("NAME", "LOGIN", "PASSWORD", "EMAIL", "ROLE");
        foreach($values as $value) {
            $active_sheet->setCellValueByColumnAndRow($col++, $row, $value);
        }
        // Load ClipIt Users
        if(!empty($id_array)){
            $user_array = static::get_by_id($id_array);
        } else{
            $user_array = static::get_all();
        }
        // Write Users to spreadsheet
        $row = 2;
        $col = 0;
        foreach($user_array as $user){
            $values = array($user->name, $user->login, "<password>", $user->email, $user->role);
            foreach($values as $value){
                $active_sheet->setCellValueByColumnAndRow($col++, $row, $value);
            }
            $row++;
            $col = 0;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
        $objWriter->save('/tmp/test.xlsx');

        return true;

    }

    /**
     * Add Users from an Excel file, and return an array of User Ids from those created or selected from the file.
     *
     * @param string $file_path Local file path
     * @return array|null Array of User IDs, or null if error.
     */
    static function add_from_excel($file_path){
        $php_excel = PHPExcel_IOFactory::load($file_path);
        $user_array = array();
        $row_iterator = $php_excel->getSheet()->getRowIterator();
        while($row_iterator->valid()){
            $row_result = static::process_excel_row($row_iterator->current());
            if(!empty($row_result)){
                $user_array[] = (int)$row_result;
            }
            $row_iterator->next();
        }
        return $user_array;
    }

    /**
     * Process a single role from an Excel file, containing one user, and add it to ClipIt if new
     *
     * @param PHPExcel_Worksheet_Row $row_iterator
     * @return int|false ID of User contained in row, or false in case of error.
     */
    private function process_excel_row($row_iterator){
        $prop_value_array = array();
        $cell_iterator = $row_iterator->getCellIterator();
        // Check for non-user row
        $value = $cell_iterator->current()->getValue();
        if(empty($value) || strtolower($value) == "users" || strtolower($value) == "name") {
            return null;
        }
        // name
        $name = $value;
        $prop_value_array["name"] = (string) $name;
        $cell_iterator->next();
        // login
        $login = (string) $cell_iterator->current()->getValue();
        if(!empty($login)){
            $user_array = static::get_by_login(array($login));
            if(!empty($user_array[$login])){ // user already exists, no need to create it
                return (int)$user_array[$login]->id;
            }
            $prop_value_array["login"] = $login;
        } else{
            return null;
        }
        $cell_iterator->next();
        // password
        $password = (string) $cell_iterator->current()->getValue();
        if(!empty($password)) {
            $prop_value_array["password"] = $password;
        } else{
            return null;
        }
        $cell_iterator->next();
        // email
        $email = (string) $cell_iterator->current()->getValue();
        if(!empty($email)) {
            $prop_value_array["email"] = $email;
        }
        $cell_iterator->next();
        // role
        $role = (string) $cell_iterator->current()->getValue();
        if(!empty($role)) {
            $prop_value_array["role"] = $role;
        }
        return static::create($prop_value_array);
    }

    static function login($login, $password, $persistent = false){
        if(!parent::login($login, $password, $persistent)){
            return false;
        }
        static::create_cookies($login, $password);
        return true;
    }

    static function logout(){
        static::delete_cookies();
        return parent::logout();
    }

    static function create_cookies($login, $password){
        $user = static::get_by_login(array($login));
        $user = $user[$login];
        $token = UBSite::get_token($login, $password, static::COOKIE_TOKEN_DURATION);
        $jxl_cookie_auth = new JuxtaLearn_Cookie_Authentication(get_config("jxl_secret"), ClipitSite::get_domain());
        $jxl_cookie_auth->set_required_cookie($user->login, $user->role, $user->id);
        $jxl_cookie_auth->set_name_cookie($user->name);
        $jxl_cookie_auth->set_token_cookie($token);
        $jxl_cookie_auth->set_mail_cookie($user->email);
    }

    static function delete_cookies(){
        $jxl_cookie_auth = new JuxtaLearn_Cookie_Authentication(get_config("jxl_secret"), ClipitSite::get_domain());
        $jxl_cookie_auth->delete_cookies();
    }

    /**
     * Get all Group Ids in which a user is member of.
     *
     * @param int $user_id Id of the user to get groups from.
     *
     * @return array Returns an array of Group IDs the user is member of.
     */
    static function get_groups($user_id){
        return UBCollection::get_items($user_id, ClipitGroup::REL_GROUP_USER, true);
    }

    /**
     * Get all Activity Ids in which a user is member of, or a teacher is in charge of.
     *
     * @param int $user_id Id of the user to get activities from.
     * @param bool $joined_only Only returnes Activities where a Student user has joined to a group.
     *
     * @return array Returns an array of Activity IDs the user is member of.
     */
    static function get_activities($user_id, $joined_only = false){
        $prop_value_array = static::get_properties($user_id, array("role"));
        $user_role = $prop_value_array["role"];
        switch ($user_role){
            case static::ROLE_STUDENT:
                if($joined_only){
                    $group_ids = static::get_groups($user_id);
                    if(empty($group_ids)){
                        return false;
                    }
                    foreach($group_ids as $group_id){
                        $activity_array[] = ClipitGroup::get_activity($group_id);
                    }
                    if(!isset($activity_array)){
                        return false;
                    }
                    return $activity_array;
                } else{
                    return UBCollection::get_items($user_id, ClipitActivity::REL_ACTIVITY_USER, true);
                }
            case static::ROLE_TEACHER:
                return UBCollection::get_items($user_id, ClipitActivity::REL_ACTIVITY_TEACHER, true);
        }
        return null;
    }

    /**
     * Sets a User role to Student.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_student($user_id){
        $prop_value_array["role"] = static::ROLE_STUDENT;
        return static::set_properties($user_id, $prop_value_array);
    }

    /**
     * Sets a User role to Teacher.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_teacher($user_id){
        $prop_value_array["role"] = static::ROLE_TEACHER;
        return static::set_properties($user_id, $prop_value_array);
    }

    /**
     * Sets a User role to Admin.
     *
     * @param int $user_id User Id.
     *
     * @return int Returns the User Id if set correctly.
     */
    static function set_role_admin($user_id){
        $prop_value_array["role"] = static::ROLE_ADMIN;
        return static::set_properties($user_id, $prop_value_array);
    }
}