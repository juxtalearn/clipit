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
 * Class ClipitFile
 *
 */
class ClipitFile extends ClipitMaterial{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "ClipitFile";

    const REL_MATERIAL_TAG = "file-tag";
    const REL_MATERIAL_LABEL = "file-label";
    const REL_MATERIAL_COMMENT = "file-comment";
    const REL_MATERIAL_PERFORMANCE = "file-performance";

    const REL_GROUP_MATERIAL = "group-file";
    const REL_ACTIVITY_MATERIAL = "activity-file";
    const REL_SITE_MATERIAL = "site-file";
}
