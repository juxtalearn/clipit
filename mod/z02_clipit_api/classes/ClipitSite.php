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
 * The Site class, which is unique (only one instance) and holds general Site information and Site-layer Resources.
 */
class ClipitSite extends UBSite {

    const SUBTYPE = "ClipitSite";

    // SITE SCOPE
    const REL_SITE_FILE = "ClipitSite-ClipitFile";
    const REL_SITE_VIDEO = "ClipitSite-ClipitVideo";
    const REL_SITE_STORYBOARD = "ClipitSite-ClipitStoryboard";
    const REL_SITE_RESOURCE = "ClipitSite-ClipitResource";
    public $file_array = array();
    public $video_array = array();
    public $storyboard_array = array();
    public $resource_array = array();

    // PUBLIC SCOPE
    const REL_SITE_PUB_FILE = "ClipitSite-PUB-ClipitFile";
    const REL_SITE_PUB_VIDEO = "ClipitSite-PUB-ClipitVideo";
    const REL_SITE_PUB_STORYBOARD = "ClipitSite-PUB-ClipitStoryboard";
    const REL_SITE_PUB_RESOURCE = "ClipitSite-PUB-ClipitResource";
    public $pub_file_array = array();
    public $pub_video_array = array();
    public $pub_storyboard_array = array();
    public $pub_resource_array = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->file_array = (array)static::get_files();
        $this->video_array = (array)static::get_videos();
        $this->storyboard_array = (array)static::get_storyboards();
        $this->resource_array = (array)static::get_resources();
        $this->pub_file_array = (array)static::get_pub_files();
        $this->pub_video_array = (array)static::get_pub_videos();
        $this->pub_storyboard_array = (array)static::get_pub_storyboards();
        $this->pub_resource_array = (array)static::get_pub_resources();
    }

    /**
     * Saves Site parameters into Elgg
     * @return int Site ID
     */
    protected function save() {
        $site_id = parent::save();
        static::set_files($this->file_array);
        static::set_videos($this->video_array);
        static::set_storyboards($this->storyboard_array);
        static::set_resources($this->resource_array);
        static::set_pub_files($this->pub_file_array);
        static::set_pub_videos($this->pub_video_array);
        static::set_pub_storyboards($this->pub_storyboard_array);
        static::set_pub_resources($this->pub_resource_array);
        return $site_id;
    }

    // SITE SCOPE //

    // SITE FILES
    static function add_files($file_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $file_array, static::REL_SITE_FILE);
    }

    static function set_files($file_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $file_array, static::REL_SITE_FILE);
    }

    static function remove_files($file_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $file_array, static::REL_SITE_FILE);
    }

    static function get_files() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_FILE);
    }

    // SITE VIDEOS
    static function add_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $video_array, static::REL_SITE_VIDEO);
    }

    static function set_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $video_array, static::REL_SITE_VIDEO);
    }

    static function remove_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $video_array, static::REL_SITE_VIDEO);
    }

    static function get_videos() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_VIDEO);
    }

    // SITE STORYBOARDS
    static function add_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $storyboard_array, static::REL_SITE_STORYBOARD);
    }

    static function set_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $storyboard_array, static::REL_SITE_STORYBOARD);
    }

    static function remove_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $storyboard_array, static::REL_SITE_STORYBOARD);
    }

    static function get_storyboards() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_STORYBOARD);
    }

    // SITE RESOURCES
    static function add_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $resource_array, static::REL_SITE_RESOURCE);
    }

    static function set_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $resource_array, static::REL_SITE_RESOURCE);
    }

    static function remove_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $resource_array, static::REL_SITE_RESOURCE);
    }

    static function get_resources() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_RESOURCE);
    }

    // PUBLIC SCOPE //

    // PUBLIC FILES
    static function add_pub_files($file_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $file_array, static::REL_SITE_PUB_FILE);
        $file_object_array = ClipitFile::get_by_id($file_array);
        static::add_global_resources($file_object_array);
        return $id;
    }

    static function set_pub_files($file_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $file_array, static::REL_SITE_PUB_FILE);
        $file_object_array = ClipitFile::get_by_id($file_array);
        static::set_global_resources(ClipitFile::SUBTYPE, $file_object_array);
        return $id;
    }

    static function remove_pub_files($file_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $file_array, static::REL_SITE_PUB_FILE);
        static::remove_global_resources($file_array);
        return $id;
    }

    static function get_pub_files() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_FILE);
    }

    // PUBLIC VIDEOS
    static function add_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        if(get_config("clipit_global")) {
            $video_object_array = ClipitVideo::get_by_id($video_array);
            static::add_global_resources($video_object_array);
        }
        return $id;
    }

    static function set_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        if(get_config("clipit_global")) {
            $video_object_array = ClipitVideo::get_by_id($video_array);
            static::set_global_resources(ClipitVideo::SUBTYPE, $video_object_array);
        }
        return $id;
    }

    static function remove_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        if(get_config("clipit_global")) {
            static::remove_global_resources($video_array);
        }
        return $id;
    }

    static function get_pub_videos() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_VIDEO);
    }

    // PUBLIC STORYBOARDS
    static function add_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        if(get_config("clipit_global")) {
            $storyboard_object_array = ClipitStoryboard::get_by_id($storyboard_array);
            static::add_global_resources($storyboard_object_array);
        }
        return $id;
    }

    static function set_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        if(get_config("clipit_global")) {
            $storyboard_object_array = ClipitStoryboard::get_by_id($storyboard_array);
            static::set_global_resources(ClipitStoryboard::SUBTYPE, $storyboard_object_array);
        }
        return $id;
    }

    static function remove_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        if(get_config("clipit_global")) {
            static::remove_global_resources($storyboard_array);
        }
        return $id;
    }

    static function get_pub_storyboards() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_STORYBOARD);
    }

    // PUBLIC RESOURCES
    static function add_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        if(get_config("clipit_global")) {
            $resource_object_array = ClipitResource::get_by_id($resource_array);
            static::add_global_resources($resource_object_array);
        }
        return $id;
    }

    static function set_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        if(get_config("clipit_global")) {
            $resource_object_array = ClipitResource::get_by_id($resource_array);
            static::set_global_resources(ClipitResource::SUBTYPE, $resource_object_array);
        }
        return $id;
    }

    static function remove_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        if(get_config("clipit_global")) {
            static::remove_global_resources($resource_array);
        }
        return $id;
    }

    static function get_pub_resources() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_RESOURCE);
    }

    // ClipIt Global (to be called from SITE)

    static function rest_api_call($url, $data, $type = "POST"){
        $params = array(
            'http'=> array(
                "method" => $type,
                "content" => $data));
        $context = stream_context_create($params);
        return file_get_contents($url, false, $context);
    }

    static function publish_to_global(){
        $clipit_global_url = get_config("clipit_global");
        $site = new static();
        $data = array("method" => "clipit.remote_site.create");
        $data += array("name" => $site->name);
        $data += array("description" => $site->description);
        $data += array("url" => $site->url);
        static::rest_api_call($clipit_global_url, $data, "POST");
    }

    static function add_global_resources($resource_object_array){
        $clipit_global_url = get_config("clipit_global");
        $data = array("method" => "clipit.remote_resource.create");
        foreach($resource_object_array as $resource) {
            $data += array("remote_id" => $resource->id);
            $data += array("remote_type" => $resource::SUBTYPE);
            $data += array("name" => $resource->name);
            $data += array("description" => $resource->description);
            $data += array("url" => $resource->url);
            $data += array("remote_site" => elgg_get_site_url());
            static::rest_api_call($clipit_global_url, $data, "POST");
        }
        return true;
    }

    static function remove_global_resources($resource_array){
        $clipit_global_url = get_config("clipit_global");
        $data = array("method" => "clipit.remote_resource.delete_by_remote_id");
        foreach($resource_array as $resource_id){
            $data += array("remote_id_array[]" => $resource_id);
        }
        static::rest_api_call($clipit_global_url, $data, "POST");
        return true;
    }

    static function set_global_resources($resource_type, $resource_object_array){
        $clipit_global_url = get_config("clipit_global");
        $data = array("method" => "clipit.remote_resource.delete_by_remote_type");
        $data += array("remote_type_array[]" => $resource_type);
        static::rest_api_call($clipit_global_url, $data, "POST");
        static::add_global_resources($resource_object_array);
    }
}