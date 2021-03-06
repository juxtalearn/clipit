<?php
/**
 * Clipit eLearning Platform
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      urjc_backend
 */

/**
 * <Class Description>
 */
class UBFile extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "UBFile";
    /**
     * Class constants
     */
    const TIMESTAMP_DELIMITER = "#";
    const DEFAULT_FILENAME = "unnamed_file";
    const THUMB_SMALL = 64;
    const THUMB_MEDIUM = 128;
    const THUMB_LARGE = 256;

    /**
     * Class variables
     */
    public $data = null;
    public $size = 0;
    public $file_path = "";
    public $temp_path = "";
    public $thumb_small = "";
    public $thumb_medium = "";
    public $thumb_large = "";
    public $mime_full = "";
    public $mime_short = "";
    public $mime_ext = "";

    /**
     * Constructor
     *
     * @param int $id If != null, load instance.
     *
     * @throws APIException
     **/
    function __construct($id = null) {
        if (!empty($id)) {
            if (!($elgg_file = new ElggFile((int)$id))) {
                throw new APIException("ERROR: Id '" . $id . "' does not correspond to a " . get_called_class() . " object.");
            }
            $elgg_type = $elgg_file->type;
            $elgg_subtype = $elgg_file->getSubtype();
            if (($elgg_type != static::TYPE) || ($elgg_subtype != static::SUBTYPE)) {
                throw new APIException("ERROR: ID '" . $id . "' does not correspond to a " . get_called_class() . " object.");
            }
            $this->copy_from_elgg($elgg_file);
        }
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggFile $elgg_file
     */
    protected function copy_from_elgg($elgg_file) {
        $this->id = (int)$elgg_file->get("guid");
        $this->description = (string)$elgg_file->get("description");
        $this->owner_id = (int)$elgg_file->getOwnerGUID();
        $this->time_created = (int)$elgg_file->getTimeCreated();
        $this->name = (string)$elgg_file->get("name");
        $this->size = (int)$elgg_file->size();
        $this->file_path = (string)$elgg_file->getFilenameOnFilestore();
        $this->url = (string)elgg_get_site_url() . "file/download/" . $this->id;
        $this->mime_full = (string)$elgg_file->get("mime_full");
        $this->mime_short = (string)$elgg_file->get("mime_short");
        $this->mime_ext = (string)$elgg_file->get("mime_ext");
        $this->cloned_from = (int)static::get_cloned_from($this->id);
        $this->clone_array = (array)static::get_clones($this->id);
        if (!empty($elgg_file->thumb_small)) {
            $this->thumb_small["path"] = (string)$elgg_file->get("thumb_small");
            $this->thumb_small["url"] = (string)elgg_get_site_url() . "file/thumbnail/small/" . $this->id;
            $this->thumb_medium["path"] = (string)$elgg_file->get("thumb_medium");
            $this->thumb_medium["url"] = (string)elgg_get_site_url() . "file/thumbnail/medium/" . $this->id;
            $this->thumb_large["path"] = (string)$elgg_file->get("thumb_large");
            $this->thumb_large["url"] = (string)elgg_get_site_url() . "file/thumbnail/large/" . $this->id;
        }
    }

    /**
     * Copy $this file parameters into an Elgg File entity.
     *
     * @param ElggFile $elgg_file Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_file) {
        if ($this->time_created == 0 || !$elgg_file->getFilename()) { // new file
            $elgg_file->set("filename", (string)rand());
        }
        $elgg_file->description = (string)$this->description;
        if(!empty($this->owner_id)) {
            $elgg_file->set("owner_guid", (int)$this->owner_id);
        }
        $elgg_file->access_id = ACCESS_PUBLIC;
        // Save file data
        if (!empty($this->data)) { // new file or new data
            $elgg_file->open("write");
            $decoded_data = base64_decode($this->data, true);
            if ($decoded_data !== false) {
                $elgg_file->write($decoded_data);
            } else {
                $elgg_file->write($this->data);
            }
            $elgg_file->close();
        } elseif (!empty($this->temp_path)) { // File was uploaded into local temp dir
            $elgg_file->open("write"); // to ensure file is created in disk
            $elgg_file->close();
            copy($this->temp_path, $elgg_file->getFilenameOnFilestore());
        }
        // if the mimetype is already set, use the whole $this->name as name
        if(!empty($this->mime_full)){
            $elgg_file->set("name", (string)$this->name);
            $elgg_file->set("mime_ext", (string)$this->mime_ext);
            $elgg_file->set("mime_full", (string)$this->mime_full);
            $elgg_file->set("mime_short", (string)$this->mime_short);
        }
        // else separate name part and extension part from $this->name and find out mime_type
        else{
            $elgg_file->set("name", (string)pathinfo($this->name, PATHINFO_FILENAME));
            $file_extension = (string)pathinfo($this->name, PATHINFO_EXTENSION);
            $elgg_file->set("mime_ext", $file_extension);
            $filestore_name = $elgg_file->getFilenameOnFilestore();
            $mime_full = (string)static::get_mime_type($filestore_name, $file_extension);
            $elgg_file->set("mime_full", $mime_full);
            $elgg_file->set("mime_short", (string)static::get_simple_mime_type($mime_full));
        }
        // if thumbnails already exist
        if (!empty($this->thumb_small)) {
            $elgg_file->set("thumb_small", (string)$this->thumb_small["path"]);
            $elgg_file->set("thumb_medium", (string)$this->thumb_medium["path"]);
            $elgg_file->set("thumb_large", (string)$this->thumb_large["path"]);
        } else{
            static::create_thumbnails($elgg_file);
        }
    }


    /**
     * Saves this instance into the system.
     *
     * @param bool $double_save defaults to false. This param has no effect
     * in the current implementation and is just added for compatibility reasons to UBFile's ancestors.
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save($double_save = false) {
        if (!empty($this->id)) {
            if (!$elgg_file = new ElggFile($this->id)) {
                return false;
            }
        } else {
            $elgg_file = new ElggFile();
            $elgg_file->type = static::TYPE;
            $elgg_file->subtype = static::SUBTYPE;
        }
        $this->copy_to_elgg($elgg_file);
        $elgg_file->save();
        if ($double_save) {
            // Only updates are saving time_created, thus first save for creation, second save for updating to
            //proper creation time if given.
            $elgg_file->save();
        }
        return $this->id = $elgg_file->guid;
    }

    /**
     * Clone the specified File, including all of its properties.
     *
     * @param int $id File id from which to create a clone.
     * @param bool $linked Selects whether the clone will be linked to the parent object.
     * @param bool $keep_owner Selects whether the clone will keep the parent file's owner (default: no)
     *
     * @return bool|int Id of the new clone Item, false in case of error.
     */
    static function create_clone($id, $linked = true, $keep_owner = false) {
        $parent_file = new ClipitFile($id);
        $prop_value_array = static::get_properties($id);
        // use parent file location as temp_path for cloned file
        $prop_value_array["temp_path"] = $parent_file->file_path;
        if($keep_owner === false){
            $prop_value_array["owner_id"] = elgg_get_logged_in_user_guid();
        }
        $clone_id = static::set_properties(null, $prop_value_array);
        if($linked){
            static::link_parent_clone($id, $clone_id);
        }
        return $clone_id;
    }

    /**
     * Sanitize a filename for browser-friendly download
     *
     * @param string $filename String with a filename
     * @return string Sanitized filename
     */
    static function sanitize_filename($filename){
        return ElggTranslit::urlize($filename, '_');
    }

    /**
     * Get File MIME Type
     *
     * @param string $file Filename on Filestore
     * @param string $ext File extension
     *
     * @return string Full Mime Type of File
     */
    private static function get_mime_type($file, $ext) {
        $full_mime_type = "";
        switch($ext){
            case "doc":
                $full_mime_type = "application/msword";
                break;
            case "docx":
                $full_mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                break;
            case "xls":
                $full_mime_type = "application/vnd.ms-excel";
                break;
            case "xlsx":
                $full_mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                break;
            case "ppt":
                $full_mime_type = "application/vnd.ms-powerpoint";
                break;
            case "pptx":
                $full_mime_type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                break;
            default:
                $resource = finfo_open(FILEINFO_MIME_TYPE);
                if ($resource) {
                    $full_mime_type = finfo_file($resource, $file);
                }
        }
        return $full_mime_type;
    }

    /**
     * Returns an overall file type from the mimetype
     *
     * @param string $mime_type The MIME type
     *
     * @return string The overall type
     */
    private static function get_simple_mime_type($mime_type) {
        switch ($mime_type) {
            case "application/msword":
            case "application/vnd.ms-excel":
            case "application/vnd.ms-powerpoint":
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return "document";
            case "application/pdf":
                return "document";
            case "application/ogg":
                return "audio";
            case "application/x-rar":
            case "application/zip":
                return "compressed";
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
     * Create thumbnails for Files with MIME type = image
     *
     * @param ElggFile $elgg_file
     */
    private static function create_thumbnails($elgg_file) {
        $file_name = $elgg_file->getFilename();
        $filestore_name = $elgg_file->getFilenameOnFilestore();
        $simple_mime_type = $elgg_file->get("mime_short");
        // if image, we need to create thumbnails (this should be moved into a function)
        if ($simple_mime_type == "image") {
            $thumb = new ElggFile();
            // squared small thumbnail
            $thumbnail_small = get_resized_image_from_existing_file($filestore_name,
                static::THUMB_SMALL,
                static::THUMB_SMALL,
                true);
            if ($thumbnail_small) {
                $thumb->setFilename("thumb_small-" . $file_name);
                $thumb->open("write");
                $thumb->write($thumbnail_small);
                $thumb->close();
                $elgg_file->set("thumb_small", (string)$thumb->getFilenameOnFilestore());
            }
            // squared medium thumbnail
            $thumbnail_medium = get_resized_image_from_existing_file($filestore_name,
                static::THUMB_MEDIUM,
                static::THUMB_MEDIUM,
                true);
            if ($thumbnail_medium) {
                $thumb->setFilename("thumb_medium-" . $file_name);
                $thumb->open("write");
                $thumb->write($thumbnail_medium);
                $thumb->close();
                $elgg_file->set("thumb_medium", (string)$thumb->getFilenameOnFilestore());
            }
            // original proportion large thumbnail
            $thumbnail_large = get_resized_image_from_existing_file($filestore_name,
                static::THUMB_LARGE,
                static::THUMB_LARGE,
                false);
            if ($thumbnail_large) {
                $thumb->setFilename("thumb_large-" . $file_name);
                $thumb->open("write");
                $thumb->write($thumbnail_large);
                $thumb->close();
                $elgg_file->set("thumb_large", (string)$thumb->getFilenameOnFilestore());
            }
        }
    }
}