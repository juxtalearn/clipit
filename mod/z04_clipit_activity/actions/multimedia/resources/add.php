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
$title = get_input("resource-title");
$description = get_input("resource-description");
$entity_id = get_input("entity-id");

$object = ClipitSite::lookup($entity_id);
$user_id = elgg_get_logged_in_user_guid();
$entity_class = $object['subtype'];
$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($title) == "" || trim($description) == ""){
    register_error(elgg_echo("resource:cantadd"));
} else{
        $new_resource_id = ClipitResource::create(array(
            'name' => $title,
            'description' => $description,
        ));
    if($new_resource_id){
        $entity_class::add_resources($entity_id, array($new_resource_id));
    } else {
        register_error(elgg_echo("resource:cantadd"));
    }

    system_message(elgg_echo('resource:added'));
}
forward(REFERER);
