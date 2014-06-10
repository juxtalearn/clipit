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
 * Class ClipitSite
 *
 */
class ClipitSite extends UBSite{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitSite";

    const REL_SITE_VIDEO = "site-video";
    const REL_SITE_STORYBOARD = "site-storyboard";
    const REL_SITE_FILE = "site-file";

    public $file_array = array();
    public $storyboard_array = array();
    public $video_array = array();


    protected function load_from_elgg($elgg_entity){
        parent::load_from_elgg($elgg_entity);
        /** @todo: load all arrays */
    }

    /**
     * @param ElggEntity $elgg_entity
     */
    protected function copy_to_elgg($elgg_entity)
    {
        parent::copy_to_elgg($elgg_entity);
        /** @todo: save all arrays */
    }
}