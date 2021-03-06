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
 * A rich-text Comment written by a User and directed to any single Resource. It may contain attached files, and can
 * respond to another user's comment (optionally).
 */
class ClipitComment extends UBMessage {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitComment";
    const REL_MESSAGE_DESTINATION = "ClipitComment-destination";
    const REL_MESSAGE_FILE = "ClipitComment-ClipitFile";
    const REL_MESSAGE_USER = "ClipitComment-ClipitUser";

}