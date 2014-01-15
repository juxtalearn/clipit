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
 * Class UBCollection
 *
 * @package urjc_backend
 */
abstract class UBCollection extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "collection";
    /**
     * @var array Array of item Ids contained in this Collection
     */
    public $id_array = array();

    /**
     * Loads an instance from the system.
     *
     * @param int $id Id of the instance to load from the system.
     * @return UBItem|bool Returns instance, or false if error.
     */
    protected function _load($id){
        if(!($elgg_object = new ElggObject((int)$id))){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int)$elgg_object->guid;
        $this->description = (string)$elgg_object->description;
        $this->name = (string)$elgg_object->name;
        $this->id_array = (array)$elgg_object->id_array;
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
        } elseif(!$elgg_object = new ElggObject((int)$this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->id_array = (array)$this->id_array;
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    function addItems($id_array){
        if(!$this->id_array){
            $this->id_array = $id_array;
        } else{
            $this->id_array = array_merge($this->id_array, $id_array);
        }
        if(!$this->save()){
            return false;
        }
        return true;
    }

    function removeItems($id_array){
        if(!$this->id_array){
            return false;
        }
        foreach($id_array as $item){
            $key = array_search($item, $this->id_array);
            if(isset($key)){
                unset($this->id_array[$key]);
            } else{
                return false;
            }
        }
        if(!$this->save()){
            return false;
        }
        return true;
    }

    function getItems($item_class){
        $item_array = array();
        foreach($this->id_array as $id){
            if(!$item = new $item_class($id)){
                $item_array[] = null;
            } else{
                $item_array[] = $item;
            }
        }
        return $item_array;
    }


    /**
     * Adds Items to a Collection.
     *
     * @param int $id Id from Collection to add Items to
     * @param array $id_array Array of Items to add
     * @return bool Returns true if success, false if error
     */
    static function add_items($id, $id_array){
        $called_class = get_called_class();
        if(!$collection = new $called_class($id)){
            return false;
        }
        return $collection->addItems($id_array);
    }

    /**
     * Remove Items from a Collection.
     *
     * @param int $id Id from Collection to remove Items from
     * @param array $id_array Array of Items to remove
     * @return bool Returns true if success, false if error
     */
    static function remove_items($id, $id_array){
        $called_class = get_called_class();
        if(!$collection = new $called_class($id)){
            return false;
        }
        return $collection->removeItems($id_array);
    }

    /**
     * Get an array of Items included in a Collection.
     *
     * @param int $id The Id of the Collection to get Items
     * @param string $item_class Name of the class from the items to get
     * @return array|bool Returns an array of Items, or false if error
     */
    static function get_items($id, $item_class){
        $called_class = get_called_class();
        if(!$collection = new $called_class($id)){
            return false;
        }
        return $collection->getItems($item_class);
    }

}