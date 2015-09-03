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

    // ClipIt Site Types
    const TYPE_SITE = "site";
    const TYPE_GLOBAL = "global";
    const TYPE_DEMO = "demo";

    // The SITE SCOPE and PUBLIC SCOPE below represent materials published publicly on the LOCAL SITE and/or the
    // PUBLIC GLOBAL SITE respectively. Only Tricky Topics and Videos are capable of being published.

    // SITE SCOPE (Public for users of the site)
    const REL_SITE_TRICKY_TOPIC = "ClipitSite-ClipitTrickyTopic";
    const REL_SITE_VIDEO = "ClipitSite-ClipitVideo";
    const REL_SITE_FILE = "ClipitSite-ClipitFile";
    public $tricky_topic_array = array();
    public $video_array = array();
    public $file_array = array();

    // PUBLIC SCOPE (Public for everyone on the Global ClipIt Site)
    const REL_SITE_PUB_TRICKYTOPIC = "ClipitSite-PUB-ClipitTrickyTopic";
    const REL_SITE_PUB_VIDEO = "ClipitSite-PUB-ClipitVideo";
    const REL_SITE_PUB_FILE = "ClipitSite-PUB-ClipitFile";
    public $pub_tricky_topic_array = array();
    public $pub_video_array = array();
    public $pub_file_array = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tricky_topic_array = (array)static::get_tricky_topics();
        $this->video_array = (array)static::get_videos();
        $this->file_array = (array)static::get_files();
        $this->pub_tricky_topic_array = (array)static::get_pub_tricky_topics();
        $this->pub_video_array = (array)static::get_pub_videos();
        $this->pub_file_array = (array)static::get_pub_files();
    }

    /**
     * Saves Site parameters into Elgg
     * @return int Site ID
     */
    protected function save() {
        $site_id = parent::save();
        static::set_tricky_topics($this->tricky_topic_array);
        static::set_videos($this->video_array);
        static::set_files($this->file_array);
        static::set_pub_tricky_topics($this->pub_tricky_topic_array);
        static::set_pub_videos($this->pub_video_array);
        static::set_pub_files($this->pub_file_array);
        return $site_id;
    }

    // SITE SCOPE //

    // SITE TRICKY TOPICS
    static function add_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $tricky_topic_array, static::REL_SITE_TRICKY_TOPIC);
    }

    static function set_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $tricky_topic_array, static::REL_SITE_TRICKY_TOPIC);
    }

    static function remove_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $tricky_topic_array, static::REL_SITE_TRICKY_TOPIC);
    }

    static function get_tricky_topics() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_TRICKY_TOPIC);
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

    // PUBLIC SCOPE //

    // PUBLIC TRICKY TOPICS
    static function add_pub_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $tricky_topic_array, static::REL_SITE_PUB_TRICKYTOPIC);
        return static::update_global_resources();
    }

    static function set_pub_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $tricky_topic_array, static::REL_SITE_PUB_TRICKYTOPIC);
        return static::update_global_resources();
    }

    static function remove_pub_tricky_topics($tricky_topic_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $tricky_topic_array, static::REL_SITE_PUB_TRICKYTOPIC);
        return static::update_global_resources();
    }

    static function get_pub_tricky_topics() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_TRICKYTOPIC);
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

    // ClipIt Global (to be called from SITE)

    static function global_site_call($data, $type = "GET"){
        $clipit_global_url = get_config("clipit_global_url");
        $clipit_global_user = get_config("clipit_global_login");
        $clipit_global_password = get_config("clipit_global_password");
        // Get authentication token
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
        // Make call
        $data += array("auth_token" => $auth_token);
        $params = array(
            'http'=> array(
                "method" => $type));
        $context = stream_context_create($params);
        $json_response = file_get_contents($clipit_global_url.'?'.http_build_query($data), false, $context);
        $response = json_decode($json_response);
        if($response->status != 0){
            return null;
        } else{
            return $response->result;
        }
    }

    static function publish_to_global(){
        $site = new static();
        $data = array("method" => "clipit.remote_site.create");
        $data += array("prop_value_array[name]" => base64_encode($site->name));
        $data += array("prop_value_array[description]" => base64_encode($site->description));
        $data += array("prop_value_array[url]" => base64_encode($site->url));
        $data += array("prop_value_array[timezone]" => (string)get_config("timezone"));
        if(static::global_site_call($data, "POST") == null){
            return null;
        }
        return static::update_global_resources();
    }

    static function update_global_resources(){
        // Get current remote resources for this site and current local public resources
        $data = array("method" => "clipit.remote_resource.get_from_site");
        $data += array("remote_site" => elgg_get_site_url());
        $data += array("remote_ids_only" => true);
        $remote_resources = static::global_site_call($data, "GET");
        $pub_tricky_topics = static::get_pub_tricky_topics();
        $pub_videos = static::get_pub_videos();
        $pub_files = static::get_pub_files();
        // Figure out what to add
        $add_array = array();
        foreach($pub_tricky_topics as $pub_tricky_topic_id){
            if(array_search($pub_tricky_topic_id, $remote_resources) === false){
                $add_array = array_merge($add_array, ClipitTrickyTopic::get_by_id(array($pub_tricky_topic_id)));
            }
        }
        foreach($pub_videos as $pub_video_id){
            if(array_search($pub_video_id, $remote_resources) === false){
                $add_array = array_merge($add_array, ClipitVideo::get_by_id(array($pub_video_id)));
            }
        }
        foreach($pub_files as $pub_file_id){
            if(array_search($pub_file_id, $remote_resources) === false){
                $add_array = array_merge($add_array, ClipitFile::get_by_id(array($pub_file_id)));
            }
        }
        foreach($add_array as $object) {
            $tag_name_array = array();
            $tag_array = ClipitTag::get_by_id($object->tag_array);
            foreach($tag_array as $tag){
                $tag_name_array[] = $tag->name;
            }
            $data = array("method" => "clipit.remote_resource.create");
            $data += array("prop_value_array[remote_site]" => base64_encode(elgg_get_site_url()));
            $data += array("prop_value_array[remote_id]" => $object->id);
            $data += array("prop_value_array[remote_type]" => $object::SUBTYPE);
            $data += array("prop_value_array[name]" => base64_encode($object->name));
            $data += array("prop_value_array[description]" => base64_encode($object->description));
            $data += array("prop_value_array[url]" => base64_encode($object->url));
            $data += array("prop_value_array[tag_array]" => base64_encode(json_encode($tag_name_array)));
            static::global_site_call($data, "POST");
        }
        // Figure out what to remove
        $remove_array = array();
        $all_pub_resources = array_merge($pub_tricky_topics, $pub_videos, $pub_files);
        foreach($remote_resources as $remote_resource_id){
            if(array_search($remote_resource_id, $all_pub_resources) === false){
                $remove_array[] = $remote_resource_id;
            }
        }
        $data = array("method" => "clipit.remote_resource.delete_by_remote_id");
        $data += array("remote_site" => elgg_get_site_url());
        foreach($remove_array as $remove_id){
            $data += array("remote_id_array[$remove_id]" => $remove_id);
        }
        static::global_site_call($data, "POST");
        return true;
    }
}