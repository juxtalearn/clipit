<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$discussion_id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$discussion = array_pop(ClipitPost::get_by_id(array($discussion_id)));

if($discussion && $discussion->owner_id == $user_id || hasTeacherAccess($user->role)){
    echo elgg_view_form('discussion/edit', array('data-validate'=> "true" ), array('entity'  => $discussion));
}