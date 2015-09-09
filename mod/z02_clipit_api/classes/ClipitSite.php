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
    const REL_SITE_PUB_ACTIVITY = "ClipitSite-PUB-ClipitActivity";
    public $pub_tricky_topic_array = array();
    public $pub_activity_array = array();
    public $pub_video_array = array();
    public $pub_file_array = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->tricky_topic_array = (array)static::get_tricky_topics();
        $this->video_array = (array)static::get_videos();
        $this->file_array = (array)static::get_files();
        $this->pub_tricky_topic_array = (array)static::get_pub_tricky_topics();
        $this->pub_activity_array = (array)static::get_pub_activities();
        $this->pub_video_array = (array)static::get_pub_videos();
        $this->pub_file_array = (array)static::get_pub_files();
    }

    /**
     * Saves the Site to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false) {
        $site_id = parent::save($double_save);
        static::set_tricky_topics($this->tricky_topic_array);
        static::set_videos($this->video_array);
        static::set_files($this->file_array);
        static::set_pub_tricky_topics($this->pub_tricky_topic_array);
        static::set_pub_activities($this->pub_activity_array);
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

    // PUBLIC ACTIVITIES
    static function add_pub_activities($activity_array) {
        $id = static::get_site_id();
        UBCollection::add_items($id, $activity_array, static::REL_SITE_PUB_ACTIVITY);
        return static::update_global_resources();
    }

    static function set_pub_activities($activity_array) {
        $id = static::get_site_id();
        UBCollection::set_items($id, $activity_array, static::REL_SITE_PUB_ACTIVITY);
        return static::update_global_resources();
    }

    static function remove_pub_activities($activity_array) {
        $id = static::get_site_id();
        UBCollection::remove_items($id, $activity_array, static::REL_SITE_PUB_ACTIVITY);
        return static::update_global_resources();
    }

    static function get_pub_activities() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_SITE_PUB_ACTIVITY);
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
        // GET current remote resources for this site on global site
        $data = array("method" => "");
        $data += array("remote_site" => base64_encode(elgg_get_site_url()));
        $data += array("remote_ids_only" => true);
        // REMOTE TRICKY TOPICS
        $data["method"] = "clipit.remote_tricky_topic.get_from_site";
        $remote_tricky_topics = static::global_site_call($data, "GET");
        // REMOTE ACTIVITIES
        $data["method"] = "clipit.remote_activity.get_from_site";
        $remote_activities = static::global_site_call($data, "GET");
        // REMOTE VIDEOS
        $data["method"] = "clipit.remote_video.get_from_site";
        $remote_videos = static::global_site_call($data, "GET");
        // REMOTE FILES
        $data["method"] = "clipit.remote_file.get_from_site";
        $remote_files = static::global_site_call($data, "GET");
        // LOCAL public resources
        $pub_tricky_topics = static::get_pub_tricky_topics();
        // public activities are only sent to global if the site allows registration
        $allow_registration = (bool)get_config("allow_registration");
        if($allow_registration){
            $pub_activities = static::get_pub_activities();
        } else{
            $pub_activities = array();
        }
        $pub_videos = static::get_pub_videos();
        $pub_files = static::get_pub_files();

        // ADD new content to Global
        // NEW TRICKY TOPICS
        foreach($pub_tricky_topics as $pub_tricky_topic_id){
            if(in_array($pub_tricky_topic_id, $remote_tricky_topics)){
                $tricky_topic_array = ClipitTrickyTopic::get_by_id(array($pub_tricky_topic_id));
                $tricky_topic = array_pop($tricky_topic_array);
                $tag_name_array = array();
                $tag_array = ClipitTag::get_by_id($tricky_topic->tag_array);
                foreach($tag_array as $tag){
                    $tag_name_array[] = $tag->name;
                }
                $data = array("method" => "clipit.remote_tricky_topic.create");
                $data += array("prop_value_array[remote_site]" => base64_encode(elgg_get_site_url()));
                $data += array("prop_value_array[remote_id]" => $tricky_topic->id);
                $data += array("prop_value_array[name]" => base64_encode($tricky_topic->name));
                $data += array("prop_value_array[description]" => base64_encode($tricky_topic->description));
                $data += array("prop_value_array[tag_array]" => base64_encode(json_encode($tag_name_array)));
                static::global_site_call($data, "POST");
            }
        }
        // NEW ACTIVITIES
        foreach($pub_activities as $pub_activity_id){
            if(in_array($pub_activity_id, $remote_activities)){
                $activity = array_pop(ClipitActivity::get_by_id(array($pub_activity_id)));
                $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
                $data = array("method" => "clipit.remote_activity.create");
                $data += array("prop_value_array[remote_site]" => base64_encode(elgg_get_site_url()));
                $data += array("prop_value_array[remote_id]" => $activity->id);
                $data += array("prop_value_array[name]" => base64_encode($activity->name));
                $data += array("prop_value_array[description]" => base64_encode($activity->description));
                $data += array("prop_value_array[remote_tricky_topic]" => $tricky_topic->id);
                $data += array("prop_value_array[color]" => $activity->color);
                static::global_site_call($data, "POST");
            }
        }
        // NEW VIDEOS
        foreach($pub_videos as $pub_video_id){
            if(in_array($pub_video_id, $remote_videos)){
                $video_array = ClipitVideo::get_by_id(array($pub_video_id));
                $video = array_pop($video_array);
                $tag_name_array = array();
                $tag_array = ClipitTag::get_by_id($video->tag_array);
                foreach($tag_array as $tag){
                    $tag_name_array[] = $tag->name;
                }
                $data = array("method" => "clipit.remote_video.create");
                $data += array("prop_value_array[remote_site]" => base64_encode(elgg_get_site_url()));
                $data += array("prop_value_array[remote_id]" => $video->id);
                $data += array("prop_value_array[name]" => base64_encode($video->name));
                $data += array("prop_value_array[description]" => base64_encode($video->description));
                $data += array("prop_value_array[url]" => base64_encode($video->url));
                $data += array("prop_value_array[tag_array]" => base64_encode(json_encode($tag_name_array)));
                static::global_site_call($data, "POST");
            }
        }
        // NEW FILES
        foreach($pub_files as $pub_file_id){
            if(in_array($pub_file_id, $remote_files)){
                $file = array_pop(ClipitFile::get_by_id(array($pub_file_id)));
                $tag_name_array = array();
                $tag_array = ClipitTag::get_by_id($file->tag_array);
                foreach($tag_array as $tag){
                    $tag_name_array[] = $tag->name;
                }
                $data = array("method" => "clipit.remote_file.create");
                $data += array("prop_value_array[remote_site]" => base64_encode(elgg_get_site_url()));
                $data += array("prop_value_array[remote_id]" => $file->id);
                $data += array("prop_value_array[name]" => base64_encode($file->name));
                $data += array("prop_value_array[description]" => base64_encode($file->description));
                $data += array("prop_value_array[url]" => base64_encode($file->url));
                $data += array("prop_value_array[tag_array]" => base64_encode(json_encode($tag_name_array)));
                $data += array("prop_value_array[gdrive_id]" => base64_encode($file->gdrive_id));
                static::global_site_call($data, "POST");
            }
        }

        // REMOVE content no longer public on local site
        // OLD TRICKY TOPICS
        $remove_array = array();
        foreach($remote_tricky_topics as $remote_tricky_topic_id){
            if(in_array($remote_tricky_topic_id, $pub_tricky_topics)){
                $remove_array[] = $remote_tricky_topic_id;
            }
        }
        if(!empty($remove_array)) {
            $data = array("method" => "clipit.remote_tricky_topic.delete_by_remote_id");
            $data += array("remote_site" => base64_encode(elgg_get_site_url()));
            foreach ($remove_array as $remove_id) {
                $data += array("remote_id_array[]" => $remove_id);
            }
            static::global_site_call($data, "POST");
        }
        //OLD ACTIVITIES
        $remove_array = array();
        foreach($remote_activities as $remote_activity_id){
            if(in_array($remote_activity_id, $pub_activities)){
                $remove_array[] = $remote_activity_id;
            }
        }
        if(!empty($remove_array)) {
            $data = array("method" => "clipit.remote_activity.delete_by_remote_id");
            $data += array("remote_site" => base64_encode(elgg_get_site_url()));
            foreach ($remove_array as $remove_id) {
                $data += array("remote_id_array[]" => $remove_id);
            }
            static::global_site_call($data, "POST");
        }
        // OLD VIDEOS
        $remove_array = array();
        foreach($remote_videos as $remote_video_id){
            if(in_array($remote_video_id, $pub_videos)){
                $remove_array[] = $remote_video_id;
            }
        }
        if(!empty($remove_array)) {
            $data = array("method" => "clipit.remote_video.delete_by_remote_id");
            $data += array("remote_site" => base64_encode(elgg_get_site_url()));
            foreach ($remove_array as $remove_id) {
                $data += array("remote_id_array[]" => $remove_id);
            }
            static::global_site_call($data, "POST");
        }
        // OLD FILES
        $remove_array = array();
        foreach($remote_files as $remote_file_id){
            if(in_array($remote_file_id, $pub_files)){
                $remove_array[] = $remote_file_id;
            }
        }
        if(!empty($remove_array)) {
            $data = array("method" => "clipit.remote_video.delete_by_remote_id");
            $data += array("remote_site" => base64_encode(elgg_get_site_url()));
            foreach ($remove_array as $remove_id) {
                $data += array("remote_id_array[]" => $remove_id);
            }
            static::global_site_call($data, "POST");
        }
        return true;
    }
}