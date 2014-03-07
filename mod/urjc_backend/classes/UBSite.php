<?php

/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 12/02/14
 * Time: 13:10
 */
class UBSite{
    /**
     * Get the REST API method list, including description and required parameters.
     *
     * @return array List of all available REST API Methods.
     */
    static function api_list(){
        return list_all_apis();
    }

    /**
     * Get authentication token, required for all other REST API calls. The token must be set as the value for the
     * "auth_token" key in each REST API call.
     *
     * @param string $login User login
     * @param string $password User password
     * @param int    $timeout Session timeout
     *
     * @return string Authentication Token.
     * @throws SecurityException
     */
    static function get_token($login, $password, $timeout = 60){
        if(elgg_authenticate($login, $password)){
            $token = create_user_token($login, $timeout);
            if($token){
                return $token;
            }
        }
        throw new SecurityException(elgg_echo('SecurityException:authenticationfailed'));
    }

    static function remove_token($token){
        return remove_user_token($token, null);
    }

    static function lookup($id){
        try{
            $elgg_object = new ElggObject((int)$id);
            $object['type'] = (string)$elgg_object->type;
            $object['subtype'] = (string)get_subtype_from_id($elgg_object->subtype);
            $object['name'] = (string)$elgg_object->name;
            $object['description'] = (string)$elgg_object->description;
            return $object;
        } catch(Exception $e){
            try{
                $elgg_user = new ElggUser((int)$id);
                $object['type'] = (string)$elgg_user->type;
                $object['subtype'] = (string)get_subtype_from_id($elgg_user->subtype);
                return $object;
            } catch(Exception $e){
                throw new APIException("ERROR: Unidentified ID provided.");
            }
        }
    }
} 