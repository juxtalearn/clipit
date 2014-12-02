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
    const REL_REMOTESITE_STORYBOARD = "ClipitRemoteSite-ClipitStoryboard";
    const REL_REMOTESITE_RESOURCE = "ClipitRemoteSite-ClipitResource";
    public $file_array = array();
    public $video_array = array();
    public $storyboard_array = array();
    public $resource_array = array();

    /**
     * @param $url
     * @return static|null
     */
    static function get_from_url($url){
        $remote_site_array = static::get_all();
        foreach($remote_site_array as $remote_site){
            if((string)$remote_site->url == (string)$url){
                return $remote_site->id;
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
    // REMOTE STORYBOARDS
    static function add_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }
    static function set_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }
    static function remove_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }
    static function get_storyboards($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_STORYBOARD);
    }
    // REMOTE RESOURCES
    static function add_resources($id, $resource_array) {
        return UBCollection::add_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }
    static function set_resources($id, $resource_array) {
        return UBCollection::set_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }
    static function remove_resources($id, $resource_array) {
        return UBCollection::remove_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }
    static function get_resources($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_RESOURCE);
    }
} 