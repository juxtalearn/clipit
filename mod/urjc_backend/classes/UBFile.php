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
    public $mime_type = array();


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
        if(!empty($elgg_file->mime_type)){
            $this->mime_type["full"] = $elgg_file->mime_type[0];
            $this->mime_type["short"] = $elgg_file->mime_type[1];
        }
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
        $mime_type["full"] = (string)static::get_mime_type($filestore_name);
        if($mime_type["full"] == "application/zip"){ // Detect Office 2007+ mimetype
            $new_mime = static::getMicrosoftOfficeMimeInfo($filestore_name);
            if($new_mime !== false){
                $mime_type["full"] = (string)$new_mime["mime"];
            }
        }
        $mime_type["short"] = (string)static::get_simple_mime_type($mime_type["full"]);
        $elgg_file->mime_type = (array)$mime_type;
    }

    /**
     * @param string $file Filename on Filestore
     * @return bool|mixed|null|string Mime Type
     */
    static function get_mime_type($file) {
        $mime = false;

        // for PHP5 folks.
        if (function_exists('finfo_file') && defined('FILEINFO_MIME_TYPE')) {
            $resource = finfo_open(FILEINFO_MIME_TYPE);
            if ($resource) {
                $mime = finfo_file($resource, $file);
            }
        }
        // default
        if (!$mime) {
            return null;
        }

        return $mime;
    }




    /**
     * Returns an overall file type from the mimetype
     *
     * @param string $mime_type The MIME type
     * @return string The overall type
     */
    static function get_simple_mime_type($mime_type) {
        switch ($mime_type) {
            case "application/msword":
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return "document";
                break;
            case "application/pdf":
                return "document";
                break;
            case "application/ogg":
                return "audio";
                break;
        }

        if (substr_count($mime_type, 'text/')) {
            return "document";
        }

        if (substr_count($mime_type, 'audio/')) {
            return "audio";
        }

        if (substr_count($mime_type, 'image/')) {
            return "image";
        }

        if (substr_count($mime_type, 'video/')) {
            return "video";
        }

        if (substr_count($mime_type, 'opendocument')) {
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
        $simple_mime_type = static::get_simple_mime_type(static::get_mime_type($filestore_name));
        // if image, we need to create thumbnails (this should be moved into a function)
        if ($simple_mime_type == "image") {
            $thumb = new ElggFile();
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

    private static function getMicrosoftOfficeMimeInfo($file) {
        $fileInfo = array(
            'word/' => array(
                'type'      => 'Microsoft Word 2007+',
                'mime'      => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'extension' => 'docx'
            ),
            'ppt/' => array(
                'type'      => 'Microsoft PowerPoint 2007+',
                'mime'      => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'extension' => 'pptx'
            ),
            'xl/' => array(
                'type'      => 'Microsoft Excel 2007+',
                'mime'      => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'extension' => 'xlsx'
            )
        );

        $pkEscapeSequence = "PK\x03\x04";

        $file = new BinaryFile($file);
        if ($file->bytesAre($pkEscapeSequence, 0x00)) {
            if ($file->bytesAre('[Content_Types].xml', 0x1E)) {
                if ($file->search($pkEscapeSequence, null, 2000)) {
                    if ($file->search($pkEscapeSequence, null, 1000)) {
                        $offset = $file->tell() + 26;
                        foreach ($fileInfo as $searchWord => $info) {
                            $file->seek($offset);
                            if ($file->bytesAre($searchWord)) {
                                return $fileInfo[$searchWord];
                            }
                        }
                        return array(
                            'type'      => 'Microsoft OOXML',
                            'mime'      => null,
                            'extension' => null
                        );
                    }
                }
            }
        }

        return false;
    }
}

class BinaryFile_Exception extends Exception {}

class BinaryFile_Seek_Method {
    const ABSOLUTE = 1;
    const RELATIVE = 2;
}

class BinaryFile {
    const SEARCH_BUFFER_SIZE = 1024;

    private $handle;

    public function __construct($file) {
        $this->handle = fopen($file, 'r');
        if ($this->handle === false) {
            throw new BinaryFile_Exception('Cannot open file');
        }
    }

    public function __destruct() {
        fclose($this->handle);
    }

    public function tell() {
        return ftell($this->handle);
    }

    public function seek($offset, $seekMethod = null) {
        if ($offset !== null) {
            if ($seekMethod === null) {
                $seekMethod = BinaryFile_Seek_Method::ABSOLUTE;
            }
            if ($seekMethod === BinaryFile_Seek_Method::RELATIVE) {
                $offset += $this->tell();
            }
            return fseek($this->handle, $offset);
        } else {
            return true;
        }
    }

    public function read($length) {
        return fread($this->handle, $length);
    }

    public function search($string, $offset = null, $maxLength = null, $seekMethod = null) {
        if ($offset !== null) {
            $this->seek($offset);
        } else {
            $offset = $this->tell();
        }

        $bytesRead = 0;
        $bufferSize = ($maxLength !== null ? min(self::SEARCH_BUFFER_SIZE, $maxLength) : self::SEARCH_BUFFER_SIZE);

        while ($read = $this->read($bufferSize)) {
            $bytesRead += strlen($read);
            $search = strpos($read, $string);

            if ($search !== false) {
                $this->seek($offset + $search + strlen($string));
                return true;
            }

            if ($maxLength !== null) {
                $bufferSize = min(self::SEARCH_BUFFER_SIZE, $maxLength - $bytesRead);
                if ($bufferSize == 0) {
                    break;
                }
            }
        }
        return false;
    }

    public function getBytes($length, $offset = null, $seekMethod = null) {
        $this->seek($offset, $seekMethod);
        $read = $this->read($length);
        return $read;
    }

    public function bytesAre($string, $offset = null, $seekMethod = null) {
        return ($this->getBytes(strlen($string), $offset) == $string);
    }
}