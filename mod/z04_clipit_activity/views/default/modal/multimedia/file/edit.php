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
$file = array_pop(ClipitFile::get_by_id(array($id)));

$member_group = false;
if(in_array(ClipitFile::get_group($file->id), ClipitUser::get_groups($user_id))){
    $member_group = true;
}
if($file &&
    $file->owner_id == $user_id ||
    hasTeacherAccess($user->role) ||
    ($member_group && $user->role == ClipitUser::ROLE_STUDENT)
){
    echo elgg_view_form('multimedia/files/edit', array('data-validate'=> "true" ), array('entity'  => $file));
}