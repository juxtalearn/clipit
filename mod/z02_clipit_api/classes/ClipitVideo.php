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
class ClipitVideo extends ClipitResource{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitVideo";
    const REL_RESOURCE_TAG = "ClipitVideo-ClipitTag";
    const REL_RESOURCE_LABEL = "ClipitVideo-ClipitLabel";
    const REL_RESOURCE_PERFORMANCE = "ClipitVideo-ClipitPerformance";
    const REL_EXAMPLE_RESOURCE = ClipitExample::REL_EXAMPLE_VIDEO;
    const REL_GROUP_RESOURCE = ClipitGroup::REL_GROUP_VIDEO;
    const REL_TASK_RESOURCE = ClipitTask::REL_TASK_VIDEO;
    const REL_ACTIVITY_RESOURCE = ClipitActivity::REL_ACTIVITY_VIDEO;
    const REL_TRICKYTOPIC_RESOURCE = ClipitTrickyTopic::REL_TRICKYTOPIC_VIDEO;
    const REL_SITE_RESOURCE = ClipitSite::REL_SITE_VIDEO;
    public $preview = "";
    public $duration = 0;
    public $overlay_metadata = "";

    /**
     * Uploads to YouTube a video file from a local path in the server.
     *
     * @param string $local_video_path Local server path of the video
     * @param string $title Video title
     *
     * @return string YouTube video URL
     */
    static function upload_to_youtube($local_video_path, $title)
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
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity)
    {
        parent::copy_from_elgg($elgg_entity);
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
        if (empty($this->preview)) {
            $video_metadata = static::video_url_parser($this->url);
            $this->preview = (string)$video_metadata["preview"];
        }
        $elgg_entity->set("preview", (string)$this->preview);
        $elgg_entity->set("duration", (int)$this->duration);
        $elgg_entity->set("overlay_metadata", (string)$this->overlay_metadata);
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