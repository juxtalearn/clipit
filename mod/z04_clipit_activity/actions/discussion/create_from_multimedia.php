<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input('entity-id');
$object = ClipitSite::lookup($entity_id);
$entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
$user_id = elgg_get_logged_in_user_guid();

if(!$entity){
    register_error(elgg_echo("discussion:cantcreate"));
} else {
    $new_message_id = ClipitPost::create(array(
        'name' => $entity->name,
        'description' => $entity->description,
        'destination' => $entity::get_group($entity_id)
    ));
    switch($object['subtype']){
        case "ClipitVideo":
            ClipitPost::add_videos($new_message_id, array($entity_id));
            break;
        case "ClipitFile":
            ClipitPost::add_files($new_message_id, array($entity_id));
            break;
    }
    system_message(elgg_echo('discussion:created'));
    ClipitPost::set_read_status($new_message_id, true, array($user_id));
}
forward("/clipit_activity/
        {$entity::get_activity($entity_id)}
        /group/{$entity::get_group($entity_id)}
        /discussion/view/{$new_message_id}"
);
