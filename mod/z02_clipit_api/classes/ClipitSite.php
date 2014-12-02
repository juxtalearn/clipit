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
        return static::update_global_resources();
    }

    static function set_pub_files($file_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $file_array, static::REL_SITE_PUB_FILE);
        return static::update_global_resources();
    }

    static function remove_pub_files($file_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $file_array, static::REL_SITE_PUB_FILE);
        return static::update_global_resources();
    }

    static function get_pub_files() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_FILE);
    }

    // PUBLIC VIDEOS
    static function add_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        return static::update_global_resources();
    }

    static function set_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        return static::update_global_resources();
    }

    static function remove_pub_videos($video_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $video_array, static::REL_SITE_PUB_VIDEO);
        return static::update_global_resources();
    }

    static function get_pub_videos() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_VIDEO);
    }

    // PUBLIC STORYBOARDS
    static function add_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        return static::update_global_resources();
    }

    static function set_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        return static::update_global_resources();
    }

    static function remove_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $storyboard_array, static::REL_SITE_PUB_STORYBOARD);
        return static::update_global_resources();
    }

    static function get_pub_storyboards() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_STORYBOARD);
    }

    // PUBLIC RESOURCES
    static function add_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        return static::update_global_resources();
    }

    static function set_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        return static::update_global_resources();
    }

    static function remove_pub_resources($resource_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $resource_array, static::REL_SITE_PUB_RESOURCE);
        return static::update_global_resources();
    }

    static function get_pub_resources() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_RESOURCE);
    }

    // ClipIt Global (to be called from SITE)

    static function global_site_call($data, $type = "POST"){
        $clipit_global_url = get_config("clipit_global_url");
        $clipit_global_user = get_config("clipit_global_login");
        $clipit_global_password = get_config("clipit_global_password");
        // Authentication token
        $params = array(
            "method" => "clipit.site.get_token",
            "login" => $clipit_global_user,
            "password" => $clipit_global_password,
        );
        $response = file_get_contents($clipit_global_url.'?'.http_build_query($params));
        $decoded_response = json_decode($response);
        if($decoded_response->status != 0){
            return null;
        }
        $auth_token = $decoded_response->result;
        // Final call
        $data += array("auth_token" => $auth_token);
        $params = array(
            'http'=> array(
                "method" => $type));
        $context = stream_context_create($params);
        return file_get_contents($clipit_global_url.'?'.http_build_query($data), false, $context);
    }

    static function publish_to_global(){
        $site = new static();
        $data = array("method" => "clipit.remote_site.create");
        $data += array("prop_value_array[name]" => $site->name);
        $data += array("prop_value_array[description]" => $site->description);
        $data += array("prop_value_array[url]" => $site->url);
        static::global_site_call($data, "POST");
        static::update_global_resources();
    }

    static function update_global_resources(){
        $data = array("method" => "clipit.remote_resource.delete_from_site");
        $data += array("remote_site" => elgg_get_site_url());
        static::global_site_call($data, "POST");
        $pub_resource_array = array();
        $pub_resource_array += ClipitVideo::get_by_id(static::get_pub_videos());
        $pub_resource_array += ClipitStoryboard::get_by_id(static::get_pub_storyboards());
        $pub_resource_array += ClipitFile::get_by_id(static::get_pub_files());
        $pub_resource_array += ClipitResource::get_by_id(static::get_pub_resources());
        foreach($pub_resource_array as $resource_object) {
            $data = array("method" => "clipit.remote_resource.create");
            $data += array("prop_value_array[remote_site]" => elgg_get_site_url());
            $data += array("prop_value_array[remote_id]" => $resource_object->id);
            $data += array("prop_value_array[remote_type]" => $resource_object::SUBTYPE);
            $data += array("prop_value_array[name]" => $resource_object->name);
            $data += array("prop_value_array[description]" => $resource_object->description);
            $data += array("prop_value_array[url]" => $resource_object->url);
            var_dump($data); die;
            static::global_site_call($data, "POST");
        }
        return true;
    }
}