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
$id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$video = array_pop(ClipitVideo::get_by_id(array($id)));

if(count($video)==0 || $video->owner_id != $user_id){
    register_error(elgg_echo("video:cantdelete"));
} else{
    ClipitVideo::delete_by_id(array($id));
    system_message(elgg_echo('video:deleted'));
    forward(custom_forward_referer("/view/", "?filter=videos"));
}

forward(REFERER);