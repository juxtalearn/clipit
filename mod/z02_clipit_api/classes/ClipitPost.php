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

class ClipitPost extends UBMessage{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitPost";

    const REL_MESSAGE_DESTINATION = "post-destination";
    const REL_MESSAGE_FILE = "post-file";

    const REL_POST_STORYBOARD = "post-storyboard";
    const REL_POST_VIDEO = "post-video";

    public $topic_id = 0;
    public $storyboard_array = array();
    public $video_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        $this->topic_id = (int)$elgg_entity->get("topic_id");
        $this->storyboard_array = (array)static::get_storyboards((int)$this->id);
        $this->video_array = (array)static::get_videos((int)$this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("topic_id", $this->topic_id);
    }

    /**
     * Saves this instance into the system.
     *
     * @return bool|int Returns id of saved instance, or false if error.
     */
    protected function save(){
        parent::save();
        static::set_storyboards($this->id, $this->storyboard_array);
        static::set_videos($this->id, $this->video_array);
        return $this->id;
    }

    // STORYBOARDS
    static function add_storyboards($id, $storyboard_array){
        return UBCollection::add_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function set_storyboards($id, $storyboard_array){
        return UBCollection::set_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function remove_storyboards($id, $storyboard_array){
        return UBCollection::remove_items($id, $storyboard_array, static::REL_POST_STORYBOARD);
    }

    static function get_storyboards($id){
        return UBCollection::get_items($id, static::REL_POST_STORYBOARD);
    }

    // VIDEOS
    static function add_videos($id, $video_array){
        return UBCollection::add_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function set_videos($id, $video_array){
        return UBCollection::set_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function remove_videos($id, $video_array){
        return UBCollection::remove_items($id, $video_array, static::REL_POST_VIDEO);
    }

    static function get_videos($id){
        return UBCollection::get_items($id, static::REL_POST_VIDEO);
    }

} 