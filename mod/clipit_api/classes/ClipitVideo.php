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
 * Class ClipitVideo
 *
 */
class ClipitVideo extends UBItem{
    /**
     * @const string Elgg entity sybtype for this class
     */
    const SUBTYPE = "clipit_video";
    const REL_VIDEO_COMMENT = "video-comment";
    const REL_VIDEO_TAG = "video-tag";

    public $tag_array = array();
    public $comment_array = array();
    public $preview = "";
    public $duration = 0;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->comment_array = static::get_comments($this->id);
        $this->tag_array = static::get_tags($this->id);
        $this->preview = (string)$elgg_object->preview;
        $this->duration = (int)$elgg_object->duration;
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->preview = (string)$this->preview;
        $elgg_object->duration = (int)$this->duration;
    }

    protected function save(){
        parent::save();
        static::set_comments($this->id, $this->comment_array);
        static::set_tags($this->id, $this->tag_array);
        return $this->id;
    }

    protected function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        // Delete comments hanging from the video to be deleted
        $comment_array = array();
        foreach($rel_array as $rel){
            if($rel->relationship == static::REL_VIDEO_COMMENT){
                $comment_array[] = $rel->guid_two;
            }
        }
        if(!empty($comment_array)){
            ClipitComment::delete_by_id($comment_array);
        }
        parent::delete();
    }



    /**
     * Adds Comments to a Video, referenced by Id.
     *
     * @param int   $id Id from the Video to add Comments to
     * @param array $comment_array Array of Comment Ids to be added to the Video
     *
     * @return bool Returns true if success, false if error
     */
    static function add_comments($id, $comment_array){
        return UBCollection::add_items($id, $comment_array, static::REL_VIDEO_COMMENT);
    }

    /**
     * Sets Comments to a Video, referenced by Id.
     *
     * @param int   $id Id from the Video to set Comments to
     * @param array $comment_array Array of Comment Ids to be set to the Video
     *
     * @return bool Returns true if success, false if error
     */
    static function set_comments($id, $comment_array){
        return UBCollection::set_items($id, $comment_array, static::REL_VIDEO_COMMENT);
    }

    /**
     * Remove Comments from a Video.
     *
     * @param int   $id Id from Video to remove Comments from
     * @param array $comment_array Array of Comment Ids to remove from Video
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_comments($id, $comment_array){
        return UBCollection::remove_items($id, $comment_array, static::REL_VIDEO_COMMENT);
    }

    /**
     * Get all Comments for a Video
     *
     * @param int $id Id of the Video to get Comments from
     *
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        return UBCollection::get_items($id, static::REL_VIDEO_COMMENT);
    }

    /**
     * Adds Tags to a Video, referenced by Id.
     *
     * @param int   $id Id from the Video to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the Video
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array){
        return UBCollection::add_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    /**
     * Sets Tags to a Video, referenced by Id.
     *
     * @param int   $id Id from the Video to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the Video
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array){
        return UBCollection::set_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    /**
     * Remove Tags from a Video.
     *
     * @param int   $id Id from Video to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from Video
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array){
        return UBCollection::remove_items($id, $tag_array, static::REL_VIDEO_TAG);
    }

    /**
     * Get all Tags from a Video
     *
     * @param int $id Id of the Video to get Tags from
     *
     * @return array|bool Returns an array of Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, static::REL_VIDEO_TAG);
    }

}