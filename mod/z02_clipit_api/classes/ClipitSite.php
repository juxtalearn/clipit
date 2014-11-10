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
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
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
    const REL_PUB_FILE = "ClipitSite-ClipitFile";
    const REL_PUB_VIDEO = "ClipitSite-ClipitVideo";
    const REL_PUB_STORYBOARD = "ClipitSite-ClipitStoryboard";
    const REL_PUB_RESOURCE = "ClipitSite-ClipitResource";
    public $pub_file_array = array();
    public $pub_video_array = array();
    public $pub_storyboard_array = array();
    public $pub_resource_array = array();

    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->file_array = (array)static::get_files();
        $this->video_array = (array)static::get_videos();
        $this->storyboard_array = (array)static::get_storyboards();
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
        return UBCollection::add_items($id, $file_array, static::REL_PUB_FILE);
    }

    static function set_pub_files($file_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $file_array, static::REL_PUB_FILE);
    }

    static function remove_pub_files($file_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $file_array, static::REL_PUB_FILE);
    }

    static function get_pub_files() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_PUB_FILE);
    }

    // PUBLIC VIDEOS
    static function add_pub_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $video_array, static::REL_PUB_VIDEO);
    }

    static function set_pub_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $video_array, static::REL_PUB_VIDEO);
    }

    static function remove_pub_videos($video_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $video_array, static::REL_PUB_VIDEO);
    }

    static function get_pub_videos() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_PUB_VIDEO);
    }

    // PUBLIC STORYBOARDS
    static function add_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $storyboard_array, static::REL_PUB_STORYBOARD);
    }

    static function set_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $storyboard_array, static::REL_PUB_STORYBOARD);
    }

    static function remove_pub_storyboards($storyboard_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $storyboard_array, static::REL_PUB_STORYBOARD);
    }

    static function get_pub_storyboards() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_PUB_STORYBOARD);
    }

    // PUBLIC RESOURCES
    static function add_pub_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::add_items($id, $resource_array, static::REL_PUB_RESOURCE);
    }

    static function set_pub_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::set_items($id, $resource_array, static::REL_PUB_RESOURCE);
    }

    static function remove_pub_resources($resource_array) {
        $id = static::get_site_id();
        return UBCollection::remove_items($id, $resource_array, static::REL_PUB_RESOURCE);
    }

    static function get_pub_resources() {
        $id = static::get_site_id();
        return UBCollection::get_items($id, static::REL_PUB_RESOURCE);
    }
}