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
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "UBMessage";

    const REL_MESSAGE_DESTINATION = "message-destination";
    const REL_MESSAGE_FILE = "message-file";

    public $read_array = array();
    public $destination = 0;
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->read_array = (array)$elgg_entity->get("read_array");
        $this->destination = (int)static::get_destination($this->id);
        $this->file_array = (array)static::get_files($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_entity){
        parent::save_to_elgg($elgg_entity);
        $elgg_entity->set("read_array", (array)$this->read_array);
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

    /**
     * Deletes $this instance from the system.
     *
     * @return bool True if success, false if error.
     */
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
    /**
     * Get Messages by Destination
     * @param array $destination_array Array of Destination IDs
     * @return static[] Array of Messages
     */
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

    /**
     * Get Messages by Sender
     * @param array $sender_array Array of Sender IDs
     * @return static[] Array of Messages
     */
    static function get_by_sender($sender_array){
        return static::get_by_owner($sender_array);
    }

    /**
     * Get the Destination of a Message
     * @param int $id ID of Message
     * @return int|null ID of Destination or null if error
     */
    static function get_destination($id){
        $item_array = UBCollection::get_items($id, static::REL_MESSAGE_DESTINATION);
        if(empty($item_array)){
            return 0;
        }
        return (int)array_pop($item_array);
    }

    /**
     * Set the Destination of a Message
     * @param int $id Id of the Message
     * @param int $destination_id ID of the Destination
     * @return bool True if OK, false if error
     */
    static function set_destination($id, $destination_id){
        if($destination_id > 0){
            UBCollection::remove_all_items($id, static::REL_MESSAGE_DESTINATION);
            return UBCollection::add_items($id, array($destination_id), static::REL_MESSAGE_DESTINATION);
        }
        return false;
    }

    /**
     * Get Sender of a Message
     * @param int $id ID of the Message
     * @return int ID of the Sender
     */
    static function get_sender($id){
        $message = new static($id);
        return $message->owner_id;
    }

    /**
     * Add Files attached to a Message
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     * @return bool True if OK, false if error
     */
    static function add_files($id, $file_array){
        return UBCollection::add_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }

    /**
     * Set Files attached to a Message
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     * @return bool True if OK, false if error
     */
    static function set_files($id, $file_array){
        return UBCollection::set_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }

    /**
     * Remove Files attached to a Message
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     * @return bool True if OK, false if error
     */
    static function remove_files($id, $file_array){
        return UBCollection::remove_items($id, $file_array, static::REL_MESSAGE_FILE);
    }

    /**
     * Get Files attached to a Message
     * @param int $id ID of the Message
     * @return static[] Array of File IDs
     */
    static function get_files($id){
        return UBCollection::get_items($id, static::REL_MESSAGE_FILE);
    }

    /**
     * Get a list of Users who have Read a Message, or optionally whether certain Users have read it
     * @param int $id ID of the Message
     * @param null|array $user_array List of User IDs - optional
     * @return static[] Array with key => value: user_id => read_status, where read_status is bool
     */
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

    /**
     * Set the Read status for a Message
     * @param int $id ID of Message
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     * @return bool|int ID of Message if Ok, false if error
     * @throws InvalidParameterException
     */
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

    /**
     * Count the number os Messages for each Destination specified
     * @param array$destination_array List of Destination IDs
     * @param bool $recursive Whether to recurse
     * @return array Returns array of destination => message_count elements.
     */
    static function count_by_destination($destination_array, $recursive = false){
        $count_array = array();
        foreach($destination_array as $dest_id){
            $count_array[$dest_id] = UBCollection::count_items($dest_id, static::REL_MESSAGE_DESTINATION, true, $recursive);
        }
        return $count_array;
    }

    /**
     * Count number of Messages sent by Sender
     * @param array $sender_array Array of User IDs
     * @return array Array of sender => message_count elements
     */
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