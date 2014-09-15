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
 * <Class Description>
 */
class UBItem {
    /**
     * @const string Elgg entity TYPE for this class
     */
    const TYPE = "object";
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "UBItem";
    /**
     * @const string Clone-Parent relationship name
     */
    const REL_PARENT_CLONE = "parent-clone";
    /**
     * @var int Unique Id of this instance
     */
    public $id = null;
    /**
     * @var string Name of this instance
     */
    public $name = "";
    /**
     * @var string Description of this instance
     */
    public $description = "";
    /**
     * @var string URL of the instance
     */
    public $url = "";
    /**
     * @var int Unique Id of the owner/creator of this instance
     */
    public $owner_id = 0;
    /**
     * @var int Timestamp when this Item was created
     */
    public $time_created = 0;
    /**
     * @var int Origin object id, in case this object was cloned. If not = 0.
     */
    public $cloned_from = 0;
    /**
     * @var array Object clone ids.
     */
    public $clone_array = array();

    /**
     * Constructor
     *
     * @param int                   $id          If !null, load instance.
     * @param ElggObject|ElggEntity $elgg_object Object to load instance from (optional)
     *
     * @throws APIException
     */
    function __construct($id = null, $elgg_object = null) {
        if(!empty($id)) {
            if(empty($elgg_object)){
                if(!$elgg_object = new ElggObject($id)) {
                    throw new APIException("ERROR: Failed to load " . get_called_class() ." object with ID '" . $id . "'.");
                }
            }
            $elgg_type = $elgg_object->type;
            $elgg_subtype = $elgg_object->getSubtype();
            if(($elgg_type != static::TYPE) || ($elgg_subtype != static::SUBTYPE)) {
                throw new APIException(
                    "ERROR: ID '" . $id . "' does not correspond to a " . get_called_class() . " object."
                );
            }
            $this->copy_from_elgg($elgg_object);
        }
    }

    /**
     * Saves this instance to the system.
     * @param double_save if double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save($double_save=false) {
        if(!empty($this->id)) {
            if(!$elgg_object = new ElggObject($this->id)) {
                return false;
            }
        } else {
            $elgg_object = new ElggObject();
            $elgg_object->type = static::TYPE;
            $elgg_object->subtype = static::SUBTYPE;
        }
        $this->copy_to_elgg($elgg_object);
        $elgg_object->save();
        if ($double_save) {
            $elgg_object->save(); // Only updates are saving time_created, thus first save for creation, second save for updating to proper creation time if given
        }
        return $this->id = $elgg_object->get("guid");
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        $this->id = (int)$elgg_entity->get("guid");
        $this->name = (string)$elgg_entity->get("name");
        $this->description = (string)$elgg_entity->get("description");
        $this->url = (string)$elgg_entity->get("url");
        $this->owner_id = (int)$elgg_entity->getOwnerGUID();
        $this->time_created = (int)$elgg_entity->getTimeCreated();
        $this->cloned_from = (int)static::get_cloned_from($this->id);
        $this->clone_array = (array)static::get_clones($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        $elgg_entity->set("name", (string)$this->name);
        $elgg_entity->set("description", (string)$this->description);
        $elgg_entity->set("url", (string)$this->url);
        $elgg_entity->set("time_created",(int)$this->time_created);
        $elgg_entity->set("access_id", ACCESS_PUBLIC);

    }

    /* Static Functions */
    /**
     * Lists the properties contained in this object
     * @return array Array of properties with type and default value
     */
    static function list_properties() {
        return get_class_vars(get_called_class());
    }

