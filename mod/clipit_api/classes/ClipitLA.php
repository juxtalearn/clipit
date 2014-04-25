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
 * @subpackage      clipit_api
 */

class ClipitLA extends UBFile{

    const SUBTYPE = "clipit_la";

    public $return_id = -1;
    public $status_code = -1;

    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->return_id = (int)$elgg_object->return_id;
        $this->status_code = (int)$elgg_object->status_code;
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_file = new ElggFile();
            $elgg_file->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_file = new ElggFile((int)$this->id)){
            return false;
        }
        $date_obj = new DateTime();
        if(empty($this->name)){
            $this->name = static::DEFAULT_FILENAME;
        }
        $elgg_file->setFilename((string)$date_obj->getTimestamp() . static::TIMESTAMP_DELIMITER . static::DEFAULT_FILENAME);
        $elgg_file->description = (string)$this->description;
        $elgg_file->open("write");
        if($decoded_data = base64_decode($this->data, true)){
            $elgg_file->write($decoded_data);
        } else{
            $elgg_file->write($this->data);
        }
        $elgg_file->close();
        $elgg_file->access_id = ACCESS_PUBLIC;
        $elgg_file->return_id = $this->return_id;
        $elgg_file->status_code = $this->status_code;
        $elgg_file->save();
        $this->owner_id = (int)$elgg_file->owner_guid;
        $this->time_created = (int)$elgg_file->time_created;
        return $this->id = (int)$elgg_file->guid;
    }

    static function send_metrics($returnId, $data, $statuscode){
        $la = new ClipitLA();
        $prop_value_array["return_id"] = (int)$returnId;
        $prop_value_array["data"] = $data;
        $prop_value_array["status_code"] = (int)$statuscode;
        $la->setProperties($prop_value_array);
        return $la->save();
    }
}