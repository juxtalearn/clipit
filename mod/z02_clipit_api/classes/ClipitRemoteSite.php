<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 11/11/2014
 * Time: 13:09
 */

class ClipitRemoteSite extends UBItem{

    const SUBTYPE = "ClipitRemoteSite";

    // REMOTE SCOPE
    const REL_REMOTESITE_REMOTETRICKYTOPIC = "ClipitRemoteSite-ClipitRemoteTrickyTopic";
    const REL_REMOTESITE_REMOTEFILE = "ClipitRemoteSite-ClipitRemoteFile";
    const REL_REMOTESITE_REMOTEVIDEO = "ClipitRemoteSite-ClipitRemoteVideo";
    const REL_REMOTESITE_REMOTEACTIVITY = "ClipitRemoteSite-ClipitRemoteActivity";
    public $timezone = "";
    public $tricky_topic_array = array();
    public $activity_array = array();
    public $file_array = array();
    public $video_array = array();

    static function create($prop_value_array){
        // Base64 decode some properties which can contain special characters
        $prop_value_array["name"] = base64_decode($prop_value_array["name"]);
        $prop_value_array["description"] = base64_decode($prop_value_array["description"]);
        $prop_value_array["url"] = base64_decode($prop_value_array["url"]);
        return parent::create($prop_value_array);
    }

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->timezone = (string)$elgg_entity->get("timezone");
        $this->tricky_topic_array = (array)static::get_tricky_topics($this->id);
        $this->activity_array = (array)static::get_activities($this->id);
        $this->file_array = (array)static::get_files($this->id);
        $this->video_array = (array)static::get_videos($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("timezone", (array)$this->timezone);
    }

    /**
     * Saves Site parameters into Elgg
     * @return int Site ID
     */
    protected function save() {
        parent::save();
        static::set_tricky_topics($this->id, $this->tricky_topic_array);
        static::set_activities($this->id, $this->activity_array);
        static::set_files($this->id, $this->file_array);
        static::set_videos($this->id, $this->video_array);
        return $this->id;
    }

    /**
     * Sets values to specified properties of a RemoteSite
     *
     * @param int $id Id of User to set property values
     * @param array $prop_value_array Array of property=>value pairs to set into the RemoteSite
     *
     * @return int|bool Returns Id of User if correct, or false if error
     * @throws InvalidParameterException
     */
    static function set_properties($id, $prop_value_array) {
        $item = null;
        // If no ID specified, try loading remote site from URL
        if(empty($id) && array_key_exists("url", $prop_value_array)){
            $item = static::get_from_url($prop_value_array["url"]);
        }
        if(empty($item)){
            if (!$item = new static($id)) {
                return false;
            }
        }
        $property_list = (array)static::list_properties();

        foreach ($prop_value_array as $prop => $value) {
            if (!array_key_exists($prop, $property_list)) {
                throw new InvalidParameterException("ERROR: One or more property names do not exist.");
            }
            if ($prop == "id") {
                throw new InvalidParameterException("ERROR: Cannot modify 'id' of instance.");
            }
            $item->$prop = $value;
        }
        return $item->save();
    }

    /**
     * @param string $url
     * @param bool $id_only
     * @return static|null
     */
    static function get_from_url($url, $id_only = false){
        if($decoded_url = base64_decode($url)){
            $url = $decoded_url;
        }
        $remote_site_array = static::get_all();
        foreach($remote_site_array as $remote_site){
            if((string)$remote_site->url == $url){
                return $id_only ? (int)$remote_site->id : $remote_site;
            }
        }
        return null;
    }

    // REMOTE TRICKY TOPICS
    static function add_tricky_topics($id, $tricky_topic_array) {
        return UBCollection::add_items($id, $tricky_topic_array, static::REL_REMOTESITE_REMOTETRICKYTOPIC);
    }
    static function set_tricky_topics($id, $tricky_topic_array) {
        return UBCollection::set_items($id, $tricky_topic_array, static::REL_REMOTESITE_REMOTETRICKYTOPIC);
    }
    static function remove_tricky_topics($id, $tricky_topic_array) {
        return UBCollection::remove_items($id, $tricky_topic_array, static::REL_REMOTESITE_REMOTETRICKYTOPIC);
    }
    static function get_tricky_topics($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_REMOTETRICKYTOPIC);
    }

    // REMOTE ACTIVITIES
    static function add_activities($id, $activity_array) {
        return UBCollection::add_items($id, $activity_array, static::REL_REMOTESITE_REMOTEACTIVITY);
    }
    static function set_activities($id, $activity_array) {
        return UBCollection::set_items($id, $activity_array, static::REL_REMOTESITE_REMOTEACTIVITY);
    }
    static function remove_activities($id, $activity_array) {
        return UBCollection::remove_items($id, $activity_array, static::REL_REMOTESITE_REMOTEACTIVITY);
    }
    static function get_activities($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_REMOTEACTIVITY);
    }

    // REMOTE FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_REMOTESITE_REMOTEFILE);
    }
    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_REMOTESITE_REMOTEFILE);
    }
    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_REMOTESITE_REMOTEFILE);
    }
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_REMOTEFILE);
    }

    // REMOTE VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_REMOTESITE_REMOTEVIDEO);
    }
    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_REMOTESITE_REMOTEVIDEO);
    }
    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_REMOTESITE_REMOTEVIDEO);
    }
    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_REMOTEVIDEO);
    }
} 