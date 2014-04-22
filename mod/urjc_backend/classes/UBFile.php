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
 * @package         Clipit
 */

/**
 * Class UBFile
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
    const DEFAULT_FILENAME = "unnamed_file";
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
        if(empty($this->name)){
            $this->name = static::DEFAULT_FILENAME;
        }
        $elgg_file->setFilename((string)$date_obj->getTimestamp() . static::TIMESTAMP_DELIMITER . (string)$this->name);
        $elgg_file->description = (string)$this->description;
        $elgg_file->open("write");
        if($decoded_data = base64_decode($this->data, true)){
            $elgg_file->write($decoded_data);
        } else{
            $elgg_file->write($this->data);
        }        $elgg_file->close();
        $elgg_file->access_id = ACCESS_PUBLIC;
        $elgg_file->save();
        $this->owner_id = (int)$elgg_file->owner_guid;
        $this->time_created = (int)$elgg_file->time_created;
        return $this->id = (int)$elgg_file->guid;
    }
}