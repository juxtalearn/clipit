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


class UBMessage extends UBItem{

    const SUBTYPE = "message";

    const REL_MESSAGE_DESTINATION = "message-destination";
    const REL_MESSAGE_FILE = "message-file";

    public $read_array = array();
    public $destination = 0;
    public $file_array = array();

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->read_array = (array)$elgg_object->read_array;
        $this->destination = static::get_destination($this->id);
        $this->file_array = static::get_files($this->id);
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->read_array = (array)$this->read_array;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save(){
        parent::save();
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    protected function delete(){
        if($rel_array = get_entity_relationships($this->id, true)){
            foreach($rel_array as $rel){
                switch($rel->relationship){
                    case static::REL_MESSAGE_DESTINATION:
                        $reply_array[] = $rel->guid_one;
                        break;
                }
            }
            if(isset($reply_array)){
                static::delete_by_id($reply_array);
            }
        }
        return parent::delete();
    }

    /* STATIC FUNCTIONS */
    static function get_by_destination($destination_array){
        $message_array = array();
        foreach($destination_array as $destination_id){
            $item_array = UBCollection::get_items($destination_id, static::REL_MESSAGE_DESTINATION, true);
            $temp_array = array();
            foreach($item_array as $item_id){
                $temp_array[$item_id] = new static((int)$item_id);
            }
            if(empty($temp_array)){
                $message_array[$destination_id] = null;
            } else{
                $message_array[$destination_id] = $temp_array;
                usort($message_array[$destination_id], 'UBItem::sort_by_date');
            }
        }
        return $message_array;
    }
    static function get_by_sender($sender_array){
        return static::get_by_owner($sender_array);
    }
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
        return -1;
    }
    static function get_sender($id){
        $message = new static($id);
        return $message->owner_id;
    }
    static function get_files($id){
        return UBCollection::get_items($id, static::REL_MESSAGE_FILE);
    }
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }
    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, static::REL_MESSAGE_FILE);
    }
    static function get_read_status($id, $user_array = null){
        $props = static::get_properties($id, array("read_array", "owner_id"));
        $read_array = $props["read_array"];
        $owner_id = $props["owner_id"];
        if(!$user_array){
            return $read_array;
        } else{
            $return_array = array();
            foreach($user_array as $user_id){
                if((int)$user_id == (int)$owner_id || in_array($user_id, $read_array)){
                    $return_array[$user_id] = true;
                } else{
                    $return_array[$user_id] = false;
                }
            }
            return $return_array;
        }
    }
    static function set_read_status($id, $read_value, $user_array){
        $read_array = static::get_properties($id, array("read_array"));
        $read_array = array_pop($read_array);
        foreach($user_array as $user_id){
            if($read_value == true){
                if(!in_array($user_id, $read_array)){
                    array_push($read_array, $user_id);
                }
            } else if($read_value == false){
                $index = array_search((int) $user_id, $read_array);
                if(isset($index) && $index !== false){
                    array_splice($read_array, $index, 1);
                }
            }
        }
        $prop_value_array["read_array"] = $read_array;
        return static::set_properties($id, $prop_value_array);
    }
    static function count_by_destination($destination_array, $recursive = false){
        $count_array = array();
        foreach($destination_array as $dest_id){
            $count_array[$dest_id] = UBCollection::count_items($dest_id, static::REL_MESSAGE_DESTINATION, true, $recursive);
        }
        return $count_array;
    }
    static function count_by_sender($sender_array){
        $message_array = static::get_by_sender($sender_array);
        $count_array = array();
        foreach($sender_array as $sender_id){
            $count_array[$sender_id] = count($message_array[$sender_id]);
        }
        return $count_array;
    }

    static function unread_by_destination($destination_array, $user_id, $recursive = false){
        $destination_messages = static::get_by_destination($destination_array);
        $count_array = array();
        foreach($destination_array as $destination_id){
            $message_array = $destination_messages[$destination_id];
            if(!$message_array){
                $count_array[$destination_id] = 0;
                continue;
            }
            $count = 0;
            foreach($message_array as $message){
                if(array_search((int)$user_id, $message->read_array) === false){
                    $count++;
                }
                if($recursive){
                    $temp_count = static::unread_by_destination(array((int)$message->id), $user_id, $recursive);
                    $count += $temp_count[$message->id];
                }
            }
            $count_array[$destination_id] = $count;
        }
        return $count_array;
    }

    static function unread_by_sender($sender_array, $user_id){
        $sender_messages = static::get_by_sender($sender_array);
        $count_array = array();
        foreach($sender_array as $sender_id){
            $count = 0;
            if(!empty($sender_messages[$sender_id])){
                $message_array = $sender_messages[$sender_id];
                foreach($message_array as $message){
                    if(array_search((int)$user_id, $message->read_array) === false){
                        $count++;
                    }
                }
            }
            $count_array[$sender_id] = $count;
        }
        return $count_array;
    }
}