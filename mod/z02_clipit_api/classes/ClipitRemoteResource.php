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

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->remote_id = (array)$elgg_entity->get("remote_id");
        $this->remote_type = (array)$elgg_entity->get("remote_type");
        $this->remote_site = (int)$elgg_entity->get("remote_site");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("remote_id", (array)$this->remote_id);
        $elgg_entity->set("remote_type", (array)$this->remote_type);
        $elgg_entity->set("remote_site", (int)ClipitRemoteSite::get_from_url($this->remote_site)->id);
    }

    static function create($prop_value_array){
        var_dump($prop_value_array["remote_site"]);

        $remote_site = ClipitRemoteSite::get_from_url($prop_value_array["remote_site"]);
        $prop_value_array["remote_site"] = (int)$remote_site;
        $id = parent::create($prop_value_array);
        switch($prop_value_array["remote_type"]){
            case ClipitFile::SUBTYPE:
                ClipitRemoteSite::add_files($remote_site->id, array($id));
                break;
            case ClipitVideo::SUBTYPE:
                ClipitRemoteSite::add_videos($remote_site->id, array($id));
                break;
            case ClipitStoryboard::SUBTYPE:
                ClipitRemoteSite::add_storyboards($remote_site->id, array($id));
                break;
            case ClipitResource::SUBTYPE:
                ClipitRemoteSite::add_resources($remote_site->id, array($id));
                break;
        }
        return $id;
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

    static function delete_by_remote_id($remote_site_url, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site_url);
        $remote_resource_array = static::get_by_remote_id($remote_site_id, $remote_id_array);
        foreach($remote_id_array as $remote_id){
            static::delete_by_id($remote_resource_array[$remote_id]);
        }
        return true;
    }

    static function delete_from_site($remote_site_url){
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site_url);
        $resource_array = static::get_all();
        foreach($resource_array as $resource){
            if((int)$resource->remote_site == (int)$remote_site_id){
                $delete_array[] = $resource->id;
            }
        }
        return static::delete_by_id($delete_array);
    }
}