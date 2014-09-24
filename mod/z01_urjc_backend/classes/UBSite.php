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
 * @subpackage      urjc_backend
 */

/**
 * <Class Description>
 */
class UBSite {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "UBSite";
    public $id = 0;
    public $name = "";
    public $description = "";
    public $url = "";
    public $owner_id = 0;
    public $time_created = 0;

    /**
     * Constructor
     * @throws APIException
     */
    function __construct() {
        $elgg_entity = elgg_get_site_entity();
        $this->copy_from_elgg($elgg_entity);
    }

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        $this->id = (int)$elgg_entity->get("guid");
        $this->name = (string)$elgg_entity->get("name");
        $this->description = (string)$elgg_entity->get("description");
        $this->url = (string)$elgg_entity->get("url");
        $this->owner_id = (int)$elgg_entity->getOwnerGUID();
        $this->time_created = (int)$elgg_entity->getTimeCreated();
    }

    /**
     * Saves Site parameters into Elgg
     * @return int Site ID
     */
    protected function save() {
        $elgg_entity = elgg_get_site_entity();
        $this->copy_to_elgg($elgg_entity);
        $elgg_entity->save();
        return $this->id = $elgg_entity->get("guid");
    }

    /**
     * @param ElggEntity $elgg_entity
     */
    protected function copy_to_elgg($elgg_entity) {
        $elgg_entity->set("name", (string)$this->name);
        $elgg_entity->set("description", (string)$this->description);
        $elgg_entity->set("url", (string)$this->url);
    }

    static function get_site() {
        return new static();
    }

    static function get_site_id() {
        return (int)datalist_get("default_site");
    }

    /**
     * Get the REST API method list, including description and required parameters.
     * @return array List of all available REST API Methods.
     */
    static function api_list() {
        return list_all_apis();
    }

    /**
     * Get authentication token, required for all other REST API calls. The token must be set as the value for the
     * "auth_token" key in each REST API call.
     *
     * @param string $login    User login
     * @param string $password User password
     * @param int    $timeout  Session timeout in minutes
     *
     * @return string Authentication Token.
     * @throws SecurityException
     */
    static function get_token($login, $password, $timeout = 60) {
        global $CONFIG;
        if(elgg_authenticate($login, $password) === true) {
            $user = get_user_by_username($login);
            $query = "select * from {$CONFIG->dbprefix}users_apisessions where user_guid = {$user->guid};";
            $row = get_data_row($query);
            if(isset($row->token) && ((int)$row->expires - time()) > 0) {
                $token = $row->token;
            } else {
                $token = create_user_token($login, $timeout);
            }
            return $token;
        }
        throw new SecurityException(elgg_echo('SecurityException:authenticationfailed'));
    }

    static function remove_token($token) {
        return remove_user_token($token, null);
    }

    static function lookup($id) {
        try {
            $elgg_object = new ElggObject((int)$id);
            $object['type'] = (string)$elgg_object->type;
            $object['subtype'] = (string)get_subtype_from_id($elgg_object->subtype);
            $object['name'] = (string)$elgg_object->get("name");
            $object['description'] = (string)$elgg_object->description;
            //$object['class'] = get_class_from_subtype($object['subtype']);
            return $object;
        } catch(Exception $e) {
            try {
                $elgg_user = new ElggUser((int)$id);
                $object['type'] = (string)$elgg_user->type;
                $object['subtype'] = (string)get_subtype_from_id($elgg_user->subtype);
                return $object;
            } catch(Exception $e) {
                throw new APIException("ERROR: Unidentified ID provided.");
            }
        }
    }

    static function get_domain() {
        $site = elgg_get_site_entity();
        $urlData = parse_url($site->url);
        $hostData = explode('.', $urlData['host']);
        $hostData = array_reverse($hostData);
        return $hostData[1] . '.' . $hostData[0];
    }


    static function normalize_xml_key($key){
        return str_replace(
            array('!','"','#','$','%','&','(',')','*','+',',','/',';','<','=',
                '>','?','@','\\','[',']','^','`','{','}','|','~'),
            '_',
            $key);
    }
}