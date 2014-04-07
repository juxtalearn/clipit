<?php

class ClipitChat extends UBMessage{

    const SUBTYPE = "clipit_chat";

    public $archived_array = array();

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->archived_array = (array)$elgg_object->archived_array;
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
        $elgg_object->read_array = (array)$this->read_array;
        $elgg_object->archived_array = (array)$this->archived_array;
        $elgg_object->save();
        $this->id = (int)$elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    static function get_inbox($user_id){
        $incoming_messages = static::get_by_destination(array($user_id));
        $incoming_messages = array_pop($incoming_messages);
        $sender_array = array();
        $inbox_array = array();
        foreach($incoming_messages as $message){
            $archived_status = ClipitChat::get_archived_status($message->id, array($user_id));
            $archived_status = (bool)array_pop($archived_status);
            if($archived_status === false){
                if(!array_search($message->owner_id, $sender_array)){
                    $sender_array[] = $message->owner_id;
                    $inbox_array[$message->owner_id] = array($message);
                } else{
                    array_push($inbox_array[$message->owner_id], $message);
                }
            }
        }
        return $inbox_array;
    }

    static function get_conversation($user1_id, $user2_id){
        // user1 --> user2
        $sender_messages = static::get_by_sender(array($user1_id));
        $sender_messages = $sender_messages[$user1_id];
        $conversation = array();
        foreach($sender_messages as $message){
            if($message->destination == (int)$user2_id){
                $conversation[$message->id] = $message;
            }
        }
        // user2 --> user1
        $sender_messages = static::get_by_sender(array($user2_id));
        $sender_messages = $sender_messages[$user2_id];
        foreach($sender_messages as $message){
            if($message->destination == (int)$user1_id){
                $conversation[$message->id] = $message;
            }
        }
        return $conversation;
    }

    static function get_archived_status($id, $user_array = null){
        $prop_array[] = "archived_array";
        $archived_array = ClipitChat::get_properties($id, $prop_array);
        $archived_array = array_pop($archived_array);
        if(!$user_array){
            return $archived_array;
        } else{
            $return_array = array();
            foreach($user_array as $user_id){
                if(in_array($user_id, $archived_array)){
                    $return_array[$user_id] = true;
                } else{
                    $return_array[$user_id] = false;
                }
            }
            return $return_array;
        }
    }

    static function set_archived_status($id, $archived_value, $user_array){
        $prop_array[] = "archived_array";
        $archived_array = ClipitChat::get_properties($id, $prop_array);
        $archived_array = array_pop($archived_array);
        foreach($user_array as $user_id){
            if($archived_value == true){
                if(!in_array($user_id, $archived_array)){
                    array_push($archived_array, $user_id);
                }
            } else if($archived_value == false){
                $index = array_search((int) $user_id, $archived_array);
                if(isset($index) && $index !== false){
                    array_splice($archived_array, $index, 1);
                }
            }
        }
        $prop_value_array["archived_array"] = $archived_array;
        return ClipitChat::set_properties($id, $prop_value_array);
    }
}