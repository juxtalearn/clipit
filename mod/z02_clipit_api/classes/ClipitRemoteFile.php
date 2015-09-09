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
 * An class which holds properties for Remote File objects.
 */
class ClipitRemoteFile extends UBItem {

    const SUBTYPE = "ClipitRemoteFile";
    const REL_REMOTEFILE_TAG = "ClipitRemoteFile-ClipitTag";
    public $remote_id;
    public $remote_site = 0;
    public $gdrive_id = "";
    public $tag_array = array();


    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->remote_id = (int)$elgg_entity->get("remote_id");
        $this->remote_site = (int)$elgg_entity->get("remote_site");
        $this->gdrive_id = (string)$elgg_entity->get("gdrive_id");
        $this->tag_array = (array)static::get_tags($this->id);
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
        $elgg_entity->set("gdrive_id", (string)$this->gdrive_id);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false)
    {
        parent::save($double_save);
        static::set_tags($this->id, (array)$this->tag_array);
        return $this->id;
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
        $prop_value_array["gdrive_id"] = base64_decode($prop_value_array["gdrive_id"]);
        $id = parent::create($prop_value_array);
        ClipitRemoteSite::add_files($remote_site_id, array($id));
        return $id;
    }

    /**
     * Adds Tags to a File, referenced by Id.
     *
     * @param int   $id        Id from the File to add Tags to
     * @param array $tag_array Array of Tag Ids to be added to the File
     *
     * @return bool Returns true if success, false if error
     */
    static function add_tags($id, $tag_array) {
        return UBCollection::add_items($id, $tag_array, static::REL_REMOTEFILE_TAG);
    }

    /**
     * Sets Tags to a File, referenced by Id.
     *
     * @param int   $id        Id from the File to set Tags to
     * @param array $tag_array Array of Tag Ids to be set to the File
     *
     * @return bool Returns true if success, false if error
     */
    static function set_tags($id, $tag_array) {
        return UBCollection::set_items($id, $tag_array, static::REL_REMOTEFILE_TAG);
    }

    /**
     * Remove Tags from a File.
     *
     * @param int   $id        Id from File to remove Tags from
     * @param array $tag_array Array of Tag Ids to remove from File
     *
     * @return bool Returns true if success, false if error
     */
    static function remove_tags($id, $tag_array) {
        return UBCollection::remove_items($id, $tag_array, static::REL_REMOTEFILE_TAG);
    }

    /**
     * Get all Tags from a File
     *
     * @param int $id Id of the File to get Tags from
     *
     * @return array|bool Returns an array of Tag IDs, or false if error
     */
    static function get_tags($id) {
        return UBCollection::get_items($id, static::REL_REMOTEFILE_TAG);
    }


    static function get_by_tags($tag_array){
        $file_array = static::get_all();
        $return_array = array();
        foreach($file_array as $file){
            $intersection = array_intersect($file->tag_array, $tag_array);
            if(!empty($intersection)){
                $return_array[] = $file;
            }
        }
        return $return_array;
    }

    // FOR REST API CALLS (remote_site comes as an URL)

    static function get_by_remote_id($remote_site, $remote_id_array){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $remote_files = ClipitRemoteFile::get_all();
        $remote_file_array = array();
        foreach($remote_files as $remote_file){
            if($remote_file->remote_site == $remote_site_id && in_array($remote_file->remote_id,  $remote_id_array)){
                $remote_file_array[] = $remote_file;
            }
        }
        return $remote_file_array;
    }

    static function delete_by_remote_id($remote_site, $remote_id_array){
        $remote_file_array = static::get_by_remote_id($remote_site, $remote_id_array);
        $remote_file_id_array = array();
        foreach($remote_file_array as $file){
            $remote_file_id_array[] = $file->id;
        }
        return static::delete_by_id($remote_file_id_array);
    }

    static function get_from_site($remote_site, $remote_ids_only = false){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $file_array = static::get_all();
        $return_array = array();
        foreach($file_array as $file){
            if((int)$file->remote_site == $remote_site_id) {
                if($remote_ids_only) {
                    $return_array[] = $file->remote_id;
                } else{
                    $return_array[] = $file;
                }
            }
        }
        return $return_array;
    }

    static function delete_from_site($remote_site){
        $remote_site_id = ClipitRemoteSite::get_from_url(base64_decode($remote_site), true);
        $file_array = static::get_all();
        $delete_array = array();
        foreach($file_array as $file){
            if((int)$file->remote_site == $remote_site_id){
                $delete_array[] = $file->id;
            }
        }
        return static::delete_by_id($delete_array);
    }
}