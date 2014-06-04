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
class ClipitStoryboard extends ClipitPublication{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitStoryboard";

    const REL_PUBLICATION_TAG = "storyboard-tag";
    const REL_PUBLICATION_LABEL = "storyboard-label";
    const REL_PUBLICATION_COMMENT = "storyboard-comment";
    const REL_PUBLICATION_PERFORMANCE = "storyboard-performance";

    const REL_GROUP_PUBLICATION = "group-storyboard";
    const REL_ACTIVITY_PUBLICATION = "activity-storyboard";
    const REL_SITE_PUBLICATION = "site-storyboard";
}