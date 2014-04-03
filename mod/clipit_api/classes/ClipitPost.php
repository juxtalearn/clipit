<?php

class ClipitPost extends UBMessage{
    const SUBTYPE = "clipit_post";

    const REL_MESSAGE_PARENT = "message-parent";

    public $parent = -1;

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->parent = static::get_parent($this->id);
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
        $elgg_object->read_array = (array)$this->read_array;
        $elgg_object->archived_array = (array)$this->archived_array;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->id = (int)$elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::set_destination($this->id, $this->destination);
        static::set_parent($this->id, $this->parent);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    static function get_parent($id){
        $item_array = UBCollection::get_items($id, static::REL_MESSAGE_PARENT);
        if(empty($item_array)){
            return -1;
        }
        return array_pop($item_array);
    }

    static function set_parent($id, $parent_id){
        if($parent_id != -1){
            UBCollection::remove_all_items($id, static::REL_MESSAGE_PARENT);
            return UBCollection::add_items($id, array($parent_id), static::REL_MESSAGE_PARENT);
        }
        return -1;
    }


    static function get_by_destination($destination_array, $recursive = false){
        $called_class = get_called_class();
        $message_array = array();
        foreach($destination_array as $destination_id){
            $item_array = UBCollection::get_items($destination_id, static::REL_MESSAGE_DESTINATION, true); // top level messages assert (parent == destination)
            $temp_array = array();
            foreach($item_array as $item_id){
                $message = new $called_class((int)$item_id);
                if($recursive){
                    $children = static::get_by_parent(array((int)$item_id), true);
                    $temp_array[$item_id] = array_merge(array_pop($children), array($message));
                } else{
                    $temp_array[$item_id] = $message;
                }
            }
            if(empty($temp_array)){
                $message_array[$destination_id] = null;
            } else{
                $message_array[$destination_id] = $temp_array;
            }
        }
        return $message_array;
    }

    static function get_by_parent($parent_array, $recursive = false){
        $called_class = get_called_class();
        $message_array = array();
        foreach($parent_array as $parent_id){
            $item_array = UBCollection::get_items($parent_id, static::REL_MESSAGE_PARENT, true);
            $temp_array = array();
            foreach($item_array as $item_id){
                $message = new $called_class((int)$item_id);
                if($recursive){
                    $children = static::get_by_parent(array($message->id), true);
                    $temp_array[] = array_merge(array_pop($children), array($message));
                } else{
                    $temp_array[] = $message;
                }
            }
            if(empty($temp_array)){
                $message_array[] = null;
            } else{
                $message_array[] = $temp_array;
            }
        }
        return $message_array;
    }

} 