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

$activity_id = ClipitVideo::get_activity($video->id);
$scope = ClipitVideo::get_resource_scope($video->id);
switch($scope){
    case 'group':
        $url = "group/".ClipitVideo::get_group($video->id)."/multimedia";
        break;
    case 'activity':
        $url = "resources";
        break;
}

if(count($video)==0 || $video->owner_id != $user_id){
    register_error(elgg_echo("video:cantdelete"));
} else{
    ClipitVideo::delete_by_id(array($id));
    system_message(elgg_echo('video:deleted'));
    forward("clipit_activity/{$activity_id}/{$url}?filter=videos");
}

forward(REFERER);