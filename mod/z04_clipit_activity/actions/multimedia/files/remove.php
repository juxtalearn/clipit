<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$ids = is_array($id) ? $id : array($id);

foreach($ids as $file_id){
    $file = array_pop(ClipitFile::get_by_id(array((int)$file_id)));
    $activity_id = ClipitFile::get_activity($file->id);
    $scope = ClipitFile::get_resource_scope($file->id);
    switch($scope){
        case 'group':
            $url = "group/".ClipitFile::get_group($file->id)."/multimedia";
            break;
        case 'activity':
            $url = "resources";
            break;
    }
    if($file &&  $file->owner_id == $user_id){
        ClipitFile::delete_by_id(array($file->id));
        system_message(elgg_echo("file:removed", array($file->name)));
    } else{
        register_error(elgg_echo("file:cantremove"));
    }
}
if($url){
    forward("clipit_activity/{$activity_id}/{$url}?filter=files");
} else {
    forward(REFERRER);
}