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
$id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$storyboard = array_pop(ClipitStoryboard::get_by_id(array($id)));

$member_group = false;
if(in_array(ClipitStoryboard::get_group($storyboard->id), ClipitUser::get_groups($user_id))){
    $member_group = true;
}
if($storyboard &&
    $storyboard->owner_id == $user_id ||
    $user->role == ClipitUser::ROLE_TEACHER ||
    ($member_group && $user->role == ClipitUser::ROLE_STUDENT)
){
    $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    echo elgg_view_form('multimedia/storyboards/edit', array('data-validate'=> "true" ), array(
        'entity'  => $storyboard,
        'file' => $file
    ));
}