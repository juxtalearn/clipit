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
 * An extensible class which holds common functionality and properties for Resource objects such as Videos or
 * Storyboards.
 */
abstract class ClipitResource extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitResource";
    const REL_RESOURCE_TAG = "ClipitResource-ClipitTag";
    const REL_RESOURCE_LABEL = "ClipitResource-ClipitLabel";
    const REL_RESOURCE_RUBRIC = "ClipitResource-ClipitRubricItem";
    // Resource Container relationships
    const REL_SITE_RESOURCE = "";
    const REL_EXAMPLE_RESOURCE = "";
    const REL_ACTIVITY_RESOURCE = "";
    const REL_TRICKYTOPIC_RESOURCE = "";
    const REL_TASK_RESOURCE = "";
    const REL_GROUP_RESOURCE = "";
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
    public $rubric_item_array = array();
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
        $this->rubric_item_array = (array)static::get_rubric_items($this->id);
        $this->read_array = (array)$elgg_entity->get("read_array");
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
        $elgg_entity->set("read_array", (array)$this->read_array);
        $elgg_entity->set("overall_rating_average", (float)$this->overall_rating_average);
        $elgg_entity->set("tag_rating_average", (float)$this->tag_rating_average);
        $elgg_entity->set("rubric_rating_average", (float)$this->rubric_rating_average);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_tags($this->id, (array)$this->tag_array);
        static::set_labels($this->id, (array)$this->label_array);
        static::set_rubric_items($this->id, (array)$this->rubric_item_array);
        return $this->id;
    }

    static function update_average_ratings($id)
    {
        $prop_value_array["overall_rating_average"] = (float)ClipitRating::get_average_rating_for_target($id);
        $prop_value_array["tag_rating_average"] = (float)ClipitTagRating::get_average_rating_for_target($id);
        $prop_value_array["rubric_rating_average"] = (float)ClipitRubricRating::get_average_rating_for_target($id);
        return static::set_properties($id, $prop_value_array);
    }

    static function get_by_tags($tag_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get only item ids, not objects
        foreach ($all_items as $item_id) {
            $item_tags = (array)static::get_tags((int)$item_id);
            foreach ($tag_array as $search_tag) {
                if (array_search($search_tag, $item_tags) !== false) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    /**
     * Get all Tags from a Resource
     *
     * @param int $id Id of the Resource to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id)
    {
        return UBCollection::get_items($id, static::REL_RESOURCE_TAG);
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

    /**
     * Get Label Ids from a Resource.
     *
     * @param int $id Id of the Resource to get Labels from.
     *
     * @return array|bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id)
    {
        return UBCollection::get_items($id, static::REL_RESOURCE_LABEL);
    }

    static function get_by_rubric_items($rubric_item_array)
    {
        $return_array = array();
        $all_items = static::get_all(0, 0, "", true, true); // Get all item ids, not objects
        foreach ($all_items as $item_id) {
            $item_rubric_items = static::get_rubric_items((int)$item_id);
            foreach ($rubric_item_array as $search_tag) {
                if (array_search($search_tag, $item_rubric_items) !== false) {
                    $return_array[(int)$item_id] = new static((int)$item_id);
                    break;
                }
            }
        }
        return $return_array;
    }

    static function get_rubric_items($id)
    {
        return UBCollection::get_items($id, static::REL_RESOURCE_RUBRIC);
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
        $site_array = UBCollection::get_items($id, static::REL_SITE_RESOURCE, true);
        if (!empty($site_array)) {
            return array_pop($site_array);
        }
        if ($recursive) {
            $clone_array = static::get_clones($id, true);
            foreach ($clone_array as $clone_id) {
                $site_array = UBCollection::get_items($clone_id, static::REL_SITE_RESOURCE, true);
                if (!empty($site_array)) {
                    return array_pop($site_array);
                }
            }
        }
        return null;
    }

    static function get_example($id)
    {
        $example = UBCollection::get_items($id, static::REL_EXAMPLE_RESOURCE, true);
        if (empty($example)) {
            return null;
        }
        return array_pop($example);
    }

    static function get_task($id)
    {
        $task = UBCollection::get_items($id, static::REL_TASK_RESOURCE, true);
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
        $resource = new static($id);
        if(!empty($resource->cloned_from)) {
            return static::get_group($resource->cloned_from);
        }
        $group = UBCollection::get_items($id, static::REL_GROUP_RESOURCE, true);
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
            $activity = UBCollection::get_items($id, static::REL_ACTIVITY_RESOURCE, true);
            if(empty($activity)) {
                return null;
            }
            return array_pop($activity);
        }
    }

    static function get_tricky_topic($id)
    {
        $activity_array = UBCollection::get_items($id, static::REL_TRICKYTOPIC_RESOURCE, true);
        if (empty($activity_array)) {
            return null;
        }
        return array_pop($activity_array);
    }

    /**
     * Adds Tags to a Resource, referenced by Id.
     *
     * @param int $id Id from the Resource to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Resource
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array)
    {
        return UBCollection::add_items($id, $tag_array, static::REL_RESOURCE_TAG);
    }

    /**
     * Remove Tags from a Resource.
     *
     * @param int $id Id from Resource to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Resource
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array)
    {
        return UBCollection::remove_items($id, $tag_array, static::REL_RESOURCE_TAG);
    }

    /**
     * Add Labels to a Resource.
     *
     * @param int $id Id of the Resource to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Resource.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array)
    {
        return UBCollection::add_items($id, $label_array, static::REL_RESOURCE_LABEL);
    }

    /**
     * Remove Labels from a Resource.
     *
     * @param int $id Id of the Resource to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Resource.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array)
    {
        return UBCollection::remove_items($id, $label_array, static::REL_RESOURCE_LABEL);
    }

    static function add_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::add_items($id, $rubric_item_array, static::REL_RESOURCE_RUBRIC);
    }

    static function remove_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_RESOURCE_RUBRIC);
    }

    /**
     * Get a list of Users who have Read a Resource, or optionally whether certain Users have read it
     *
     * @param int $id ID of the Resource
     * @param null|array $user_array List of User IDs - optional
     *
     * @return static[] Array with key => value: user_id => read_status, where read_status is bool
     */
    static function get_read_status($id, $user_array = null)
    {
        $props = static::get_properties($id, array("read_array"));
        $read_array = $props["read_array"];
        if (!$user_array) {
            return $read_array;
        } else {
            $return_array = array();
            foreach ($user_array as $user_id) {
                if (in_array($user_id, $read_array)) {
                    $return_array[$user_id] = true;
                } else {
                    $return_array[$user_id] = false;
                }
            }
            return $return_array;
        }
    }

    /**
     * Set the Read status for a Resource
     *
     * @param int $id ID of Resource
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     *
     * @return bool|int ID of Resource if Ok, false if error
     * @throws InvalidParameterException
     */
    static function set_read_status($id, $read_value, $user_array)
    {
        $read_array = static::get_properties($id, array("read_array"));
        $read_array = array_pop($read_array);
        foreach ($user_array as $user_id) {
            if ($read_value == true) {
                if (!in_array($user_id, $read_array)) {
                    array_push($read_array, $user_id);
                }
            } else if ($read_value == false) {
                $index = array_search((int)$user_id, $read_array);
                if (isset($index) && $index !== false) {
                    array_splice($read_array, $index, 1);
                }
            }
        }
        $prop_value_array["read_array"] = $read_array;
        return static::set_properties($id, $prop_value_array);
    }



    /**
     * Sets Tags to a Resource, referenced by Id.
     *
     * @param int $id Id from the Resource to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Resource
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array)
    {
        return UBCollection::set_items($id, $tag_array, static::REL_RESOURCE_TAG);
    }

    /**
     * Set Labels to a Resource.
     *
     * @param int $id Id of the Resource to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Resource.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array)
    {
        return UBCollection::set_items($id, $label_array, static::REL_RESOURCE_LABEL);
    }

    static function set_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::set_items($id, $rubric_item_array, static::REL_RESOURCE_RUBRIC);
    }
}