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
 * Contains the final product (video) of a group during an activity.
 */
class ClipitVideo extends UBItem {
    
    const SUBTYPE = "ClipitVideo";
    // Video relationships
    const REL_VIDEO_TAG = "ClipitVideo-ClipitTag";
    const REL_VIDEO_RUBRIC = "ClipitVideo-ClipitRubric";
    const REL_VIDEO_LABEL = "ClipitVideo-ClipitLabel";
    const REL_VIDEO_USER = "ClipitVideo-ClipitUser";
    // Video Container relationships
    const REL_EXAMPLE_VIDEO = ClipitExample::REL_EXAMPLE_VIDEO;
    const REL_GROUP_VIDEO = ClipitGroup::REL_GROUP_VIDEO;
    const REL_TASK_VIDEO = ClipitTask::REL_TASK_VIDEO;
    const REL_ACTIVITY_VIDEO = ClipitActivity::REL_ACTIVITY_VIDEO;
    const REL_TRICKYTOPIC_VIDEO = ClipitTrickyTopic::REL_TRICKYTOPIC_VIDEO;
    const REL_SITE_VIDEO = ClipitSite::REL_SITE_VIDEO;
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
    // Properties
    public $preview = "";
    public $duration = 0;
    public $overlay_metadata = "";
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
        $this->preview = (string)$elgg_entity->get("preview");
        $this->duration = (int)$elgg_entity->get("duration");
        $this->overlay_metadata = (string)$elgg_entity->get("overlay_metadata");
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
        if(!empty($this->url)){
            $video_metadata = static::video_url_parser($this->url);
            if(!empty($video_metadata)){
                $this->url = (string)$video_metadata["url"];
                $this->preview = (string)$video_metadata["preview"];
            }
        }
        $elgg_entity->set("url", (string)$this->url);
        $elgg_entity->set("preview", (string)$this->preview);
        $elgg_entity->set("duration", (int)$this->duration);
        $elgg_entity->set("overlay_metadata", (string)$this->overlay_metadata);
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
     * Add Read Array for a Video
     *
     * @param int $id ID of the Video
     * @param array $read_array Array of User IDs who have read the Video
     *
     * @return bool True if OK, false if error
     */
    static function add_read_array($id, $read_array) {
        return UBCollection::add_items($id, $read_array, static::REL_VIDEO_USER);
    }

    /**
     * Set Read Array for a Video
     *
     * @param int $id ID of the Video
     * @param array $read_array Array of User IDs who have read the Video
     *
     * @return bool True if OK, false if error
     */
    static function set_read_array($id, $read_array) {
        return UBCollection::set_items($id, $read_array, static::REL_VIDEO_USER);
    }

    /**
     * Remove Read Array for a Video
     *
     * @param int $id ID of the Video
     * @param array $read_array Array of User IDs who have read the Video
     *
     * @return bool True if OK, false if error
     */
    static function remove_read_array($id, $read_array) {
        return UBCollection::remove_items($id, $read_array, static::REL_VIDEO_USER);
    }

    /**
     * Get Read Array for a Video
     *
     * @param int $id ID of the Video
     *
     * @return static[] Array of Video IDs
     */
    static function get_read_array($id) {
        return UBCollection::get_items($id, static::REL_VIDEO_USER);
    }

