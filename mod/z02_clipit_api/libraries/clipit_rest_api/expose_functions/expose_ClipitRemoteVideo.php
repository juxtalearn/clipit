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
function expose_remote_video_functions() {
    $api_suffix = "clipit.remote_video.";
    $class_suffix = "ClipitRemoteVideo::";
    expose_common_remote_resource_functions($api_suffix, $class_suffix);
}