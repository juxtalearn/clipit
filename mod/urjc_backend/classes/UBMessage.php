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
class UBMessage extends UBItem{

    const SUBTYPE = "message";

    const REL_MESSAGE_DESTINATION = "message-destination";
    const REL_MESSAGE_FILE = "message-file";

    public $read = false;
    public $read_by_user = array();
    public $destination = -1;
    public $file_array = array();


    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->read = (bool)$elgg_object->read;
        $this->read_by_user = (array)$elgg_object->read_by_user;
        $this->destination = static::get_destination($this->id);
        $this->file_array = static::get_files($this->id);
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
        $elgg_object->read = (bool)$this->read;
        $elgg_object->read_by_user = (array)$this->read_by_user;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->id = (int)$elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    function delete(){
        if($rel_array = get_entity_relationships($this->id, true)){
            foreach($rel_array as $rel){
                switch($rel->relationship){
                    case ClipitMessage::REL_MESSAGE_DESTINATION:
                        $reply_array[] = $rel->guid_one;
                        break;
                }
            }
            if(isset($reply_array)){
                ClipitMessage::delete_by_id($reply_array);
            }
        }
        return parent::delete();
    }

    /* STATIC FUNCTIONS */

    static function get_destination($id){
        $item_array = UBCollection::get_items($id, static::REL_MESSAGE_DESTINATION);
        if(empty($item_array)){
            return -1;
        }
        return array_pop($item_array);
    }

    static function set_destination($id, $destination_id){
        if($destination_id != -1){
            UBCollection::remove_all_items($id, static::REL_MESSAGE_DESTINATION);
            return UBCollection::add_items($id, array($destination_id), static::REL_MESSAGE_DESTINATION);
        }
    }

    static function get_files($id){
        return UBCollection::get_items($id, static::REL_MESSAGE_FILE);
    }

    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }

    static function get_replies($id){
        $temp_array = get_entity_relationships($id, true);
        $reply_array = array();
        foreach($temp_array as $rel){
            if($rel->relationship == static::REL_MESSAGE_DESTINATION){
                $reply_array[] = $rel->guid_one;
            }
        }
        return $reply_array;
    }

    static function get_by_sender($sender_array){
        $called_class = get_called_class();
        $object_array = array();
        foreach($sender_array as $sender_id){
            $elgg_object_array = elgg_get_entities(
                array(
                    "type" => $called_class::TYPE,
                    "subtype" => $called_class::SUBTYPE,
                    "owner_guid" => (int)$sender_id
                )
            );
            $temp_array = array();
            foreach($elgg_object_array as $elgg_object){
                $temp_array[] = new $called_class((int)$elgg_object->guid);
            }
            if(!empty($temp_array)){
                $object_array[] = $temp_array;
            } else{
                $object_array[] = null;
            }
        }
        return $object_array;
    }

    static function get_by_destination($destination_array){
        $called_class = get_called_class();
        $object_array = array();
        foreach($destination_array as $destination_id){
            $rel_array = get_entity_relationships($destination_id, true);
            $temp_array = array();
            foreach($rel_array as $rel){
                if($rel->relationship == static::REL_MESSAGE_DESTINATION){
                    $temp_array[] = new $called_class((int)$rel->guid_one);
                }
            }
            if(empty($temp_array)){
                $object_array[] = null;
            } else{
                $object_array[] = $temp_array;
            }
        }
        return $object_array;
    }

    static function get_read_status($id, $user_array = null){
        $called_class = get_called_class();
        if(!$user_array){
            $prop_array[] = "read";
            return $called_class::get_properties($id, $prop_array);
        }
        $prop_array[] = "read_by_user";
        $read_by_user = $called_class::get_properties($id, $prop_array);
        $return_array = array();
        foreach($user_array as $user_id){
            if(array_search($user_id, $read_by_user)){
                $return_array[$user_id] = true;
            } else{
                $return_array[$user_id] = false;
            }
        }
        return $return_array;
    }

    static function set_read_status($id, $read, $user_array = null){
        $called_class = get_called_class();
        if(!$user_array){
            $prop_value_array["read"] = (bool)$read;
            return $called_class::set_properties($id, $prop_value_array);
        }
        $prop_array[] = "read_by_user";
        $read_by_user = $called_class::get_properties($id, $prop_array);
        foreach($user_array as $user_id){
            if($read == true){
                if(!array_search($user_id, $read_by_user)){
                    array_push($read_by_user, $user_id);
                }
            } else if($read == false){
                if($index = array_search($user_id, $read_by_user)){
                    array_splice($read_by_user, $index, 1);
                }
            }
        }
        $prop_value_array["read_by_user"] = $read_by_user;
        return $called_class::set_properties($id, $prop_value_array);
    }

}