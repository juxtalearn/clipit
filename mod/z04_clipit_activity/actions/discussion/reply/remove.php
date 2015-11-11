<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$discussion_id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$message = array_pop(ClipitPost::get_by_id(array($discussion_id)));

if(count($message)==0 || $message->owner_id != $user_id){
    register_error(elgg_echo("reply:cantdelete"));
} else{
    ClipitPost::delete_by_id(array($discussion_id));
    system_message(elgg_echo('reply:deleted'));
}

forward(REFERER);