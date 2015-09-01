<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/06/14
 * Last update:     26/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function get_visible_items($entities, $type){
    $user_id = elgg_get_logged_in_user_guid();
    $get_type = "get_{$type}";
    $item_list = array();
    foreach(ClipitUser::get_activities($user_id) as $activity_id){
        $group_id = ClipitGroup::get_from_user_activity($user_id, $activity_id);
        $group_items = ClipitGroup::$get_type($group_id);
        $activity_items = ClipitActivity::$get_type($activity_id);
        $item_list = array_merge($group_items, $activity_items, $item_list);
    }
    $site_items = ClipitSite::$get_type();
    $total = array_merge($site_items, $item_list);
    $entities = array_intersect($total, array_keys($entities));
    $result = ClipitVideo::get_by_id($entities);

    return $result;
}

function get_visible_items_by_activity(int $activity_id, $entities, $type){
    $user_id = elgg_get_logged_in_user_guid();
    $get_published_type = "get_published_{$type}";
    $published_items = ClipitActivity::$get_published_type($activity_id);
    $entities = array_intersect($published_items, array_keys($entities));
    return $entities;
}
function get_visible_items_by_site($entities, $type){
    $get_type = "get_{$type}";
    $published_items = ClipitSite::$get_type();
    $entities = array_intersect($published_items, array_keys($entities));
    return $entities;
}