    /**
     * Get a list of Users who have Read a Video, or optionally whether certain Users have read it
     *
     * @param int $id ID of the Video
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
     * Set the Read status for a Video
     *
     * @param int $id ID of Video
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     *
     * @return bool|int ID of Video if Ok, false if error
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
     * Get all Tags from a Video
     *
     * @param int $id Id of the Video to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id)
    {
        return UBCollection::get_items($id, static::REL_VIDEO_TAG);
    }

    /**
     * Adds Tags to a Video, referenced by Id.
     *
     * @param int $id Id from the Video to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Video
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array)
    {
        return UBCollection::add_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    /**
     * Remove Tags from a Video.
     *
     * @param int $id Id from Video to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Video
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array)
    {
        return UBCollection::remove_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    /**
    * Sets Tags to a Video, referenced by Id.
    *
    * @param int $id Id from the Video to set Tags to
    * @param array $tag_array Array of Tag Ids to be set to the Video
    *
    * @return bool Returns true if success, false if error
    */
    static function set_tags($id, $tag_array)
    {
        return UBCollection::set_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    static function get_by_tag($tag_array)
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

    static function get_by_tricky_topic($tt_array){
        $return_array = array();
        foreach($tt_array as $tt_id){
            $tt_tags = ClipitTrickyTopic::get_tags($tt_id);
            $return_array[$tt_id] = static::get_by_tag($tt_tags);
        }
        return $return_array;
    }

    /**
     * Get Label Ids from a Video.
     *
     * @param int $id Id of the Video to get Labels from.
     *
     * @return array|bool Returns array of Label Ids, or false if error.
     */
    static function get_labels($id)
    {
        return UBCollection::get_items($id, static::REL_VIDEO_LABEL);
    }

    /**
     * Add Labels to a Video.
     *
     * @param int $id Id of the Video to add Labels to.
     * @param array $label_array Array of Label Ids to add to the Video.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function add_labels($id, $label_array)
    {
        return UBCollection::add_items($id, $label_array, static::REL_VIDEO_LABEL);
    }

    /**
     * Remove Labels from a Video.
     *
     * @param int $id Id of the Video to remove Labels from.
     * @param array $label_array Array of Label Ids to remove from the Video.
     *
     * @return bool Returns true if removed correctly, or false if error.
     */
    static function remove_labels($id, $label_array)
    {
        return UBCollection::remove_items($id, $label_array, static::REL_VIDEO_LABEL);
    }

    /**
     * Set Labels to a Video.
     *
     * @param int $id Id of the Video to set Labels to.
     * @param array $label_array Array of Label Ids to set to the Video.
     *
     * @return bool Returns true if added correctly, or false if error.
     */
    static function set_labels($id, $label_array)
    {
        return UBCollection::set_items($id, $label_array, static::REL_VIDEO_LABEL);
    }

    static function get_by_label($label_array)
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

    static function get_rubric_items($id)
    {
        return UBCollection::get_items($id, static::REL_VIDEO_RUBRIC);
    }

    static function add_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::add_items($id, $rubric_item_array, static::REL_VIDEO_RUBRIC);
    }

