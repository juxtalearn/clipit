<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$id = get_input('entity-id');
$performance_items = get_input("performance_items");
$video = array_pop(ClipitVideo::get_by_id(array($id)));

$video_description = get_input('video-description');
$video_title = get_input('video-title');

if(!isset($video) || trim($video_description) == "" || trim($video_title) == ""){
    register_error(elgg_echo("video:cantedit"));
} else{
    ClipitVideo::set_properties($video->id, array(
        'name'  => $video_title,
        'description' => $video_description
    ));
    // Performance items
    ClipitVideo::set_performance_items($video->id, $performance_items);
    system_message(elgg_echo('video:edited'));
}


forward(REFERER);