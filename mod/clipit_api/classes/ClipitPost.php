<?php

class ClipitPost extends UBMessage{
    const SUBTYPE = "clipit_post";

    public $topic_id = -1;

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->topic_id = (int)$elgg_object->topic_id;
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
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->topic_id = $this->topic_id;
        $elgg_object->save();
        $this->id = (int)$elgg_object->guid;
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

} 