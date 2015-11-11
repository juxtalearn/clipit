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
$user_id = elgg_get_logged_in_user_guid();
$discussion_id = get_input('message-id');
$discussion = array_pop(ClipitPost::get_by_id(array($discussion_id)));

$discussion_title = get_input('discussion-title');
$discussion_text = get_input('discussion-text');

if(!isset($discussion) || $discussion->owner_id != $user_id || trim($discussion_text) == ""){
    register_error(elgg_echo("reply:cantedit"));
} else{
    ClipitPost::set_properties($discussion->id, array(
        'description' => $discussion_text
    ));
    system_message(elgg_echo('reply:edited'));
}


forward(REFERER);