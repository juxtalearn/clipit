<?php
/**
 * URJC Backend
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
 * Class UBItem
 *
 * @package urjc_backend
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
    public $id = -1;
    /**
     * @var string Name of this instance
     */
    public $name = "";
    /**
     * @var string Description of this instance
     */
    public $description = "";
    /**
     * @var int Unique Id of the owner/creator of this instance
     */
    public $owner_id = -1;
    /**
     * @var int Timestamp when this Item was created
     */
    public $time_created = -1;

    /* Instance Functions */
    /**
     * Constructor
     *
     * @param int $id If $id is null, create new instance; else load instance with id = $id.
     *
     * @throws APIException
     */
    function __construct($id = -1){
        if($id != -1){
            $called_class = get_called_class();
            if(!($elgg_object = new ElggObject($id))){
                throw new APIException("ERROR 1: Id '" . $id . "' does not correspond to a " . $called_class . " object.");
            }
            $elgg_type = $elgg_object->type;
            $elgg_subtype = $elgg_object->getSubtype();
            if(($elgg_type != $called_class::TYPE) || ($elgg_subtype != $called_class::SUBTYPE)){
                throw new APIException("ERROR 2: Id '" . $id . "' does not correspond to a " . $called_class . " object.");
            }
            $this->_load($elgg_object);
        }
    }

    protected function _load($elgg_object){
        $this->id = (int)$elgg_object->guid;
        $this->description = (string)$elgg_object->description;
        $this->name = (string)$elgg_object->name;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = (int)$elgg_object->guid;
    }

    /**
     * Deletes an instance from the system.
     *
     * @return bool True if success, false if error.
     */
    function delete(){
        if(!$elgg_entity = get_Entity((int)$this->id)){
            return false;
        }
        return $elgg_entity->delete();
    }

    /**
     * Gets the values for the properties specified in prop_array.
     *
     * @param array $prop_array Array of properties to get values from
     *
     * @return array Array of prop=>value items
     */
    function getProperties($prop_array){
        $value_array = array();
        foreach($prop_array as $prop){
            $value_array[$prop] = $this->$prop;
        }
        return $value_array;
    }

    /**
     * Sets values into specified properties of the instance
     *
     * @param array $prop_value_array Array of prop=>value pairs to set into the instance
     *
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
            $this->$prop = $value;
        }
        return $this->save();
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
        $called_class = get_called_class();
        if(!$item = new $called_class($id)){
            return null;
        }
        return $item->getProperties($prop_array);
    }

    /**
     * Sets values to specified properties of an Item
     *
     * @param int   $id Id of Item to set property valyes
     * @param array $prop_value_array Array of property=>value pairs to set into the Item
     *
     * @return int|bool Returns Id of Item if correct, or false if error
     */
    static function set_properties($id, $prop_value_array){
        if(!is_integer($id)){
            return false;
        }
        $called_class = get_called_class();
        if(!$item = new $called_class($id)){
            return false;
        }
        $item->setProperties($prop_value_array);
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
        $called_class = get_called_class();
        $item = new $called_class();
        return $item->setProperties($prop_value_array);
    }

    /**
     * Delete Items given their Id.
     *
     * @param array $id_array List of Item Ids to delete
     *
     * @return bool Returns true if correct, or false if error
     */
    static function delete_by_id($id_array){
        $called_class = get_called_class();
        foreach($id_array as $id){
            if(!$item = new $called_class($id)){
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
        $called_class = get_called_class();
        $elgg_object_array = elgg_get_entities(
            array(
                'type' => $called_class::TYPE,
                'subtype' => $called_class::SUBTYPE,
                'limit' => $limit));
        if(!$elgg_object_array){
            return array();
        }
        foreach($elgg_object_array as $elgg_object){
            $object_array[] = new $called_class((int)$elgg_object->guid);
        }
        if(!isset($object_array)){
            return array();
        }
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
        $called_class = get_called_class();
        $object_array = array();
        foreach($id_array as $id){
            if(elgg_entity_exists($id)){
                $object_array[] = new $called_class((int)$id);
            } else{
                $object_array[] = null;
            }
        }
        return $object_array;
    }

    static function get_events($limit = 10){
        $called_class = get_called_class();
        return get_system_log(
            null, // $by_user = ""
            null, // $event = ""
            null, // $class = ""
            $called_class::TYPE, // $type = ""
            $called_class::SUBTYPE, // $subtype = ""
            $limit, // $limit = 10
            null, // $offset = 0
            null, // $count = false
            null, // $timebefore = 0
            null, // $timeafter = 0
            null, // $object_id = 0
            null); // $ip_address = ""
    }

    static function get_from_owner($owner_id, $limit = 10){
        $called_class = get_called_class();
        $elgg_object_array = elgg_get_entities(
            array(
                'owner_guid' => $owner_id,
                'type' => $called_class::TYPE,
                'subtype' => $called_class::SUBTYPE,
                'limit' => $limit));
        if(empty($elgg_object_array)){
            return array();
        }
        $object_array = array();
        foreach($elgg_object_array as $elgg_object){
            $object_array[] = new $called_class((int)$elgg_object->guid);
        }
        return $object_array;
    }
}