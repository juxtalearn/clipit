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
 * Class UBFile
 *
 * @package urjc_backend
 */
class UBFile extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "file";
    /**
     * @const string Delimiter for timestamp string
     */
    const TIMESTAMP_DELIMITER = "#";
    /**
     * @var string File data in byte string format
     */
    public $data = null;

    /* Instance Functions */
    /**
     * Constructor
     *
     * @param int $id If $id is null, create new instance; else load instance with id = $id.
     *
     * @throws APIException
     */
    function __construct($id = null){
        if($id){
            if(!($elgg_file = new ElggFile((int)$id))){
                $called_class = get_called_class();
                throw new APIException("ERROR 1: Id '" . $id . "' does not correspond to a " . $called_class . " object.");
            }
            $this->_load($elgg_file);
        }
    }

    /**
     * @param ElggFile $elgg_file
     */
    protected function _load($elgg_file){
        $this->id = (int)$elgg_file->guid;
        $this->type = (string)$elgg_file->type;
        $this->subtype = $elgg_file->getSubtype();
        $temp_name = explode(static::TIMESTAMP_DELIMITER, (string)$elgg_file->getFilename());
        if(empty($temp_name[1])){
            // no timestamp found
            $this->name = $temp_name[0];
        } else{
            $this->name = $temp_name[1];
        }
        $this->description = (string)$elgg_file->description;
        $this->owner_id = (int)$elgg_file->owner_guid;
        $this->time_created = (int)$elgg_file->time_created;
        $this->data = $elgg_file->grabFile();
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    function save(){
        if($this->id == -1){
            $elgg_file = new ElggFile();
            $elgg_file->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_file = new ElggFile((int)$this->id)){
            return false;
        }
        $date_obj = new DateTime();
        $elgg_file->setFilename((string)$date_obj->getTimestamp() . static::TIMESTAMP_DELIMITER . (string)$this->name);
        $elgg_file->description = (string)$this->description;
        $elgg_file->open("write");
        $elgg_file->write($this->data);
        $elgg_file->close();
        $elgg_file->access_id = ACCESS_PUBLIC;
        $elgg_file->save();
        $this->owner_id = (int)$elgg_file->owner_guid;
        $this->time_created = (int)$elgg_file->time_created;
        return $this->id = (int)$elgg_file->guid;
    }
}