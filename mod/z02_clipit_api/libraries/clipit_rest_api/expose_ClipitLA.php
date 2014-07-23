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
function expose_la_functions() {
    $api_suffix = "clipit.la.";
    $class_suffix = "ClipitLA::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_function(
        $api_suffix . "send_metrics", $class_suffix . "send_metrics", array(
            "returnId" => array("type" => "int", "required" => true),
            "data" => array("type" => "string", "required" => true),
            "statuscode" => array("type" => "int", "required" => true)
        ), "Send Learning Analytics Metrics to ClipIt", "POST", false, true
    );
}
