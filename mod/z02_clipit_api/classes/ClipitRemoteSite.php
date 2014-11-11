<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 11/11/2014
 * Time: 13:09
 */

class ClipitRemoteSite extends UBItem{
    // PUBLIC SCOPE
    const REL_REMOTESITE_FILE = "ClipitRemoteSite-ClipitFile";
    const REL_REMOTESITE_VIDEO = "ClipitRemoteSite-ClipitVideo";
    const REL_REMOTESITE_STORYBOARD = "ClipitRemoteSite-ClipitStoryboard";
    const REL_REMOTESITE_RESOURCE = "ClipitRemoteSite-ClipitResource";
    public $file_array = array();
    public $video_array = array();
    public $storyboard_array = array();
    public $resource_array = array();

    // FILES
    static function add_pub_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }

    static function set_pub_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }

    static function remove_pub_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_REMOTESITE_FILE);
    }

    static function get_pub_files($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_FILE);
    }

    // PUBLIC VIDEOS
    static function add_pub_videos($id, $video_array) {
        return UBCollection::add_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }

    static function set_pub_videos($id, $video_array) {
        return UBCollection::set_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }

    static function remove_pub_videos($id, $video_array) {
        return UBCollection::remove_items($id, $video_array, static::REL_REMOTESITE_VIDEO);
    }

    static function get_pub_videos($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_VIDEO);
    }

    // PUBLIC STORYBOARDS
    static function add_pub_storyboards($id, $storyboard_array) {
        return UBCollection::add_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }

    static function set_pub_storyboards($id, $storyboard_array) {
        return UBCollection::set_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }

    static function remove_pub_storyboards($id, $storyboard_array) {
        return UBCollection::remove_items($id, $storyboard_array, static::REL_REMOTESITE_STORYBOARD);
    }

    static function get_pub_storyboards($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_STORYBOARD);
    }

    // PUBLIC RESOURCES
    static function add_pub_resources($id, $resource_array) {
        return UBCollection::add_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }

    static function set_pub_resources($id, $resource_array) {
        return UBCollection::set_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }

    static function remove_pub_resources($id, $resource_array) {
        return UBCollection::remove_items($id, $resource_array, static::REL_REMOTESITE_RESOURCE);
    }

    static function get_pub_resources($id) {
        return UBCollection::get_items($id, static::REL_REMOTESITE_RESOURCE);
    }
} 