<?php
/**
 * @package clipit\quiz
 */
namespace clipit\video;
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

use clipit\comment\ClipitComment;
use clipit\taxonomy\tag\ClipitTaxonomyTag;

/**
 * Lists the properties contained in this class.
 *
 * @return array Array of properties whith type and default value
 */
function list_properties(){
    return ClipitVideo::listProperties();
}

/**
 * Get the values for the specified properties of a Video.
 *
 * @param int $id Id from Video
 * @param array $prop_array Array of property names to get values from
 * @return array|bool Returns array of [property => value] pairs, or false if error.
 * If a property does not exist, the returned array will show null as that propertie's value.
 */
function get_properties($id, $prop_array){
    $video = new ClipitVideo($id);
    if(!$video){
        return false;
    }
    return $video->getProperties($prop_array);
}

/**
 * Set values to specified properties of a Video.
 *
 * @param int $id Id from Video
 * @param array $prop_value_array Array of properties => values to set
 * @return bool Returns true if success, false if error
 */
function set_properties($id, $prop_value_array){
    $video = new ClipitVideo($id);
    if(!$video){
        return false;
    }
    return $video->setProperties($prop_value_array);
}

/**
 * Create a new ClipitVideo instance, and save it into the system.
 *
 * @param string $name Name of the Video
 * @param string $description Description of the Video
 * @param array $comment_array List of comments which target the Video
 * @param int $content File Id which holds the video file content
 * @param array $taxonomy_tag_array List of Taxonomy Tags related to the Video
 * @return bool|int Returns the new Video Id, or false if error
 */
function create($name,
                $description = "",
                $comment_array = array(),
                $content = -1,
                $taxonomy_tag_array = array()){
    $prop_value_array["name"] = $name;
    $prop_value_array["description"] = $description;
    $prop_value_array["comment_array"] = $comment_array;
    $prop_value_array["content"] = $content;
    $prop_value_array["taxonomy_tag_array"] = $taxonomy_tag_array;
    $video = new ClipitVideo();
    return $video->setProperties($prop_value_array);
}

/**
 * Delete a Video from the system.
 *
 * @param int $id If from the Video to delete
 * @return bool True if success, false if error
 */
function delete($id){
    if(!$video = new ClipitVideo($id)){
        return false;
    }
    return $video->delete();
}

/**
 * Get all Videos from the system.
 *
 * @param int $limit Number of results to show, default= 0 [no limit] (optional)
 * @return array Returns an array of ClipitVideo objects
 */
function get_all($limit = 0){
    return ClipitVideo::getAll($limit);
}

/**
 * Get Videos with id contained in a given list.
 *
 * @param array $id_array Array of Video Ids
 * @return array Returns an array of ClipitQuiz objects
 */
function get_by_id($id_array){
    return ClipitVideo::getById($id_array);
}

/**
 * Adds Comments to a Video, referenced by Id.
 *
 * @param int $id Id from the Video to add Comments to
 * @param array $comment_array Array of Comment Ids to be added to the Video
 * @return bool Returns true if success, false if error
 */
function add_comments($id, $comment_array){
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
function remove_comments($id, $comment_array){
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
function get_comments($id){
    if(!$video = new ClipitVideo($id)){
        return false;
    }
    $comment_array = array();
    foreach($video->comment_array as $comment_id){
        if(!$comment = new ClipitComment($comment_id)){
            $comment_array[] = null;
        }else{
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
function add_taxonomy_tags($id, $taxonomy_tag_array){
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
function remove_taxonomy_tags($id, $taxonomy_tag_array){
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
function get_taxonomy_tags($id){
    if(!$video = new ClipitVideo($id)){
        return false;
    }
    $taxonomy_tag_array = array();
    foreach($video->taxonomy_tag_array as $taxonomy_tag_id){
        if(!$taxonomy_tag = new ClipitTaxonomyTag($taxonomy_tag_id)){
            $taxonomy_tag_array[] = null;
        }else{
            $taxonomy_tag_array[] = $taxonomy_tag;
        }
    }
    return $taxonomy_tag_array;
}