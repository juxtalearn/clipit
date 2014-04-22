<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 4/03/14
 * Time: 11:18
 */
$discussion_id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$discussion = array_pop(ClipitPost::get_by_id(array($discussion_id)));

if($discussion && $discussion->owner_id == $user_id){
    echo elgg_view_form('group/discussion/edit', array('data-validate'=> "true" ), array('entity'  => $discussion));
}