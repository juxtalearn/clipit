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
class ClipitStoryboard extends UBItem{
    const SUBTYPE = "clipit_storyboard";

    static function get_publish_level($id){
        $site = static::get_site($id);
        if(!empty($site)){
            return "site";
        }
        $activity = static::get_activity($id);
        if(!empty($activity)){
            return "activity";
        }
        $group = static::get_group($id);
        if(!empty($group)){
            return "group";
        }
        return null;
    }

    static function get_group($id){
        $storyboard = new static($id);
        if(!empty($storyboard->clone_id)){
            return static::get_group($storyboard->clone_id);
        }
        $group = UBCollection::get_items($id, ClipitGroup::REL_GROUP_STORYBOARD, true);
        return array_pop($group);
    }

    static function get_activity($id){
        $activity = UBCollection::get_items($id, ClipitActivity::REL_ACTIVITY_STORYBOARD, true);
        return array_pop($activity);
    }

    static function get_site($id){
        $site = UBCollection::get_items($id, ClipitSite::REL_SITE_STORYBOARD, true);
        return array_pop($site);
    }

}