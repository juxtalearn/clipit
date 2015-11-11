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
$id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$video = array_pop(ClipitVideo::get_by_id(array($id)));
$unlink = get_input('unlink');

if(count($video)==0){
    register_error(elgg_echo("video:cantdelete"));
} elseif(!$unlink && $video->owner_id == $user_id){
    ClipitVideo::delete_by_id(array($id));
    system_message(elgg_echo('video:deleted'));
    forward(custom_forward_referer("/view/", "?filter=videos"));
} elseif($unlink) {
    ClipitVideo::unlink_from_parent($id);
    ClipitTask::remove_videos(ClipitVideo::get_task($id), array($id));
    ClipitVideo::delete_by_id(array($id));
    system_message(elgg_echo('video:deleted'));
}

forward(REFERER);