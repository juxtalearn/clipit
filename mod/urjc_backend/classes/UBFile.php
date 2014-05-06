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
    const THUMB_SMALL = 64;
    const THUMB_NORMAL = 128;
    const THUMB_LARGE = 256;
    /**
     * @var string File data in byte string format
     */
    public $data = null;
    public $size = 0;
    public $file_path = "";
    public $temp_path = "";
    public $thumb_small = null;
    public $thumb_normal = null;
    public $thumb_large = null;
    public $mime_type = "";


    /* Instance Functions */
    /**
     * Constructor
     *
     * @param int $id If $id is null, create new instance; else load instance with id = $id.
     *
     * @throws APIException
     */
    function __construct($id = null){
        if(!empty($id)){
            if(!($elgg_file = new ElggFile((int)$id))){
                throw new APIException("ERROR: Id '" . $id . "' does not correspond to a " . get_class_name() . " object.");
            }
            $this->load_from_elgg($elgg_file);
        }
    }

    /**
     * @param ElggFile $elgg_file
     */
    protected function load_from_elgg($elgg_file){
        $this->id = (int)$elgg_file->get("guid");
        $this->description = (string)$elgg_file->get("description");
        $this->owner_id = (int)$elgg_file->getOwnerGUID();
        $this->time_created = (int)$elgg_file->getTimeCreated();
        $file_name = $elgg_file->getFilename();
        $temp_name = explode(static::TIMESTAMP_DELIMITER, $file_name);
        if(empty($temp_name[1])){
            // no timestamp found
            $this->name = $temp_name[0];
        } else{
            $this->name = $temp_name[1];
        }
        $this->data = $elgg_file->grabFile();
        $this->size = $elgg_file->size();
        $this->file_path = (string)$elgg_file->getFilenameOnFilestore();
        $thumbs = new ElggFile();
        $thumbs->owner_guid = $elgg_file->owner_guid;
        $thumbs->setFilename($elgg_file->thumb_small);
        $this->thumb_small = $thumbs->grabFile();
        $thumbs->setFilename($elgg_file->thumb_normal);
        $this->thumb_normal = $thumbs->grabFile();
        $thumbs->setFilename($elgg_file->thumb_large);
        $this->thumb_large = $thumbs->grabFile();
        $this->mime_type = $elgg_file->getMimeType();
    }

    /**
     * Saves this instance to the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        if(!empty($this->id)){
            if(!$elgg_file = new ElggFile($this->id)){
                return false;
            }
        } else{
            $elgg_file = new ElggFile();
            $elgg_file->type = static::TYPE;
            $elgg_file->subtype = static::SUBTYPE;
        }
        $this->copy_to_elgg($elgg_file);
        static::create_thumbnails($elgg_file);
        $elgg_file->save();
        return $this->id = $elgg_file->guid;
    }



    /**
     * Saves this instance to the system
     * @param ElggFile $elgg_file Elgg file instance to save Item to
     */
    protected function copy_to_elgg($elgg_file){
        $date_obj = new DateTime();
        if(empty($this->name)){
            $this->name = static::DEFAULT_FILENAME;
        }
        $elgg_file->setFilename((string)$date_obj->getTimestamp() . static::TIMESTAMP_DELIMITER . (string)$this->name);
        $elgg_file->description = (string)$this->description;
        $elgg_file->access_id = ACCESS_PUBLIC;
        if($this->data !== null){
            $elgg_file->open("write");
            if($decoded_data = base64_decode($this->data, true)){
                $elgg_file->write($decoded_data);
            } else{
                $elgg_file->write($this->data);
            }
            $elgg_file->close();
        }
        else{ // File was uploaded into local temp dir
            $elgg_file->open("write"); // to ensure file is created in disk
            $elgg_file->close();
            move_uploaded_file($this->temp_path, $elgg_file->getFilenameOnFilestore());
        }
        $filestore_name = $elgg_file->getFilenameOnFilestore();
        $mime_type = $elgg_file->detectMimeType($filestore_name);
        $elgg_file->setMimeType($mime_type);
    }

    /**
     * Returns an overall file type from the mimetype
     *
     * @param string $mimetype The MIME type
     * @return string The overall type
     */
    static function file_get_simple_type($mimetype) {
        switch ($mimetype) {
            case "application/msword":
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                return "document";
                break;
            case "application/pdf":
                return "document";
                break;
            case "application/ogg":
                return "audio";
                break;
        }

        if (substr_count($mimetype, 'text/')) {
            return "document";
        }

        if (substr_count($mimetype, 'audio/')) {
            return "audio";
        }

        if (substr_count($mimetype, 'image/')) {
            return "image";
        }

        if (substr_count($mimetype, 'video/')) {
            return "video";
        }

        if (substr_count($mimetype, 'opendocument')) {
            return "document";
        }

        return "general";
    }

    /**
     * @param ElggFile $elgg_file
     */
    private static function create_thumbnails($elgg_file){
        $file_name = $elgg_file->getFilename();
        $filestore_name = $elgg_file->getFilenameOnFilestore();
        $simple_mime_type = static::file_get_simple_type($elgg_file->getMimeType());
        // if image, we need to create thumbnails (this should be moved into a function)
        if ($simple_mime_type == "image") {
            $thumb = new ElggFile();
            $thumb->setMimeType($elgg_file->getMimeType());
            $thumbnail = get_resized_image_from_existing_file($filestore_name, static::THUMB_SMALL, static::THUMB_SMALL, false);
            if ($thumbnail) {
                $thumb->setFilename("thumb_small".$file_name);
                $thumb->open("write");
                $thumb->write($thumbnail);
                $thumb->close();
                $elgg_file->thumb_small = "thumb_small".$file_name;
                unset($thumbnail);
            }

            $thumbnail = get_resized_image_from_existing_file($filestore_name, static::THUMB_NORMAL, static::THUMB_NORMAL, false);
            if ($thumbnail) {
                $thumb->setFilename("thumb_normal".$file_name);
                $thumb->open("write");
                $thumb->write($thumbnail);
                $thumb->close();
                $elgg_file->thumb_normal = "thumb_normal".$file_name;
                unset($thumbnail);
            }

            $thumbnail = get_resized_image_from_existing_file($filestore_name, static::THUMB_LARGE, static::THUMB_LARGE, false);
            if ($thumbnail) {
                $thumb->setFilename("thumb_large".$file_name);
                $thumb->open("write");
                $thumb->write($thumbnail);
                $thumb->close();
                $elgg_file->thumb_large = "thumb_large".$file_name;
                unset($thumbnail);
            }
        }
    }
}