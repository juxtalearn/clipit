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
        $api_suffix . "get_metric", $class_suffix . "get_metric", array(
            "metric_id" => array("type" => "int", "required" => true),
            "context" => array("type" => "string", "required" => true),
        ), "Get Learning Analytics Metric", "POST", false, true
    );
    expose_function(
        $api_suffix . "save_metric", $class_suffix . "save_metric", array(
            "return_id" => array("type" => "int", "required" => true),
            "data" => array("type" => "string", "required" => true),
            "status_code" => array("type" => "int", "required" => true)
        ), "Send Learning Analytics Metric to ClipIt", "POST", false, true
    );
}
