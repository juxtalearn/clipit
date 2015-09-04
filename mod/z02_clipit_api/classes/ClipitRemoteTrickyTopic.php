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
 * An class which holds properties for Remote Tricky Topics.
 */
class ClipitRemoteTrickyTopic extends UBItem {

    const SUBTYPE = "ClipitRemoteTrickyTopic";
    const REL_REMOTETRICKYTOPIC_TAG = "ClipitRemoteTrickyTopic-ClipitTag";
    public $remote_id;
    public $remote_site = 0;
    public $tag_array = "";

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->remote_id = (int)$elgg_entity->get("remote_id");
        $this->remote_site = (int)$elgg_entity->get("remote_site");
        $this->tag_array = (array)static::get_tags($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("remote_id", (int)$this->remote_id);
        $elgg_entity->set("remote_site", (int)$this->remote_site);
        static::set_tags((int)$this->id, (array)$this->tag_array);
    }

    static function create($prop_value_array){
        // convert "remote_site" from string to local ID
        $remote_site_url = base64_decode($prop_value_array["remote_site"]);
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site_url, true);
        $prop_value_array["remote_site"] = $remote_site_id;
        // Base64 decode some properties which can contain special characters
        $prop_value_array["name"] = base64_decode($prop_value_array["name"]);
        $prop_value_array["description"] = base64_decode($prop_value_array["description"]);
        // convert tag_array from array of names to array of local IDs
        $tag_name_array = json_decode(base64_decode($prop_value_array["tag_array"]));
        $tag_array = array();
        foreach($tag_name_array as $tag_name){
            $tag_array[] = (int)ClipitTag::create(array("name" => $tag_name));
        }
        $prop_value_array["tag_array"] = (array)$tag_array;
        $id = parent::create($prop_value_array);
        ClipitRemoteSite::add_tricky_topics($remote_site_url, array($id));
        return $id;
    }

    /**
     * Adds Tags to a Tricky Topic, referenced by Id.
     *
     * @param int   $id        Id from the Tricky Topic to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_REMOTETRICKYTOPIC_TAG);
    }

    /**
     * Sets Tags to a Tricky Topic, referenced by Id.
     *
     * @param int   $id        Id from the Tricky Topic to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_REMOTETRICKYTOPIC_TAG);
    }

    /**
     * Remove Tags from a Tricky Topic.
     *
     * @param int   $id        Id from Tricky Topic to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Tricky Topic
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_REMOTETRICKYTOPIC_TAG);
    }

    /**
     * Get all Tags from a Tricky Topic
     *
     * @param int $id Id of the Tricky Topic to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_REMOTETRICKYTOPIC_TAG);
    }

    // FOR REST API CALLS (remote_site comes as an URL)

    /**
     * @param string $remote_site
     * @param int[] $remote_id_array
     * @return array
     */
    static function get_by_remote_id($remote_site, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $tricky_topic_array = static::get_all();
        $return_array = array();
        foreach($tricky_topic_array as $tricky_topic){
            if($tricky_topic->remote_site == $remote_site_id
                && array_search($tricky_topic->remote_id,  $remote_id_array) !== false){
                $return_array[] = $tricky_topic;
            }
        }
        return $return_array;
    }

    /**
     * @param string $remote_site
     * @param int[] $remote_id_array
     * @return bool
     */
    static function delete_by_remote_id($remote_site, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $tricky_topic_array = static::get_by_remote_id($remote_site_id, $remote_id_array);
        $delete_array = array();
        foreach($tricky_topic_array as $tricky_topic){
            $delete_array[] = $tricky_topic->id;
        }
        static::delete_by_id($delete_array);
        return true;
    }

    /**
     * @param string $remote_site
     * @param bool $remote_ids_only Only return remote IDs
     * @return array
     */
    static function get_from_site($remote_site, $remote_ids_only = false){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $tricky_topic_array = static::get_all();
        $return_array = array();
        foreach($tricky_topic_array as $tricky_topic){
            if((int)$tricky_topic->remote_site == $remote_site_id) {
                if($remote_ids_only) {
                    $return_array[] = $tricky_topic->remote_id;
                } else{
                    $return_array[] = $tricky_topic;
                }
            }
        }
        return $return_array;
    }

    /**
     * @param string $remote_site
     * @return bool
     */
    static function delete_all_from_site($remote_site){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $tricky_topic_array = static::get_from_site($remote_site_id);
        $delete_array = array();
        foreach($tricky_topic_array as $tricky_topic){
            if((int)$tricky_topic->remote_site == $remote_site_id){
                $delete_array[] = $tricky_topic->id;
            }
        }
        return static::delete_by_id($delete_array);
    }


}