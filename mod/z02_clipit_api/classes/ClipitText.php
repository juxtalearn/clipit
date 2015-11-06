<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * Contains a text material created by a student or groups as part of a "text submit" type task.
 */
class ClipitText extends UBItem {
    
    const SUBTYPE = "ClipitText";
    // Text relationships
    const REL_TEXT_TAG = "ClipitText-ClipitTag";
    const REL_TEXT_RUBRIC = "ClipitText-ClipitRubric";
    const REL_TEXT_LABEL = "ClipitText-ClipitLabel";
    const REL_TEXT_USER = "ClipitText-ClipitUser";
    // Text Container relationships
    const REL_EXAMPLE_TEXT = ClipitExample::REL_EXAMPLE_TEXT;
    const REL_GROUP_TEXT = ClipitGroup::REL_GROUP_TEXT;
    const REL_TASK_TEXT = ClipitTask::REL_TASK_TEXT;
    const REL_ACTIVITY_TEXT = ClipitActivity::REL_ACTIVITY_TEXT;
    const REL_TRICKYTOPIC_TEXT = ClipitTrickyTopic::REL_TRICKYTOPIC_TEXT;
    const REL_SITE_TEXT = ClipitSite::REL_SITE_TEXT;
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

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
        $this->tag_array = (array)static::get_tags($this->id);
        $this->label_array = (array)static::get_labels($this->id);
        $this->read_array = (array)static::get_read_array($this->id);
        $this->overall_rating_average = (float)$elgg_entity->get("overall_rating_average");
        $this->tag_rating_average = (float)$elgg_entity->get("tag_rating_average");
        $this->rubric_rating_average = (float)$elgg_entity->get("rubric_rating_average");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("overall_rating_average", (float)$this->overall_rating_average);
        $elgg_entity->set("tag_rating_average", (float)$this->tag_rating_average);
        $elgg_entity->set("rubric_rating_average", (float)$this->rubric_rating_average);
        $elgg_entity->set("url", (string)$this->url);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly.
     *         E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_labels($this->id, (array)$this->label_array);
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
     * Add Read Array for a Text
     *
     * @param int $id ID of the Text
     * @param array $read_array Array of User IDs who have read the Text
     *
     * @return bool True if OK, false if error
     */
    static function add_read_array($id, $read_array) {
        return UBCollection::add_items($id, $read_array, static::REL_TEXT_USER);
    }

    /**
     * Set Read Array for a Text
     *
     * @param int $id ID of the Text
     * @param array $read_array Array of User IDs who have read the Text
     *
     * @return bool True if OK, false if error
     */
    static function set_read_array($id, $read_array) {
        return UBCollection::set_items($id, $read_array, static::REL_TEXT_USER);
    }

    /**
     * Remove Read Array for a Text
     *
     * @param int $id ID of the Text
     * @param array $read_array Array of User IDs who have read the Text
     *
     * @return bool True if OK, false if error
     */
    static function remove_read_array($id, $read_array) {
        return UBCollection::remove_items($id, $read_array, static::REL_TEXT_USER);
    }

    /**
     * Get Read Array for a Text
     *
     * @param int $id ID of the Text
     *
     * @return static[] Array of Text IDs
     */
    static function get_read_array($id) {
        return UBCollection::get_items($id, static::REL_TEXT_USER);
    }

