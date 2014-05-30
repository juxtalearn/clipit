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

    const SUBTYPE = "ClipitSite";

    const REL_SITE_VIDEO = "site-video";
    const REL_SITE_STORYBOARD = "site-storyboard";
    const REL_SITE_FILE = "site-file";

    public $file_array = array();
    public $storyboard_array = array();
    public $video_array = array();

}