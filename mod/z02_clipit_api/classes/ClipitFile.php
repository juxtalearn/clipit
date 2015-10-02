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
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitFile";
    const REL_FILE_TAG = "ClipitFile-ClipitTag";
    const REL_FILE_LABEL = "ClipitFile-ClipitLabel";
    const REL_FILE_USER = "ClipitFile-ClipitUser";
    const SCOPE_GROUP = "group";
    const SCOPE_ACTIVITY = "activity";
    const SCOPE_SITE = "site";
    // Scopes
    const SCOPE_EXAMPLE = "example";
    const SCOPE_TRICKYTOPIC = "tricky_topic";
    const SCOPE_TASK = "task";
    public $tag_array = array();
    public $label_array = array();
    public $read_array = array();

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
    }

    /**
     * Copy $this object parameters into an Elgg file.
     *
     * @param ElggFile $elgg_file Elgg file instance to save $this to
     */
    protected function copy_to_elgg($elgg_file)
    {
        parent::copy_to_elgg($elgg_file);
        //$elgg_file->set("read_array", (array)$this->read_array);
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


    static function get_by_tags($tag_array)
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

    static function get_by_labels($label_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_labels = (array)static::get_labels((int)$item_id);
            foreach ($label_array as $search_tag) {
                if (array_search($search_tag, $item_labels) !== false) {
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
}
