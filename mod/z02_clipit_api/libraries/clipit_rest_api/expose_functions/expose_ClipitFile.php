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
function expose_file_functions() {
    $api_suffix = "clipit.file.";
    $class_suffix = "ClipitFile::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_resource_functions($api_suffix, $class_suffix);
    //upload_to_gdrive($file_path, $title)
    expose_function(
        $api_suffix . "upload_to_gdrive", $class_suffix . "upload_to_gdrive",
        array(
            "id" => array("type" => "int", "required" => true)),
        "Upload a Clipit File to Google Drive", "POST", false, true
    );
}
