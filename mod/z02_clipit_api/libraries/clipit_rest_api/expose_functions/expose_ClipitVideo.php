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
 * Expose class functions for the Clipit REST API
 */
function expose_video_functions() {
    $api_suffix = "clipit.video.";
    $class_suffix = "ClipitVideo::";
    expose_common_functions($api_suffix, $class_suffix);
    expose_common_resource_functions($api_suffix, $class_suffix);
}
