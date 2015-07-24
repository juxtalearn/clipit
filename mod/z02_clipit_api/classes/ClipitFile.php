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

/**
 * A binary file with thumbnails (in case of images), and can be tagged and labeled.
 */
class ClipitFile extends UBFile {

    const SUBTYPE = "ClipitFile";
    // File relationships
    const REL_FILE_TAG = "ClipitFile-ClipitTag";
    const REL_FILE_RUBRIC = "ClipitFile-ClipitRubric";
    const REL_FILE_LABEL = "ClipitFile-ClipitLabel";
    const REL_FILE_USER = "ClipitFile-ClipitUser";
    // Scopes
    const SCOPE_GROUP = "group";
    const SCOPE_ACTIVITY = "activity";
    const SCOPE_SITE = "site";
    const SCOPE_EXAMPLE = "example";
    const SCOPE_TRICKYTOPIC = "tricky_topic";
    const SCOPE_TASK = "task";
    // Tagging
    public $tag_array = array();
    public $label_array = array();
    public $read_array = array();
    // Rating averages
    public $overall_rating_average = 0.0;
    public $tag_rating_average = 0.0;
    public $rubric_rating_average = 0.0;
    // GDrive ID
    public $gdrive_id = "";

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggFile $elgg_file Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_file)
    {
        parent::copy_from_elgg($elgg_file);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->label_array = (array)static::get_labels($this->id);
        $this->read_array = (array)static::get_read_array($this->id);
        $this->overall_rating_average = (float)$elgg_file->get("overall_rating_average");
        $this->tag_rating_average = (float)$elgg_file->get("tag_rating_average");
        $this->rubric_rating_average = (float)$elgg_file->get("rubric_rating_average");
        $this->gdrive_id = (string)$elgg_file->get("gdrive_id");
    }

    /**
     * Copy $this object parameters into an Elgg file.
     *
     * @param ElggFile $elgg_file Elgg file instance to save $this to
     */
    protected function copy_to_elgg($elgg_file)
    {
        parent::copy_to_elgg($elgg_file);
        $elgg_file->set("overall_rating_average", (float)$this->overall_rating_average);
        $elgg_file->set("tag_rating_average", (float)$this->tag_rating_average);
        $elgg_file->set("rubric_rating_average", (float)$this->rubric_rating_average);
        $elgg_file->set("gdrive_id", (string)$this->gdrive_id);
    }

    /**
     * Saves this instance to the system.
     *
     * @param bool $double_save Specifies whether to save file twice (necessary for file_creation_date edit)
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_tags($this->id, $this->tag_array);
        static::set_labels($this->id, $this->label_array);
        static::set_read_array($this->id, $this->read_array);
        return $this->id;
    }

    static function update_average_ratings($id)
    {
        $prop_value_array["overall_rating_average"] = (float)ClipitRating::get_average_rating_for_target($id);
        $prop_value_array["tag_rating_average"] = (float)ClipitTagRating::get_average_rating_for_target($id);
        $prop_value_array["rubric_rating_average"] = (float)ClipitRubricRating::get_average_rating_for_target($id);
        return static::set_properties($id, $prop_value_array);
    }

    /**
     * Add Read Array for a File
     *
     * @param int $id ID of the File
     * @param array $read_array Array of User IDs who have read the File
     *
     * @return bool True if OK, false if error
     */
    static function add_read_array($id, $read_array) {
        return UBCollection::add_items($id, $read_array, static::REL_FILE_USER);
    }

    /**
     * Set Read Array for a File
     *
     * @param int $id ID of the File
     * @param array $read_array Array of User IDs who have read the File
     *
     * @return bool True if OK, false if error
     */
    static function set_read_array($id, $read_array) {
        return UBCollection::set_items($id, $read_array, static::REL_FILE_USER);
    }

    /**
     * Remove Read Array for a File
     *
     * @param int $id ID of the File
     * @param array $read_array Array of User IDs who have read the File
     *
     * @return bool True if OK, false if error
     */
    static function remove_read_array($id, $read_array) {
        return UBCollection::remove_items($id, $read_array, static::REL_FILE_USER);
    }

    /**
     * Get Read Array for a File
     *
     * @param int $id ID of the File
     *
     * @return static[] Array of File IDs
     */
    static function get_read_array($id) {
        return UBCollection::get_items($id, static::REL_FILE_USER);
    }

    /**
     * Get a list of Users who have read a File, or optionally whether certain Users have read it
     *
     * @param int $id ID of the File
     * @param null|array $user_array List of User IDs - optional
     *
     * @return static[] Array with key => value: user_id => read_status, where read_status is bool
     */
    static function get_read_status($id, $user_array = null) {
        $props = static::get_properties($id, array("read_array", "owner_id"));
        $read_array = $props["read_array"];
        $owner_id = $props["owner_id"];
        if (!$user_array) {
            return $read_array;
        } else {
            $return_array = array();
            foreach ($user_array as $user_id) {
                if ((int)$user_id == (int)$owner_id || in_array($user_id, $read_array)) {
                    $return_array[$user_id] = true;
                } else {
                    $return_array[$user_id] = false;
                }
            }
            return $return_array;
        }
    }

    /**
     * Set the Read status for a File
     *
     * @param int $id ID of File
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     *
     * @return bool|int ID of File if Ok, false if error
     * @throws InvalidParameterException
     */
    static function set_read_status($id, $read_value, $user_array) {
        $read_array = static::get_read_array($id);
        $update_flag = false;
        foreach ($user_array as $user_id) {
            $index = array_search((int)$user_id, $read_array);
            if ($read_value === true && $index === false) {
                array_push($read_array, $user_id);
                $update_flag = true;
            } elseif ($read_value === false && $index !== false) {
                array_splice($read_array, $index, 1);
                $update_flag = true;
            }
        }
        if ($update_flag) {
            return static::set_read_array($id, $read_array);
        } else {
            return $id;
        }
    }

    /**
     * Add Tags to a File.
     *
     * @param int $id Id of the File to add Tags to.
     * @param array $tag_array Array of Tag Ids to add to the File.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_tags($id, $tag_array)
    {
        return UBCollection::add_items($id, $tag_array, static::REL_FILE_TAG);
    }

    /**
     * Remove Tags from a File.
     *
     * @param int $id Id of the File to remove Tags from.
     * @param array $tag_array Array of Tags Ids to remove from the File.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_tags($id, $tag_array)
    {
        return UBCollection::remove_items($id, $tag_array, static::REL_FILE_TAG);
    }

    /**
     * Get Tag Ids from a File.
     *
     * @param int $id Id of the File to get Tags from.
     *
     * @return int[] Returns array of Tag Ids, or false if error.
     */
    static function get_tags($id)
    {
        return UBCollection::get_items($id, static::REL_FILE_TAG);
    }

    /**
     * Set Tags to a File.
     *
     * @param int $id Id of the File to set Tags to.
     * @param array $tag_array Array of Tag Ids to set to the File.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_tags($id, $tag_array)
    {
        return UBCollection::set_items($id, $tag_array, static::REL_FILE_TAG);
    }

    static function get_by_tag($tag_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_tags = static::get_tags((int)$item_id);
            foreach ($tag_array as $search_tag) {
                if (array_search($search_tag, $item_tags) !== false) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_by_trickytopic($tt_array){
        $return_array = array();
        foreach($tt_array as $tt_id){
            $tt_tags = ClipitTrickyTopic::get_tags($tt_id);
            $return_array[$tt_id] = static::get_by_tag($tt_tags);
        }
        return $return_array;
    }

    /**
     * Add Labels to a File.
     *
     * @param int $id Id of the File to add Labels to.
     * @param array $label_array Array of Label Ids to add to the File.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array)
    {
        return UBCollection::add_items($id, $label_array, static::REL_FILE_LABEL);
    }

    /**
     * Remove Labels from a File.
     *
     * @param int $id Id of the File to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the File.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array)
    {
        return UBCollection::remove_items($id, $label_array, static::REL_FILE_LABEL);
    }

    /**
     * Get Label Ids from a File.
     *
     * @param int $id Id of the File to get Labels from.
     *
     * @return int[] Returns array of Label Ids, or false if error.
     */
    static function get_labels($id)
    {
        return UBCollection::get_items($id, static::REL_FILE_LABEL);
    }



    /**
     * Set Labels to a File.
     *
     * @param int $id Id of the File to set Labels to.
     * @param array $label_array Array of Label Ids to set to the File.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array)
    {
        return UBCollection::set_items($id, $label_array, static::REL_FILE_LABEL);
    }

    static function get_by_label($label_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_labels = (array)static::get_label((int)$item_id);
            foreach ($label_array as $search_tag) {
                if (array_search($search_tag, $item_labels) !== false) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_rubric_items($id)
    {
        return UBCollection::get_items($id, static::REL_FILE_RUBRIC);
    }

    static function add_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::add_items($id, $rubric_item_array, static::REL_FILE_RUBRIC);
    }

    static function remove_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_FILE_RUBRIC);
    }

    static function set_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::set_items($id, $rubric_item_array, static::REL_FILE_RUBRIC);
    }

    static function get_by_rubric_item($rubric_item_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_rubric_items = static::get_rubric_item((int)$item_id);
            foreach ($rubric_item_array as $search_tag) {
                if (array_search($search_tag, $item_rubric_items) !== false) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_scope($id)
    {
        $site = static::get_site($id, false);
        if (!empty($site)) {
            return static::SCOPE_SITE;
        }
        $task = static::get_task($id);
        if (!empty($task)) {
            return static::SCOPE_TASK;
        }
        $group = static::get_group($id);
        if (!empty($group)) {
            return static::SCOPE_GROUP;
        }
        $activity = static::get_activity($id);
        if (!empty($activity)) {
            return static::SCOPE_ACTIVITY;
        }
        $example = static::get_example($id);
        if (!empty($example)) {
            return static::SCOPE_EXAMPLE;
        }
        $tricky_topic = static::get_tricky_topic($id);
        if (!empty($tricky_topic)) {
            return static::SCOPE_TRICKYTOPIC;
        }
        return null;
    }

    static function get_site($id, $recursive = false)
    {
        $site_array = UBCollection::get_items($id, ClipitSite::REL_SITE_VIDEO, true);
        if (!empty($site_array)) {
            return array_pop($site_array);
        }
        if ($recursive) {
            $clone_array = static::get_clones($id, true);
            foreach ($clone_array as $clone_id) {
                $site_array = UBCollection::get_items($clone_id, ClipitSite::REL_SITE_VIDEO, true);
                if (!empty($site_array)) {
                    return array_pop($site_array);
                }
            }
        }
        return null;
    }

    static function get_task($id)
    {
        $task = UBCollection::get_items($id, ClipitTask::REL_TASK_FILE, true);
        if (empty($task)) {
            return null;
        }
        return array_pop($task);
    }

    /**
     * Get the Group where a Resource is located
     *
     * @param int $id Resource ID
     *
     * @return int|null Returns the Group ID, or null if none.
     */
    static function get_group($id) {
        $file = new static($id);
        if(!empty($file->cloned_from)) {
            return static::get_group($file->cloned_from);
        }
        $group = UBCollection::get_items($id, ClipitGroup::REL_GROUP_FILE, true);
        if (empty($group)) {
            return null;
        }
        return (int)array_pop($group);
    }

    static function get_activity($id)
    {
        $group_id = static::get_group($id);
        if (!empty($group_id)) {
            return ClipitGroup::get_activity($group_id);
        } else {
            $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_FILE, true);
            if (empty($activity)) {
                return null;
            }
            return array_pop($activity);
        }
    }

    static function get_example($id)
    {
        $example = UBCollection::get_items($id, ClipitExample::REL_EXAMPLE_FILE, true);
        if (empty($example)) {
            return null;
        }
        return array_pop($example);
    }

    static function get_tricky_topic($id)
    {
        $activity_array = UBCollection::get_items($id, ClipitTrickyTopic::REL_TRICKYTOPIC_FILE, true);
        if (empty($activity_array)) {
            return null;
        }
        return array_pop($activity_array);
    }

    /**
     * Uploads to Google Drive a ClipIt file
     *
     * @param int $id Clipit file id to upload to Google Drive
     *
     * @return string Google Drive File ID
     */
    static function upload_to_gdrive($id)
    {
        if (!get_config("google_refresh_token")) {
            return false;
        }
        set_include_path(
            get_include_path() . PATH_SEPARATOR . elgg_get_plugins_path() . "z02_clipit_api/libraries/google_api/src/"
        );
        $lib_path = elgg_get_plugins_path() . "z02_clipit_api/libraries/";
        require_once($lib_path . "google_api/src/Google/Client.php");
        require_once($lib_path . "google_api/src/Google/Service/Drive.php");

        $client = new Google_Client();
        $client->setClientId(get_config("google_id"));
        $client->setClientSecret(get_config("google_secret"));
        try {
            $client->setAccessToken(get_config("google_token"));
        } catch (Exception $e) {
            error_log($e);
        }
        if ($client->isAccessTokenExpired()) {
            $refresh_token = get_config("google_refresh_token");
            $client->refreshToken($refresh_token);
        }
        if (!$client->getAccessToken()) {
            return null;
        }
        // Define an object that will be used to make all API requests.
        $drive_svc = new Google_Service_Drive($client);

        // Load Clipit File
        $clipit_file = ClipitFile::get_by_id(array($id));
        if(!empty($clipit_file)){
            $clipit_file = array_pop($clipit_file);
            $file_path = $clipit_file->file_path;
            $title = $clipit_file->name;
            $mime_type = $clipit_file->mime_full;
        } else{
            return null;
        }

        // Create Google Drive File
        $drive_file = new Google_Service_Drive_DriveFile();
        $drive_file->setTitle($title);
        $chunkSizeBytes = 1 * 1024 * 1024;
        $client->setDefer(true);
        $request = $drive_svc->files->insert($drive_file);
        $media = new Google_Http_MediaFileUpload(
            $client,
            $request,
            $mime_type,
            null,
            true,
            $chunkSizeBytes
        );
        $media->setFileSize(filesize($file_path));
        $status = false;
        $handle = fopen($file_path, "rb");
        while(!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        fclose($handle);
        $client->setDefer(false);
        $file_perms = new Google_Service_Drive_Permission();
        $file_perms->setType("anyone");
        $file_perms->setRole("reader");
        $file_perms->setValue("");
        $file_perms->setWithLink(true);
        $drive_svc->permissions->insert($status->getId(), $file_perms);
        $gdrive_id = (string)$status->id;

        // Save Google Drive ID in Clipit File
        ClipitFile::set_properties($id, array("gdrive_id" => (string)$gdrive_id));
        return $gdrive_id;
    }

}
