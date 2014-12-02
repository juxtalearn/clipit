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
 * Expose class functions for the ClipIt REST API
 */
function expose_remote_resource_functions() {
    $api_suffix = "clipit.remote_resource.";
    $class_suffix = "ClipitRemoteResource::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "delete_from_site", $class_suffix . "delete_from_site",
        array("remote_site" => array("type" => "string", "required" => true)),
        "Delete all Remote Resources from a Remote Site", "POST",
        false, true
    );
}