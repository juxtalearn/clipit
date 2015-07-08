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
 * An class which holds properties for Remote Resource objects.
 */
class ClipitRemoteResource extends UBItem {

    const SUBTYPE = "ClipitRemoteResource";
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
        $remote_site = ClipitRemoteSite::get_from_url($prop_value_array["remote_site"]);
        $prop_value_array["remote_site"] = (int)$remote_site->id;
        // convert tag_array from array of names to array of local IDs
        $tag_name_array = json_decode(base64_decode($prop_value_array["tag_array"]));
        $tag_array = array();
        foreach($tag_name_array as $tag_name){
            $tag_array[] = (int)ClipitTag::create(array("name" => $tag_name));
        }
        $prop_value_array["tag_array"] = (array)$tag_array;
        $id = parent::create($prop_value_array);
        switch($prop_value_array["remote_type"]){
            case ClipitFile::SUBTYPE:
                ClipitRemoteSite::add_files($remote_site->id, array($id));
                break;
            case ClipitVideo::SUBTYPE:
                ClipitRemoteSite::add_videos($remote_site->id, array($id));
                break;
        }
        return $id;
    }

    static function get_from_remote_type($remote_type){
        $remote_resource_array = static::get_all();
        $return_array = array();
        foreach($remote_resource_array as $remote_resource){
            if($remote_resource->remote_type == $remote_type){
                $return_array[] = $remote_resource;
            }
        }
        return $return_array;
    }

    static function get_by_remote_id($remote_site_id, $remote_id_array){
        $remote_resources = ClipitRemoteResource::get_all();
        $remote_resource_array = array();
        foreach($remote_resources as $remote_resource){
            if($remote_resource->remote_site == $remote_site_id && array_search($remote_resource->remote_id,  $remote_id_array) !== false){
                $remote_resource_array[] = $remote_resource;
            }
        }
        return $remote_resource_array;
    }

    static function delete_by_remote_id($remote_site, $remote_id_array){
        $remote_site = ClipitRemoteSite::get_from_url($remote_site);
        $remote_resource_array = static::get_by_remote_id($remote_site->id, $remote_id_array);
        $remote_resource_id_array = array();
        foreach($remote_resource_array as $resource){
            $remote_resource_id_array[] = $resource->id;
        }
        static::delete_by_id($remote_resource_id_array);
        return true;
    }

    static function get_from_site($remote_site, $remote_ids_only = false){
        $remote_site = ClipitRemoteSite::get_from_url($remote_site);
        $resource_array = static::get_all();
        $return_array = array();
        foreach($resource_array as $resource){
            if((int)$resource->remote_site == (int)$remote_site->id) {
                if($remote_ids_only) {
                    $return_array[] = $resource->remote_id;
                } else{
                    $return_array[] = $resource;
                }
            }
        }
        return $return_array;
    }

    static function delete_from_site($remote_site){
        $remote_site = ClipitRemoteSite::get_from_url($remote_site);
        $resource_array = static::get_all();
        $delete_array = array();
        foreach($resource_array as $resource){
            if((int)$resource->remote_site == (int)$remote_site->id){
                $delete_array[] = $resource->id;
            }
        }
        return static::delete_by_id($delete_array);
    }
}