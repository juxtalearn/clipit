<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 11/11/2014
 * Time: 13:09
 */

class ClipitRemoteSite extends UBItem{
    // REMOTE SCOPE
    const REL_REMOTESITE_FILE = "ClipitRemoteSite-ClipitFile";
    const REL_REMOTESITE_VIDEO = "ClipitRemoteSite-ClipitVideo";
    public $timezone = "";
    public $file_array = array();
    public $video_array = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->timezone = (string)$elgg_entity->get("timezone");
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
     * @param $url
     * @return static|null
     */
    static function get_from_url($url){
        $remote_site_array = static::get_all();
        foreach($remote_site_array as $remote_site){
            if((string)$remote_site->url == (string)$url){
                return $remote_site;
            }
        }
        return null;
    }

    // REMOTE FILES
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }
    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }
    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_FILE);
    }
    // REMOTE VIDEOS
    static function add_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }
    static function set_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }
    static function remove_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }
    static function get_videos($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_VIDEO);
    }
} 