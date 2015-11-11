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
$id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$video = array_pop(ClipitVideo::get_by_id(array($id)));

$member_group = false;
if(in_array(ClipitVideo::get_group($video->id), ClipitUser::get_groups($user_id))){
    $member_group = true;
}
if($video &&
    $video->owner_id == $user_id ||
    hasTeacherAccess($user->role) ||
    ($member_group && $user->role == ClipitUser::ROLE_STUDENT)
){
    $body = elgg_view("page/components/modal",
        array(
            "dialog_class" => "modal-md",
            "remote" => true,
            "target" => "edit-video-{$video->id}",
            "title" => elgg_echo("video:edit"),
            "form" => true,
            "body" => elgg_view('forms/multimedia/videos/save', array('entity' => $video)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('save'),
                    'class' => "btn btn-primary"
                ))
        ));
    echo elgg_view_form('', array('action' => 'action/multimedia/videos/save', 'body' => $body, 'data-validate'=> "true"));
}