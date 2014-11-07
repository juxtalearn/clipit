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
$id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$video = array_pop(ClipitVideo::get_by_id(array($id)));

if($video && $video->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER){
    echo elgg_view_form('multimedia/videos/edit', array('data-validate'=> "true" ), array('entity'  => $video));
}