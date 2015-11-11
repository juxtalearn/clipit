<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/02/2015
 * Last update:     20/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$activity = array_pop(ClipitActivity::get_by_id(array($id)));

if(count($activity)==0 || in_array($activity, $video->teacher_array)){
    register_error(elgg_echo("activity:cantdelete"));
} else{
    ClipitActivity::delete_by_id(array($id));
    system_message(elgg_echo('activity:deleted'));
}

forward("activities");