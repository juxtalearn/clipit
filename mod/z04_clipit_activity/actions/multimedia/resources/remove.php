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
$id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$resource = array_pop(ClipitResource::get_by_id(array($id)));

if(count($resource)==0 || $resource->owner_id != $user_id){
    register_error(elgg_echo("resource:cantdelete"));
} else{
    ClipitResource::delete_by_id(array($id));
    system_message(elgg_echo('resource:deleted'));
    forward(custom_forward_referer("/view/", "?filter=resources"));
}

forward(REFERER);