    /**
     * Get specified property values for an Item
     *
     * @param int   $id         Id of instance to get properties from
     * @param array $prop_array Array of property names to get values from
     *
     * @return array|bool Returns an array of property=>value pairs, or false if error
     * @throws InvalidParameterException
     */
    static function get_properties($id, $prop_array = null) {
        if(!$item = new static($id)) {
            return null;
        }
        $value_array = array();
        if(!empty($prop_array)) {
            foreach($prop_array as $prop) {
                if(array_key_exists($prop, static::list_properties())) {
                    $value_array[$prop] = $item->$prop;
                } else {
                    throw new InvalidParameterException("ERROR: One or more property names do not exist.");
                }
            }
        } else {
            $prop_array = static::list_properties();
            do {
                $prop = key($prop_array);
                $value_array[$prop] = $item->$prop;
            } while(next($prop_array) !== false);
        }
        return $value_array;
    }

    /**
     * Sets values to specified properties of an Item
     *
     * @param int   $id               Id of Item to set property values
     * @param array $prop_value_array Array of property=>value pairs to set into the Item
     *
     * @return int|bool Returns Id of Item if correct, or false if error
     * @throws InvalidParameterException
     */
    static function set_properties($id, $prop_value_array) {
        if(!$item = new static($id)) {
            return false;
        }
        foreach($prop_value_array as $prop => $value) {
            if(!array_key_exists($prop, static::list_properties())) {
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }
            if($prop == "id") {
                continue; // cannot set an item's ID manually.
            }
            $item->$prop = $value;

        }
        if (array_key_exists("time_created",$prop_value_array)) {
            return $item->save(true);
        } else {
            return $item->save(false);
        }
    }

    /**
     * Create a new instance of this class, and assign values to its properties.
     *
     * @param array $prop_value_array Array of [property]=>value pairs to set into the new instance
     *
     * @return int|bool Returns instance Id if correct, or false if error
     */
    static function create($prop_value_array) {
        return static::set_properties(null, $prop_value_array);
    }

    /**
     * Clone the specified Item, including all of its properties.
     *
     * @param int $id Item id from which to create a clone.
     *
     * @return bool|int Id of the new clone Item, false in case of error.
     */
    static function create_clone($id) {
        $prop_value_array = static::get_properties($id);
        $clone_id = static::set_properties(null, $prop_value_array);
        UBCollection::add_items($id, array($clone_id), static::REL_PARENT_CLONE, true);
        return $clone_id;
    }

    /**
     * Get an ID array of all cloned Items from a specified one.
     *
     * @param int $id Item from which to return clones
     * @param bool $recursive Whether to look for clones recursively
     *
     * @return int[] Array of Item IDs
     */
    static function get_clones($id, $recursive = false) {
        $clone_array = array();
        $item_clones = UBCollection::get_items($id, static::REL_PARENT_CLONE);
        if($recursive) {
            foreach($item_clones as $clone) {
                array_push($clone_array, $clone);
                $clone_array = array_merge($clone_array, static::get_clones($clone, true));
            }
        }else{
            $clone_array = $item_clones;
        }
        return $clone_array;
    }

    /**
     * Get the parent Item ID for an Item.
     *
     * @param int $id Item from which to return parent
     * @param bool $recursive Whether to look for parent recursively
     *
     * @return int[] Array of Item IDs
     */
    static function get_cloned_from($id, $recursive = false) {
        $parent = UBCollection::get_items($id, static::REL_PARENT_CLONE, true);
        if(empty($parent)){
            return 0;
        }
        if($recursive){
            $new_parent = $parent;
            while(!empty($new_parent)){
                $parent = $new_parent;
                $new_parent = UBCollection::get_items(array_pop($parent), static::REL_PARENT_CLONE, true);
            }
        }
        return $parent = array_pop($parent);
    }

    /**
     * Get an array with the full clone list of the clone tree an item belongs to
     * @param int $id ID of Item
     *
     * @return int[] Array of item IDs
     * @throws InvalidParameterException
     */
    static function get_clone_tree($id){
        // Find top parent in clone tree
        $top_parent = $id;
        $prop_value_array = static::get_properties($top_parent, array("cloned_from"));
        $new_parent = $prop_value_array["cloned_from"];
        while($new_parent != 0){
            $top_parent = $new_parent;
            $prop_value_array = static::get_properties($top_parent, array("cloned_from"));
            $new_parent = $prop_value_array["cloned_from"];
        }
        $clone_tree = static::get_clones($top_parent, true);
        array_push($clone_tree, $top_parent);
        return $clone_tree;
    }

