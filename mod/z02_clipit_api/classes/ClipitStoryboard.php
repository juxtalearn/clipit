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
 * Class ClipitStoryboard
 *
 */
class ClipitStoryboard extends ClipitMaterial{
    const SUBTYPE = "ClipitStoryboard";

    const REL_MATERIAL_TAG = "storyboard-tag";
    const REL_MATERIAL_LABEL = "storyboard-label";
    const REL_MATERIAL_COMMENT = "storyboard-comment";
    const REL_MATERIAL_PERFORMANCE = "storyboard-performance";

    const REL_GROUP_MATERIAL = "group-storyboard";
    const REL_ACTIVITY_MATERIAL = "activity-storyboard";
    const REL_SITE_MATERIAL = "site-storyboard";
}