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
$user_id = elgg_get_logged_in_user_guid();
$id = get_input('entity-id');
$resource = array_pop(ClipitResource::get_by_id(array($id)));

$resource_description = get_input('resource-description');
$resource_title = get_input('resource-title');

if(!isset($resource) || $resource->owner_id != $user_id || trim($resource_description) == "" || trim($resource_title) == ""){
    register_error(elgg_echo("resource:cantedit"));
} else{
    ClipitResource::set_properties($resource->id, array(
        'name'  => $resource_title,
        'description' => $resource_description
    ));
    system_message(elgg_echo('resource:edited'));
}


forward(REFERER);