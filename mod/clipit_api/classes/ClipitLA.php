<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 11/03/2014
 * Time: 10:23
 */

class ClipitLA extends UBItem{

    public $return_id;
    public $data;
    public $status_code;

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->return_id = (int)$elgg_object->return_id;
        $this->data = (string)$elgg_object->data;
        $this->status_code = (int)$elgg_object->status_code;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
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
        $elgg_object->return_id = (int)$this->return_id;
        $elgg_object->data = (string) $this->data;
        $elgg_object->status_code = (int) $this->status_code;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = (int)$elgg_object->guid;
    }

    static function send_metrics($returnId, $data, $statuscode){
        $la = new ClipitLA();
        $prop_value_array["return_id"] = (int)$returnId;
        $prop_value_array["data"] = (string)$data;
        $prop_value_array["status_code"] = (int)$statuscode;
        $la->setProperties($prop_value_array);
        return $la->save();
    }
}