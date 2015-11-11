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
$discussion_id = (int)get_input("id");
$user_id = elgg_get_logged_in_user_guid();
$discussion = array_pop(ClipitMessage::get_by_id(array($discussion_id)));

if($discussion && $discussion->owner_id == $user_id){
    echo elgg_view_form('messages/reply/edit', array('data-validate'=> "true" ), array('entity'  => $discussion));
}