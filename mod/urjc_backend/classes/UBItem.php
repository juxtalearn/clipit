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
 * Class UBItem
 */
class UBItem{
    /**
     * @const string Elgg entity TYPE for this class
     */
    const TYPE = "object";
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "item";
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

    /* Instance Functions */
    /**
     * Constructor
     *
     * @param int $id If $id is null, create new instance; else load instance with id = $id.
     *
     * @throws APIException
     */
    function __construct($id = null){
        if(!empty($id)){
            if(!($elgg_object = new ElggObject($id))){
                throw new APIException("ERROR: Id '" . $id . "' does not correspond to a " . get_called_class() . " object.");
            }
            $elgg_type = $elgg_object->type;
            $elgg_subtype = $elgg_object->getSubtype();
            if(($elgg_type != static::TYPE) || ($elgg_subtype != static::SUBTYPE)){
                throw new APIException("ERROR: Id '" . $id . "' does not correspond to a " . get_called_class() . " object.");
            }
            $this->load_from_elgg($elgg_object);
        }
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        if(!empty($this->id)){
            if(!$elgg_object = new ElggObject($this->id)){
                return false;
            }
        } else{
            $elgg_object = new ElggObject();
            $elgg_object->type = static::TYPE;
            $elgg_object->subtype = static::SUBTYPE;
        }
        $this->copy_to_elgg($elgg_object);
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    /**
     * @param ElggObject $elgg_object Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        $this->id = (int)$elgg_entity->get("guid");
        $this->name = (string)$elgg_entity->get("name");
        $this->description = (string)$elgg_entity->get("description");
        $this->url = (string)$elgg_entity->get("url");
        $this->owner_id = (int)$elgg_entity->getOwnerGUID();
        $this->time_created = (int)$elgg_entity->getTimeCreated();
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_entity){
        $elgg_entity->set("name", (string)$this->name);
        $elgg_entity->set("description", (string)$this->description);
        $elgg_entity->set("url", (string)$this->url);
        $elgg_entity->set("access_id", ACCESS_PUBLIC);
    }

    /**
     * Deletes an instance from the system.
     *
     * @return bool True if success, false if error.
     */
    protected function delete(){
        if(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        return $elgg_object->delete();
    }

    /* Static Functions */

    /**
     * Lists the properties contained in this object
     *
     * @return array Array of properties with type and default value
     */
    static function list_properties(){
        return get_class_vars(get_called_class());
    }

    /**
     * Get specified property values for an Item
     *
     * @param int   $id Id of instance to get properties from
     * @param array $prop_array Array of property names to get values from
     *
     * @return array|bool Returns an array of property=>value pairs, or false if error
     */
    static function get_properties($id, $prop_array){
        if(!$item = new static($id)){
            return null;
        }
        $value_array = array();
        foreach($prop_array as $prop){
            $value_array[$prop] = $item->$prop;
        }
        return $value_array;
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
            if(!array_key_exists($prop, self::list_properties())){
                if($prop !== "hash"){
                    throw new InvalidParameterException("ERROR: One or more property names do not exist.");
                }
            }
            if($prop == "id"){
                throw new InvalidParameterException("ERROR: Cannot modify 'id' of instance.");
            }
            $item->$prop = $value;
        }
        return $item->save();
    }

    /**
     * Create a new instance of this class, and assign values to its properties.
     *
     * @param array $prop_value_array Array of [property]=>value pairs to set into the new instance
     *
     * @return int|bool Returns instance Id if correct, or false if error
     */
    static function create($prop_value_array){
        return static::set_properties(null, $prop_value_array);
    }

    /**
     * Delete Items given their Id.
     *
     * @param array $id_array List of Item Ids to delete
     *
     * @return bool Returns true if correct, or false if error
     */
    static function delete_by_id($id_array){
        foreach($id_array as $id){
            if(!$item = new static((int)$id)){
                return false;
            }
            if(!$item->delete()){
                return false;
            }
        }
        return true;
    }

    /**
     * Get all Objects of this TYPE/SUBTYPE from the system.
     *
     * @param int $limit Number of results to show, default= 0 [no limit] (optional)
     *
     * @return UBItem[] Returns an array of Objects
     */
    static function get_all($limit = 0){
        $object_array = array();
        $elgg_object_array = elgg_get_entities(
            array(
                'type' => static::TYPE,
                'subtype' => static::SUBTYPE,
                'limit' => $limit));
        if($elgg_object_array){
            foreach($elgg_object_array as $elgg_object){
                $object_array[(int)$elgg_object->guid] = new static((int)$elgg_object->guid);
            }
        }
        usort($object_array, 'UBItem::sort_by_date_inv');
        return $object_array;
    }

    /**
     * Get Objects with id contained in a given list.
     *
     * @param array $id_array Array of Object Ids
     *
     * @return UBItem[] Returns an array of Objects
     */
    static function get_by_id($id_array){
        $object_array = array();
        foreach($id_array as $id){
            if(elgg_entity_exists($id)){
                $object_array[(int)$id] = new static((int)$id);
            } else{
                $object_array[(int)$id] = null;
            }
        }
        return $object_array;
    }

    static function get_by_owner($owner_array, $limit = 10){
        $object_array = array();
        foreach($owner_array as $owner_id){
            $elgg_object_array = elgg_get_entities(
                array(
                    "type" => static::TYPE,
                    "subtype" => static::SUBTYPE,
                    "owner_guid" => (int)$owner_id,
                    "limit" => $limit
                )
            );
            $temp_array = array();
            foreach($elgg_object_array as $elgg_object){
                $temp_array[(int)$elgg_object->guid] = new static((int)$elgg_object->guid);
            }
            if(!empty($temp_array)){
                $object_array[(int)$owner_id] = $temp_array;
                usort($object_array[(int)$owner_id], 'UBItem::sort_by_date');
            } else{
                $object_array[(int)$owner_id] = null;
            }
        }
        return $object_array;
    }

    static function get_events($limit = 10){
        return get_system_log(
            null, // $by_user = ""
            null, // $event = ""
            null, // $class = ""
            static::TYPE, // $type = ""
            static::SUBTYPE, // $subtype = ""
            $limit, // $limit = 10
            null, // $offset = 0
            null, // $count = false
            null, // $timebefore = 0
            null, // $timeafter = 0
            null, // $object_id = 0
            null); // $ip_address = ""
    }

    static function get_from_search($search_string, $name_only = false){
        $elgg_object_array = elgg_get_entities(
            array(
                'type' => static::TYPE,
                'subtype' => static::SUBTYPE)
        );
        $search_result = array();
        foreach($elgg_object_array as $elgg_object){
            $search_string = strtolower($search_string);
            if(strpos(strtolower($elgg_object->name), $search_string) !== false){
                $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid);
                continue;
            }
            if($name_only === false){
                if(strpos(strtolower($elgg_object->description), $search_string) !== false){
                    $search_result[(int)$elgg_object->guid] = new static((int)$elgg_object->guid);
                }
            }
        }
        return $search_result;
    }

