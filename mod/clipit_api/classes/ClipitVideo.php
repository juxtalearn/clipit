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
    /**
     * @var string Link to where the video is hosted (Youtube, Vimeo...)
     */
    public $url = "";

    /**
     * Loads a ClipitVideo instance from the system.
     *
     * @param ElggObject $elgg_object Video to load
     *
     */
    protected function _load($elgg_object){
        parent::_load($elgg_object);
        $this->url = (string)$elgg_object->url;
    }

    /**
     * Saves this instance to the system
     *
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)static::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->url = (string)$this->url;
        $elgg_object->access_id = ACCESS_PUBLIC;
        $elgg_object->save();
        $this->owner_id = (int)$elgg_object->owner_guid;
        $this->time_created = (int)$elgg_object->time_created;
        return $this->id = $elgg_object->guid;
    }

    function delete(){
        $rel_array = get_entity_relationships((int)$this->id);
        foreach($rel_array as $rel){
            switch($rel->relationship){
                case ClipitVideo::REL_VIDEO_COMMENT:
                    $comment_array[] = $rel->guid_two;
                    break;
                case ClipitVideo::REL_VIDEO_TAG:
                    $tag_array[] = $rel->guid_two;
                    break;
            }
        }
        if(isset($comment_array)){
            ClipitComment::delete_by_id($comment_array);
        }
        if(isset($tag_array)){
            ClipitTag::delete_by_id($tag_array);
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
        return UBCollection::add_items($id, $comment_array, ClipitVideo::REL_VIDEO_COMMENT);
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
        return UBCollection::remove_items($id, $comment_array, ClipitVideo::REL_VIDEO_COMMENT);
    }

    /**
     * Get all Comments for a Video
     *
     * @param int $id Id of the Video to get Comments from
     *
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        return UBCollection::get_items($id, ClipitVideo::REL_VIDEO_COMMENT);
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
        return UBCollection::add_items($id, $tag_array, ClipitVideo::REL_VIDEO_TAG);
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
        return UBCollection::remove_items($id, $tag_array, ClipitVideo::REL_VIDEO_TAG);
    }

    /**
     * Get all Tags from a Video
     *
     * @param int $id Id of the Video to get Tags from
     *
     * @return array|bool Returns an array of Tag items, or false if error
     */
    static function get_tags($id){
        return UBCollection::get_items($id, ClipitVideo::REL_VIDEO_TAG);
    }

}