    static function remove_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::remove_items($id, $rubric_item_array, static::REL_VIDEO_RUBRIC);
    }

    static function set_rubric_items($id, $rubric_item_array)
    {
        return UBCollection::set_items($id, $rubric_item_array, static::REL_VIDEO_RUBRIC);
    }

    static function get_by_rubric_item($rubric_item_array)
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
        $site_array = UBCollection::get_items($id, static::REL_SITE_VIDEO, true);
        if (!empty($site_array)) {
            return array_pop($site_array);
        }
        if ($recursive) {
            $clone_array = static::get_clones($id, true);
            foreach ($clone_array as $clone_id) {
                $site_array = UBCollection::get_items($clone_id, static::REL_SITE_VIDEO, true);
                if (!empty($site_array)) {
                    return array_pop($site_array);
                }
            }
        }
        return null;
    }

    static function get_example($id)
    {
        $example = UBCollection::get_items($id, static::REL_EXAMPLE_VIDEO, true);
        if (empty($example)) {
            return null;
        }
        return array_pop($example);
    }

    static function get_task($id)
    {
        $task = UBCollection::get_items($id, static::REL_TASK_VIDEO, true);
        if (empty($task)) {
            return null;
        }
        return array_pop($task);
    }

    /**
     * Get the Group where a Video is located
     *
     * @param int $id Video ID
     *
     * @return int|null Returns the Group ID, or null if none.
     */
    static function get_group($id) {
        $video = new static($id);
        if(!empty($video->cloned_from)) {
            return static::get_group($video->cloned_from);
        }
        $group = UBCollection::get_items($id, static::REL_GROUP_VIDEO, true);
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
            $activity = UBCollection::get_items($id, static::REL_ACTIVITY_VIDEO, true);
            if(empty($activity)) {
                return null;
            }
            return array_pop($activity);
        }
    }

    static function get_tricky_topic($id)
    {
        $activity_array = UBCollection::get_items($id, static::REL_TRICKYTOPIC_VIDEO, true);
        if (empty($activity_array)) {
            return null;
        }
        return array_pop($activity_array);
    }

    /**
     * Uploads to YouTube a video file from a local path in the server.
     *
     * @param string $local_video_path Local server path of the video
     * @param string $title Video title
     *
     * @return string YouTube video URL
     */
    static function upload_to_youtube($local_video_path, $title = "")
    {
        if (!get_config("google_refresh_token")) {
            return false;
        }
        set_include_path(
            get_include_path() . PATH_SEPARATOR . elgg_get_plugins_path() . "z02_clipit_api/libraries/google_api/src/"
        );
        $lib_path = elgg_get_plugins_path() . "z02_clipit_api/libraries/";
        require_once($lib_path . "google_api/src/Google/Client.php");
        require_once($lib_path . "google_api/src/Google/Service/YouTube.php");

        $client = new Google_Client();
        $client->setClientId(get_config("google_id"));
        $client->setClientSecret(get_config("google_secret"));
        try {
            $client->setAccessToken(get_config("google_token"));
        } catch (Exception $e) {
            error_log($e);
        }
        if ($client->isAccessTokenExpired()) {
            $refresh_token = get_config("google_refresh_token");
            $client->refreshToken($refresh_token);
        }
        if (!$client->getAccessToken()) {
            return null;
        }
        // Define an object that will be used to make all API requests.
        $youtube = new Google_Service_YouTube($client);
        // Create a snippet with title, description, tags and category ID
        // Create an asset resource and set its snippet metadata and type.
        // This example sets the video's title, description, keyword tags, and
        // video category.
        $snippet = new Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($title);
        // Numeric video category. See
        // https://developers.google.com/youtube/v3/docs/videoCategories/list
        $snippet->setCategoryId("28");
        // Set the video's status to "public". Valid statuses are "public",
        // "private" and "unlisted".
        $status = new Google_Service_YouTube_VideoStatus();
        $status->privacyStatus = "unlisted";
        // Associate the snippet and status objects with a new video resource.
        $video = new Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);
        // Specify the size of each chunk of data, in bytes. Set a higher value for
        // reliable connection as fewer chunks lead to faster uploads. Set a lower
        // value for better recovery on less reliable connections.
        $chunkSizeBytes = 1 * 1024 * 1024;
        // Setting the defer flag to true tells the client to return a request which can be called
        // with ->execute(); instead of making the API call immediately.
        $client->setDefer(true);
        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $youtube->videos->insert("status,snippet", $video);
        // Create a MediaFileUpload object for resumable uploads.
        $media = new Google_Http_MediaFileUpload($client, $insertRequest, 'video/*', null, true, $chunkSizeBytes);
        $media->setFileSize(filesize($local_video_path));
        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($local_video_path, "rb");
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        fclose($handle);
        // If you want to make other calls after the file upload, set setDefer back to false
        $client->setDefer(false);
        $_SESSION['token'] = $client->getAccessToken();
        set_config("google_token", $_SESSION['token']);
        return (string)"http://www.youtube.com/watch?v=" . $status['id'];
    }

    /**
     * @param $url
     * @return array|bool
     */
    static function video_url_parser($url)
    {
        if ($parse_url = parse_url($url)) {
            if (!isset($parts["scheme"])) {
                $url = "http://$url";
            }
        }
        if (!isset($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $video_patterns = array('#(((http://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i'
        , '#(((http://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i'
        , '/(http:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/'
        , '/(http:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/'
        , '/(https:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/');
        $favicon_url_base = "http://www.google.com/s2/favicons?domain=";

        $output = array();
        foreach ($video_patterns as $video_pattern) {
            if (preg_match($video_pattern, $url) > 0) {
                // Youtube
                if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
                    $output = array(
                        'id' => $matches[0],
                        'url' => 'http://www.youtube.com/watch?v=' . $matches[0],
                        'preview' => "http://i1.ytimg.com/vi/{$matches[0]}/mqdefault.jpg",
                        'favicon' => $favicon_url_base . $parse_url['host']
                    );
                    // Vimeo
                } else if (strpos($url, 'vimeo.com') != false) {
                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
                    $data = file_get_contents("http://vimeo.com/api/v2/video/$matches[0].json");
                    $data = array_pop(json_decode($data));
                    $output = array(
                        'id' => $matches[0],
                        'url' => "http://vimeo.com/{$matches[0]}",
                        'preview' => $data->thumbnail_large,
                        'favicon' => $favicon_url_base . $parse_url['host']
                    );
                }
            }
        }
        if (!$output['id']) {
            return false;
        }
        // Video Data output
        return $output;
    }

}