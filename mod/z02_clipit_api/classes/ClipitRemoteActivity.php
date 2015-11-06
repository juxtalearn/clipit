<?php
/**
 * Clipit - Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      clipit_api
 */

/**
 * An class which holds properties for Remote Activities.
 */
class ClipitRemoteActivity extends UBItem {

    const SUBTYPE = "ClipitRemoteActivity";
    const REL_REMOTEACTIVITY_REMOTETRICKYTOPIC = "ClipitRemoteActivity-ClipitRemoteTrickyTopic";
    public $remote_id;
    public $remote_site = 0;
    public $remote_tricky_topic = "";
    public $color = "";

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->remote_id = (int)$elgg_entity->get("remote_id");
        $this->remote_site = (int)$elgg_entity->get("remote_site");
        $this->remote_tricky_topic = (string)$elgg_entity->get("remote_tricky_topic");
        $this->color = (string)$elgg_entity->get("color");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("remote_id", (int)$this->remote_id);
        $elgg_entity->set("remote_site", (int)$this->remote_site);
        $elgg_entity->set("remote_tricky_topic", (string)$this->remote_tricky_topic);
        $elgg_entity->set("color", (string)$this->color);
    }

    static function create($prop_value_array){
        // convert "remote_site" from string to local ID
        $remote_site_url = base64_decode($prop_value_array["remote_site"]);
        $remote_site_id = ClipitRemoteSite::get_from_url($remote_site_url, true);
        $prop_value_array["remote_site"] = $remote_site_id;
        // Base64 decode some properties which can contain special characters
        $prop_value_array["name"] = base64_decode($prop_value_array["name"]);
        $prop_value_array["description"] = base64_decode($prop_value_array["description"]);
        $id = parent::create($prop_value_array);
        ClipitRemoteSite::add_activities($remote_site_id, array($id));
        return $id;
    }

    // FOR REST API CALLS (remote_site comes as URL string)

    /**
     * @param string $remote_site
     * @param int[] $remote_id_array
     * @return array
     */
    static function get_by_remote_id($remote_site, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $activity_array = static::get_all();
        $return_array = array();
        foreach($activity_array as $activity){
            if($activity->remote_site == $remote_site_id
                && in_array($activity->remote_id,  $remote_id_array)){
                $return_array[] = $activity;
            }
        }
        return $return_array;
    }

    /**
     * @param string $remote_site
     * @param int[] $remote_id_array
     * @return bool
     */
    static function delete_by_remote_id($remote_site, $remote_id_array){
        $activity_array = static::get_by_remote_id($remote_site, $remote_id_array);
        $delete_array = array();
        foreach($activity_array as $activity){
            $delete_array[] = $activity->id;
        }
        return static::delete_by_id($delete_array);
    }

    /**
     * @param string $remote_site
     * @param bool $remote_ids_only Only return remote IDs
     * @return array
     */
    static function get_from_site($remote_site, $remote_ids_only = false){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $activity_array = static::get_all();
        $return_array = array();
        foreach($activity_array as $activity){
            if((int)$activity->remote_site == $remote_site_id) {
                if($remote_ids_only) {
                    $return_array[] = $activity->remote_id;
                } else{
                    $return_array[] = $activity;
                }
            }
        }
        return $return_array;
    }

    /**
     * @param string $remote_site
     * @return bool
     */
    static function delete_all_from_site($remote_site){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $activity_array = static::get_from_site($remote_site_id);
        $delete_array = array();
        foreach($activity_array as $activity){
            if((int)$activity->remote_site == $remote_site_id){
                $delete_array[] = $activity->id;
            }
        }
        return static::delete_by_id($delete_array);
    }
}