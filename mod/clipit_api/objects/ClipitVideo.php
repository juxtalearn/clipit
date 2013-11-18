<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 *
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
namespace clipit;

use \ElggObject;
use \pebs\PebsItem;

/**
 * Class ClipitVideo
 *
 * @package clipit
 */
class ClipitVideo extends PebsItem{
    /**
     * @const string Elgg entity sybtype for this class
     */
    const SUBTYPE = "clipit_video";
    /**
     * @var array List of ClipitComment Ids targeting this Video
     */
    public $comment_array = array();
    /**
     * @var string Link to where the video is hosted
     */
    public $link = "";
    /**
     * @var array List of Taxonomy Tags applied to this Video
     */
    public $taxonomy_tag_array = array();
    /**
     * @var int Timestamp when the Video was submitted
     */
    public $time_created = -1;

    /**
     * Loads a ClipitVideo instance from the system.
     *
     * @param int $id Id of Video to load
     * @return $this|null Returns Video instance, or null if error
     */
    protected function _load($id){
        if(!$elgg_object = new ElggObject((int)$id)){
            return null;
        }
        $elgg_type = $elgg_object->type;
        $elgg_subtype = get_subtype_from_id($elgg_object->subtype);
        if(($elgg_type != $this::TYPE) || ($elgg_subtype != $this::SUBTYPE)){
            return null;
        }
        $this->id = (int)$elgg_object->guid;
        $this->name = (string)$elgg_object->name;
        $this->description = $elgg_object->description;
        $this->comment_array = (array)$elgg_object->comment_array;
        $this->link = (int)$elgg_object->link;
        $this->taxonomy_tag_array = (array)$elgg_object->taconomy_tag_array;
        $this->time_created = (int)$elgg_object->time_created;
        return $this;
    }

    /**
     * Saves this instance to the system
     *
     * @return bool|int Resurns the Id of the saved instance, or false if error
     */
    function save(){
        if($this->id == -1){
            $elgg_object = new ElggObject();
            $elgg_object->subtype = (string)$this::SUBTYPE;
        } elseif(!$elgg_object = new ElggObject($this->id)){
            return false;
        }
        $elgg_object->name = (string)$this->name;
        $elgg_object->description = (string)$this->description;
        $elgg_object->comment_array = (array)$this->comment_array;
        $elgg_object->link = (int)$this->link;
        $elgg_object->taxonomy_tag_array = (array)$this->taxonomy_tag_array;
        $elgg_object->save();
        return $this->id = $elgg_object->guid;
    }

    /**
     * Create a new ClipitVideo instance, and save it into the system.
     *
     * @param string $name Name of the Video
     * @param string $description Description of the Video
     * @param array $comment_array List of comments which target the Video
     * @param string $link Link to where the video is hosted
     * @param array $taxonomy_tag_array List of Taxonomy Tags related to the Video
     * @return bool|int Returns the new Video Id, or false if error
     */
    static function create($name,
                           $description = "",
                           $comment_array = array(),
                           $link = "",
                           $taxonomy_tag_array = array()){
        $prop_value_array["name"] = $name;
        $prop_value_array["description"] = $description;
        $prop_value_array["comment_array"] = $comment_array;
        $prop_value_array["link"] = $link;
        $prop_value_array["taxonomy_tag_array"] = $taxonomy_tag_array;
        $video = new ClipitVideo();
        return $video->setProperties($prop_value_array);
    }

    /**
     * Adds Comments to a Video, referenced by Id.
     *
     * @param int $id Id from the Video to add Comments to
     * @param array $comment_array Array of Comment Ids to be added to the Video
     * @return bool Returns true if success, false if error
     */
    static function add_comments($id, $comment_array){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        if(!$video->comment_array){
            $video->comment_array = $comment_array;
        } else{
            $video->comment_array = array_merge($video->comment_array, $comment_array);
        }
        if(!$video->save()){
            return false;
        }
        return true;
    }

    /**
     * Remove Comments from a Video.
     *
     * @param int $id Id from Video to remove Comments from
     * @param array $comment_array Array of Comment Ids to remove from Video
     * @return bool Returns true if success, false if error
     */
    static function remove_comments($id, $comment_array){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        if(!$video->comment_array){
            return false;
        }
        foreach($comment_array as $comment_id){
            $key = array_search($comment_id, $video->comment_array);
            if(isset($key)){
                unset($video->comment_array[$key]);
            } else{
                return false;
            }
        }
        if(!$video->save()){
            return false;
        }
        return true;
    }

    /**
     * Get all Comments for a Video
     *
     * @param int $id Id of the Video to get Comments from
     * @return array|bool Returns an array of ClipitComment items, or false if error
     */
    static function get_comments($id){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        $comment_array = array();
        foreach($video->comment_array as $comment_id){
            if(!$comment = new ClipitComment($comment_id)){
                $comment_array[] = null;
            } else{
                $comment_array[] = $comment;
            }
        }
        return $comment_array;
    }

    /**
     * Adds Taxonomy Tags to a Video, referenced by Id.
     *
     * @param int $id Id from the Video to add Taxonomy Tags to
     * @param array $taxonomy_tag_array Array of Taxonomy Tag Ids to be added to the Video
     * @return bool Returns true if success, false if error
     */
    static function add_taxonomy_tags($id, $taxonomy_tag_array){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        if(!$video->taxonomy_tag_array){
            $video->taxonomy_tag_array = $taxonomy_tag_array;
        } else{
            $video->taxonomy_tag_array = array_merge($video->taxonomy_tag_array, $taxonomy_tag_array);
        }
        if(!$video->save()){
            return false;
        }
        return true;
    }

    /**
     * Remove Taxonomy Tags from a Video.
     *
     * @param int $id Id from Video to remove Taxonomy Tags from
     * @param array $taxonomy_tag_array Array of Taxonomy Tag Ids to remove from Video
     * @return bool Returns true if success, false if error
     */
    static function remove_taxonomy_tags($id, $taxonomy_tag_array){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        if(!$video->taxonomy_tag_array){
            return false;
        }
        foreach($taxonomy_tag_array as $taxonomy_tag_id){
            $key = array_search($taxonomy_tag_id, $video->taxonomy_tag_array);
            if(isset($key)){
                unset($video->taxonomy_tag_array[$key]);
            } else{
                return false;
            }
        }
        if(!$video->save()){
            return false;
        }
        return true;
    }

    /**
     * Get all Taxonomy Tags from a Video
     *
     * @param int $id Id of the Video to get Taxonomy Tags from
     * @return array|bool Returns an array of Taxonomy Tag items, or false if error
     */
    static function get_taxonomy_tags($id){
        if(!$video = new ClipitVideo($id)){
            return false;
        }
        $taxonomy_tag_array = array();
        foreach($video->taxonomy_tag_array as $taxonomy_tag_id){
            if(!$taxonomy_tag = new ClipitTaxonomyTag($taxonomy_tag_id)){
                $taxonomy_tag_array[] = null;
            } else{
                $taxonomy_tag_array[] = $taxonomy_tag;
            }
        }
        return $taxonomy_tag_array;
    }

}