    /**
     * Sort by Date, oldest to newest.
     *
     * @param UBItem $i1
     * @param UBItem $i2
     * @return int Returns 0 if equal, -1 if i1 < i2, 1 if i1 > i2.
     */
    static function sort_by_date($i1, $i2){
        if((int)$i1->time_created == (int)$i2->time_created){
           return 0;
        }
        return ((int)$i1->time_created < (int)$i2->time_created) ? -1 : 1;
    }

    /**
     * Sort by Date Inverse order, newest to oldest.
     *
     * @param UBItem $i1
     * @param UBItem $i2
     * @return int Returns 0 if equal, -1 if i1 < i2, 1 if i1 > i2.
     */
    static function sort_by_date_inv($i1, $i2){
        if((int)$i1->time_created == (int)$i2->time_created){
            return 0;
        }
        return ((int)$i1->time_created > (int)$i2->time_created) ? -1 : 1;
    }

    /**
 * @param UBItem $i1
 * @param UBItem $i2
 * @return int Returns 0 if equal, -1 if i1 < i2, 1 if i1 > i2.
 */
    static function sort_by_name($i1, $i2){
        return strcmp($i1->name, $i2->name);
    }

    /**
     * @param UBItem $i1
     * @param UBItem $i2
     * @return int Returns 0 if equal, -1 if i1 < i2, 1 if i1 > i2.
     */
    static function sort_by_name_inv($i1, $i2){
        return strcmp($i2->name, $i1->name);
    }

    static function sort_numbers($n1, $n2){
        if((int)$n1 == (int)$n2){
            return 0;
        }
        return ((int)$n1 < (int)$n2) ? -1 : 1;
    }

    static function sort_numbers_inv($n1, $n2){
        if((int)$n1 == (int)$n2){
            return 0;
        }
        return ((int)$n1 > (int)$n2) ? -1 : 1;
    }
}