    /**
     * Delete Items given their Id.
     *
     * @param array $id_array List of Item Ids to delete
     *
     * @return bool Returns true if correct, or false if error
     */
    static function delete_by_id($id_array) {
        foreach($id_array as $id) {
            if(delete_entity($id) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Delete All Items for this class.
     * @return bool Returns true if correct, or false if error
     */
    static function delete_all() {
        $items = static::get_all(0, true);
        if(!empty($items)) {
            static::delete_by_id($items);
        }
        return true;
    }

    /**
     * Get all Object instances of this TYPE and SUBTYPE from the system, optionally only a specified property.
     *
     * @param int  $limit           Number of results to show, default= 0 [no limit] (optional)
     * @param bool $id_only         Properties to return (with key = ID). Default = [all] (object instance)
     * @param bool $order_by_name   Default = false (order by date_inv)
     *
     * @return static[]|int[] Returns an array of Objects, or Object IDs if id_only = true
     */
    static function get_all($limit = 0, $id_only = false, $order_by_name = false) {
        $return_array = array();
        $elgg_entity_array = elgg_get_entities(
            array('type' => static::TYPE, 'subtype' => static::SUBTYPE, 'limit' => $limit)
        );
        if($order_by_name){
            usort($elgg_entity_array, 'static::sort_by_name');
        } else {
            usort($elgg_entity_array, 'static::sort_by_date_inv');
        }
        if(!empty($elgg_entity_array)) {
            foreach($elgg_entity_array as $elgg_entity) {
                if($id_only){
                    $return_array[] = $elgg_entity->guid;
                } else {
                    $return_array[(int)$elgg_entity->guid] = new static((int)$elgg_entity->guid, $elgg_entity);
                }
            }
        }
        return $return_array;
    }

    /**
     * Get Objects with id contained in a given list.
     *
     * @param array $id_array Array of Object Ids
     * @param bool $order_by_name   Default = false (order by date_inv)
     *
     * @return static[] Returns an array of Objects
     */
    static function get_by_id($id_array, $order_by_name = false) {
        $object_array = array();
        foreach($id_array as $id) {
            if(elgg_entity_exists($id)) {
                $object_array[(int)$id] = new static((int)$id);
            } else {
                $object_array[(int)$id] = null;
            }
        }
        if($order_by_name){
            usort($object_array, 'static::sort_by_name');
        }
        return $object_array;
    }

    /**
     * Get Items with Owner Id contained in a given list.
     *
     * @param array $owner_array Array of Owner Ids
     * @param int   $limit       Number of Items to return, default 0 = all
     *
     * @return static[] Returns an array of Items
     */
    static function get_by_owner($owner_array, $limit = 0) {
        $object_array = array();
        foreach($owner_array as $owner_id) {
            $elgg_object_array = elgg_get_entities(
                array(
                    "type" => static::TYPE, "subtype" => static::SUBTYPE, "owner_guid" => (int)$owner_id,
                    "limit" => $limit
                )
            );
            if(!empty($elgg_object_array)) {
                $temp_array = array();
                foreach($elgg_object_array as $elgg_object) {
                    $temp_array[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                }
                if(!empty($temp_array)) {
                    $object_array[(int)$owner_id] = $temp_array;
                    usort($object_array[(int)$owner_id], 'static::sort_by_date');
                } else {
                    $object_array[(int)$owner_id] = null;
                }
            } else{
                $object_array[(int)$owner_id] = null;
            }
        }
        return $object_array;
    }

    /**
     * Gett all system events filtered by the class TYPE and SUBTYPE.
     *
     * @param int $offset Skip the first $offset events
     * @param int $limit  Return at most $limit events
     *
     * @return array Array of system events
     */
    static function get_events($offset = 0, $limit = 10) {
        return get_system_log(
            null, // $by_user = ""
            null, // $event = ""
            null, // $class = ""
            static::TYPE, // $type = ""
            static::SUBTYPE, // $subtype = ""
            $limit, // $limit = 10
            $offset, // $offset = 0
            null, // $count = false
            null, // $timebefore = 0
            null, // $timeafter = 0
            null, // $object_id = 0
            null
        ); // $ip_address = ""
    }

    /**
     * Get all objects which match a $search_string
     *
     * @param string $search_string String for searching matching objects
     * @param bool   $name_only     Whether to look only in the name property, default false.
     * @param bool   $strict        Whether to match the $search_string exactly, including case, or only partially.
     *
     * @return static[] Returns an array of matched objects
     */
    static function get_from_search($search_string, $name_only = false, $strict = false) {
        $search_result = array();
        if(!$strict) {
            $elgg_object_array = elgg_get_entities(
                array('type' => static::TYPE, 'subtype' => static::SUBTYPE, 'limit' => 0)
            );
            $search_result = array();
            foreach($elgg_object_array as $elgg_object) {
                $search_string = strtolower($search_string);
                if(strpos(strtolower($elgg_object->name), $search_string) !== false) {
                    $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                    continue;
                }
                if($name_only === false) {
                    if(strpos(strtolower($elgg_object->description), $search_string) !== false) {
                        $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                    }
                }
            }
        } else { // $strict == true
            $elgg_object_array = elgg_get_entities_from_metadata(
                array(
                    'type' => static::TYPE, 'subtype' => static::SUBTYPE, 'metadata_names' => array("name"),
                    'metadata_values' => array($search_string), 'limit' => 0
                )
            );
            if(!empty($elgg_object_array)) {
                foreach($elgg_object_array as $elgg_object) {
                    $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid, $elgg_object);
                }
            }
        }
        return $search_result;
    }

    /**
     * Sort by Date, oldest to newest.
     *
     * @param static $i1
     * @param static $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_by_date($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        if((int)$i1->time_created == (int)$i2->time_created) {
            return 0;
        }
        return ((int)$i1->time_created < (int)$i2->time_created) ? - 1 : 1;
    }

    /**
     * Sort by Date Inverse order, newest to oldest.
     *
     * @param static $i1
     * @param static $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_by_date_inv($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        if((int)$i1->time_created == (int)$i2->time_created) {
            return 0;
        }
        return ((int)$i1->time_created > (int)$i2->time_created) ? - 1 : 1;
    }

    /**
     * Sort by Name, in alphabetical order.
     *
     * @param static $i1
     * @param static $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_by_name($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        return strcmp($i1->name, $i2->name);
    }

    /**
     * Sort by Name, in inverse alphabetical order.
     *
     * @param static $i1
     * @param static $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_by_name_inv($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        return strcmp($i2->name, $i1->name);
    }

    /**
     * Sort numbers, in increasing order.
     *
     * @param float $i1
     * @param float $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_numbers($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        if((int)$i1 == (int)$i2) {
            return 0;
        }
        return ((int)$i1 < (int)$i2) ? - 1 : 1;
    }

    /**
     * Sort numbers, in decreasing order.
     *
     * @param float $i1
     * @param float $i2
     *
     * @return int Returns 0 if equal, -1 if i1 before i2, 1 if i1 after i2.
     */
    static function sort_numbers_inv($i1, $i2) {
        if(!$i1 && !$i2){
            return 0;
        }elseif(!$i1){
            return 1;
        }elseif(!$i1){
            return -1;
        }
        if((int)$i1 == (int)$i2) {
            return 0;
        }
        return ((int)$i1 > (int)$i2) ? - 1 : 1;
    }

    static function export_data($id_array = null, $format = "excel") {
        // New Excel object
        $php_excel = new PHPExcel();
        // Set document properties
        $php_excel->getProperties()->setCreator("ClipIt")
                  ->setTitle("ClipIt export of " . get_called_class())
                  ->setKeywords("clipit export");
        // Add table title and columns
        $active_sheet = $php_excel->setActiveSheetIndex(0);
        $active_sheet->getDefaultColumnDimension()->setWidth(40);
        $active_sheet->getStyle(1)->getFont()->setBold(true);
        $row = 1;
        $col = 0;
        $properties = static::list_properties();
        foreach(array_keys($properties) as $prop_name) {
            $active_sheet->setCellValueByColumnAndRow($col ++, $row, $prop_name);
        }
        // Load Items
        if(!empty($id_array)) {
            $item_array = static::get_by_id($id_array);
        } else {
            $item_array = static::get_all();
        }
        // Write Items to spreadsheet
        $row = 2;
        $col = 0;
        foreach($item_array as $item) {
            foreach(array_keys($properties) as $prop_name){
                $active_sheet->setCellValueByColumnAndRow($col++, $row, $item->$prop_name);
            }
            $row++;
            $col = 0;
        }
        switch($format) {
            case "excel":
                $objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
                $objWriter->save("/tmp/export_".get_called_class().".xlsx");
        }
        return true;
    }

//    /**
//     * Add Users from an Excel file, and return an array of User Ids from those created or selected from the file.
//     *
//     * @param string $file_path Local file path
//     *
//     * @return array|null Array of User IDs, or null if error.
//     */
//    static function import_data($file_path) {
//        $php_excel = PHPExcel_IOFactory::load($file_path);
//        $user_array = array();
//        $row_iterator = $php_excel->getSheet()->getRowIterator();
//        while($row_iterator->valid()) {
//            $row_result = static::parse_excel_row($row_iterator->current());
//            if(!empty($row_result)) {
//                $user_array[] = (int)$row_result;
//            }
//            $row_iterator->next();
//        }
//        return $user_array;
//    }
//
//    /**
//     * Parse a single role from an Excel file, containing one user, and add it to ClipIt if new
//     *
//     * @param PHPExcel_Worksheet_Row $row_iterator
//     *
//     * @return int|false ID of User contained in row, or false in case of error.
//     */
//    private function parse_excel_row($row_iterator) {
//        $prop_value_array = array();
//        $cell_iterator = $row_iterator->getCellIterator();
//        // Check for non-user row
//        $value = $cell_iterator->current()->getValue();
//        if(empty($value) || strtolower($value) == "users" || strtolower($value) == "name") {
//            return null;
//        }
//        // name
//        $name = $value;
//        $prop_value_array["name"] = (string)$name;
//        $cell_iterator->next();
//        // login
//        $login = (string)$cell_iterator->current()->getValue();
//        if(!empty($login)) {
//            $user_array = static::get_by_login(array($login));
//            if(!empty($user_array[$login])) { // user already exists, no need to create it
//                return (int)$user_array[$login]->id;
//            }
//            $prop_value_array["login"] = $login;
//        } else {
//            return null;
//        }
//        $cell_iterator->next();
//        // password
//        $password = (string)$cell_iterator->current()->getValue();
//        if(!empty($password)) {
//            $prop_value_array["password"] = $password;
//        } else {
//            return null;
//        }
//        $cell_iterator->next();
//        // email
//        $email = (string)$cell_iterator->current()->getValue();
//        if(!empty($email)) {
//            $prop_value_array["email"] = $email;
//        }
//        $cell_iterator->next();
//        // role
//        $role = (string)$cell_iterator->current()->getValue();
//        if(!empty($role)) {
//            $prop_value_array["role"] = $role;
//        }
//        return static::create($prop_value_array);
//    }
}