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

namespace pebs;

use \ElggObject;

class PebsItem{

    /**
     * @const string Elgg entity TYPE for this item
     */
    const TYPE = "object";
    /**
     * @const string Elgg entity SUBTYPE for this item
     */
    const SUBTYPE = "";

    public $id = -1;
    public $name = "";
    public $description = "";

    /**
     * Constructor
     *
     * @param int|null $id If $id is null, create new instance; else load instance with id = $id.
     */
    function __construct($id = null){
        if($id){
            $this->load($id);
        }
    }

    /**
     * Loads an instance from the system.
     *
     * @param int $id Id of the instance to load from the system.
     * @return $this|bool Returns instance, or false if error.
     */
    function load($id){
        if(!($elgg_object = new ElggObject((int)$id))){
            return null;
        }
        if($elgg_object->type != $this::TYPE
           || get_subtype_from_id($elgg_object->subtype) != $this::SUBTYPE
        ){
            return null;
        }
        $this->id = (int)$elgg_object->guid;
        $this->description = (string)$elgg_object->description;
        $this->name = (string)$elgg_object->name;
        return $this;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)$this::SUBTYPE;
        } else{
            $elgg_object = new ElggObject((int)$this->id);
        }
        if(!$elgg_object){
            return false;
        }
        $elgg_object->description = (string)$this->description;
        $elgg_object->name = (string)$this->name;
        return $this->id = $elgg_object->save();
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
     * Lists the properties contained in this object
     *
     * @return array Array of properties whith type and default value
     */
    static function listProperties(){
        return get_class_vars(get_called_class());
    }

    function getProperties($prop_array){
        $value_array = array();
        foreach($prop_array as $prop){
            $value_array[$prop] = $this->$prop;
        }
        return $value_array;
    }

    function setProperties($prop_value_array){
        foreach($prop_value_array as $prop => $value){
            $this->$prop = $value;
        }
        return $this->save();
    }

    /**
     * Get all Objects of this TYPE/SUBTYPE from the system.
     *
     * @param int $limit Number of results to show, default= 0 [no limit] (optional)
     * @return array Returns an array of Objects
     */
    static function getAll($limit = 0){
        $called_class = get_called_class();
        $elgg_object_array = elgg_get_entities(array('type' => $called_class::TYPE,
                                                     'subtype' => $called_class::SUBTYPE,
                                                     'limit' => $limit));
        if(!$elgg_object_array){
            return null;
        }
        $object_array = array();
        foreach($elgg_object_array as $elgg_object){
            $object_array[] = new $called_class((int)$elgg_object->guid);
        }
        return $object_array;
    }

    /**
     * Get Objects with id contained in a given list.
     *
     * @param array $id_array Array of Object Ids
     * @return array Returns an array of Objects
     */
    static function getById($id_array){
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
}