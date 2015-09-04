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
 * An class which holds properties for Remote Video objects.
 */
class ClipitRemoteVideo extends UBItem {
    const SUBTYPE = "ClipitRemoteVideo";
    public $remote_id;
    public $remote_type = "";
    public $remote_site = 0;
    public $tag_array = array();
    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->remote_id = (int)$elgg_entity->get("remote_id");
        $this->remote_type = (string)$elgg_entity->get("remote_type");
        $this->remote_site = (int)$elgg_entity->get("remote_site");
        $this->tag_array = (array)$elgg_entity->get("tag_array");
    }
    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("remote_id", (int)$this->remote_id);
        $elgg_entity->set("remote_type", (string)$this->remote_type);
        $elgg_entity->set("remote_site", (int)$this->remote_site);
        $elgg_entity->set("tag_array", (array)$this->tag_array);
    }
    static function create($prop_value_array){
        // convert "remote_site" from string to local ID
        $remote_site_url = base64_decode($prop_value_array["remote_site"]);
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site_url, true);
        $prop_value_array["remote_site"] = $remote_site_id;
        // Base64 decode some properties which can contain special characters
        $prop_value_array["name"] = base64_decode($prop_value_array["name"]);
        $prop_value_array["description"] = base64_decode($prop_value_array["description"]);
        $prop_value_array["url"] = base64_decode($prop_value_array["url"]);
        // convert tag_array from array of names to array of local IDs
        $tag_name_array = json_decode(base64_decode($prop_value_array["tag_array"]));
        $tag_array = array();
        foreach($tag_name_array as $tag_name){
            $tag_array[] = (int)ClipitTag::create(array("name" => $tag_name));
        }
        $prop_value_array["tag_array"] = (array)$tag_array;
        $id = parent::create($prop_value_array);
        ClipitRemoteSite::add_videos($remote_site_id, array($id));
        return $id;
    }
    static function get_from_remote_type($remote_type){
        $remote_video_array = static::get_all();
        $return_array = array();
        foreach($remote_video_array as $remote_video){
            if($remote_video->remote_type == $remote_type){
                $return_array[] = $remote_video;
            }
        }
        return $return_array;
    }
    static function get_by_tags($tag_array){
        $video_array = static::get_all();
        $return_array = array();
        foreach($video_array as $video){
            $intersection = array_intersect($video->tag_array, $tag_array);
            if(!empty($intersection)){
                $return_array[] = $video;
            }
        }
        return $return_array;
    }
    // FOR REST API CALLS (remote_site comes as an URL)
    static function get_by_remote_id($remote_site_id, $remote_id_array){
        $remote_videos = ClipitRemoteVideo::get_all();
        $remote_video_array = array();
        foreach($remote_videos as $remote_video){
            if($remote_video->remote_site == $remote_site_id && array_search($remote_video->remote_id,  $remote_id_array) !== false){
                $remote_video_array[] = $remote_video;
            }
        }
        return $remote_video_array;
    }
    static function delete_by_remote_id($remote_site, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site, true);
        $remote_video_array = static::get_by_remote_id($remote_site_id, $remote_id_array);
        $remote_video_id_array = array();
        foreach($remote_video_array as $video){
            $remote_video_id_array[] = $video->id;
        }
        static::delete_by_id($remote_video_id_array);
        return true;
    }
    static function get_from_site($remote_site, $remote_ids_only = false){
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site, true);
        $video_array = static::get_all();
        $return_array = array();
        foreach($video_array as $video){
            if((int)$video->remote_site == $remote_site_id) {
                if($remote_ids_only) {
                    $return_array[] = $video->remote_id;
                } else{
                    $return_array[] = $video;
                }
            }
        }
        return $return_array;
    }
    static function delete_from_site($remote_site){
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site, true);
        $video_array = static::get_all();
        $delete_array = array();
        foreach($video_array as $video){
            if((int)$video->remote_site == $remote_site_id){
                $delete_array[] = $video->id;
            }
        }
        return static::delete_by_id($delete_array);
    }
}