    /**
     * Get a list of Users who have Read a Text, or optionally whether certain Users have read it
     *
     * @param int $id ID of the Text
     * @param null|array $user_array List of User IDs - optional
     *
     * @return array[bool] Array with key => value: (int)user_id => (bool)read_status
     */
    static function get_read_status($id, $user_array = null)
    {
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
     * Set the Read status for a Text
     *
     * @param int $id ID of Text
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     *
     * @return bool|int ID of Text if Ok, false if error
     * @throws InvalidParameterException
     */
    static function set_read_status($id, $read_value, $user_array)
    {
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
     * Get all Tags from a Text
     *
     * @param int $id Id of the Text to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id)
    {
        return UBCollection::get_items($id, static::REL_TEXT_TAG);
    }

    /**
     * Adds Tags to a Text, referenced by Id.
     *
     * @param int $id Id from the Text to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Text
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array)
    {
        return UBCollection::add_items($id, $tag_array, static::REL_TEXT_TAG);
    }

    /**
     * Remove Tags from a Text.
     *
     * @param int $id Id from Text to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Text
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array)
    {
        return UBCollection::remove_items($id, $tag_array, static::REL_TEXT_TAG);
    }

    /**
    * Sets Tags to a Text, referenced by Id.
    *
    * @param int $id Id from the Text to set Tags to
    * @param array $tag_array Array of Tag Ids to be set to the Text
    *
    * @return bool Returns true if success, false if error
    */
    static function set_tags($id, $tag_array)
    {
        return UBCollection::set_items($id, $tag_array, static::REL_TEXT_TAG);
    }

    static function get_by_tag($tag_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get only item ids, not objects
        foreach ($all_items as $item_id) {
            $item_tags = (array)static::get_tags((int)$item_id);
            foreach ($tag_array as $search_tag) {
                if (in_array($search_tag, $item_tags)) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_by_tricky_topic($tt_array){
        $return_array = array();
        foreach($tt_array as $tt_id){
            $tt_tags = ClipitTrickyTopic::get_tags($tt_id);
            $return_array[$tt_id] = static::get_by_tag($tt_tags);
        }
        return $return_array;
    }

    /**
     * Get Label Ids from a Text.
     *
     * @param int $id Id of the Text to get Labels from.
     *
     * @return array|bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id)
    {
        return UBCollection::get_items($id, static::REL_TEXT_LABEL);
    }

    /**
     * Add Labels to a Text.
     *
     * @param int $id Id of the Text to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Text.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array)
    {
        return UBCollection::add_items($id, $label_array, static::REL_TEXT_LABEL);
    }

    /**
     * Remove Labels from a Text.
     *
     * @param int $id Id of the Text to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Text.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array)
    {
        return UBCollection::remove_items($id, $label_array, static::REL_TEXT_LABEL);
    }

    /**
     * Set Labels to a Text.
     *
     * @param int $id Id of the Text to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Text.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array)
    {
        return UBCollection::set_items($id, $label_array, static::REL_TEXT_LABEL);
    }

    static function get_by_label($label_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_labels = (array)static::get_labels((int)$item_id);
            foreach ($label_array as $search_tag) {
                if (in_array($search_tag, $item_labels)) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_rubric_items($id)
    {
        return UBCollection::get_items($id, static::REL_TEXT_RUBRIC);
    }

    static function add_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::add_items($id, $rubric_item_array, static::REL_TEXT_RUBRIC);
    }

    static function remove_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_TEXT_RUBRIC);
    }

    static function set_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::set_items($id, $rubric_item_array, static::REL_TEXT_RUBRIC);
    }

    static function get_by_rubric_item($rubric_item_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_rubric_items = static::get_rubric_items((int)$item_id);
            foreach ($rubric_item_array as $search_tag) {
                if (in_array($search_tag, $item_rubric_items)) {
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
        $example = static::get_example($id);
        if (!empty($example)) {
            return static::SCOPE_EXAMPLE;
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
        $tricky_topic = static::get_tricky_topic($id);
        if (!empty($tricky_topic)) {
            return static::SCOPE_TRICKYTOPIC;
        }
        return null;
    }

    static function get_site($id, $recursive = false)
    {
        $site_array = UBCollection::get_items($id, static::REL_SITE_TEXT, true);
        if (!empty($site_array)) {
            return array_pop($site_array);
        }
        if ($recursive) {
            $clone_array = static::get_clones($id, true);
            foreach ($clone_array as $clone_id) {
                $site_array = UBCollection::get_items($clone_id, static::REL_SITE_TEXT, true);
                if (!empty($site_array)) {
                    return array_pop($site_array);
                }
            }
        }
        return null;
    }

    static function get_example($id)
    {
        $example = UBCollection::get_items($id, static::REL_EXAMPLE_TEXT, true);
        if (empty($example)) {
            return null;
        }
        return array_pop($example);
    }

    static function get_task($id)
    {
        $task = UBCollection::get_items($id, static::REL_TASK_TEXT, true);
        if (empty($task)) {
            return null;
        }
        return array_pop($task);
    }

    /**
     * Get the Group where a Text is located
     *
     * @param int $id Text ID
     *
     * @return int|null Returns the Group ID, or null if none.
     */
    static function get_group($id) {
        $text = new static($id);
        if(!empty($text->cloned_from)) {
            return static::get_group($text->cloned_from);
        }
        $group = UBCollection::get_items($id, static::REL_GROUP_TEXT, true);
        if(empty($group)) {
            return null;
        }
        return (int)array_pop($group);
    }

    static function get_activity($id) {
        $group_id = static::get_group($id);
        if(!empty($group_id)) {
            return ClipitGroup::get_activity($group_id);
        } else {
            $activity = UBCollection::get_items($id, static::REL_ACTIVITY_TEXT, true);
            if(empty($activity)) {
                return null;
            }
            return array_pop($activity);
        }
    }

    static function get_tricky_topic($id)
    {
        $activity_array = UBCollection::get_items($id, static::REL_TRICKYTOPIC_TEXT, true);
        if (empty($activity_array)) {
            return null;
        }
        return array_pop($activity_array);
    }

}
