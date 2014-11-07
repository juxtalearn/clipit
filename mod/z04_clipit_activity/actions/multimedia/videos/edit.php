<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$id = get_input('entity-id');
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
    system_message(elgg_echo('video:edited'));
}


forward(REFERER);