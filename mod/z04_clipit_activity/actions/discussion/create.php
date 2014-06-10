<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 17:07
 * To change this template use File | Settings | File Templates.
 */

$user_id = elgg_get_logged_in_user_guid();
$entity_id = get_input('entity-id');
$object = ClipitSite::lookup($entity_id);
$file_ids = get_input('file-id');
$discussion_title = get_input('discussion-title');
$discussion_text = get_input('discussion-text');
$entity_class = $object['subtype'];
switch($entity_class){
    // Clipit Activity
    case 'ClipitActivity':
        $entity = array_pop(ClipitActivity::get_by_id(array($entity_id)));
        $user_activity = ClipitGroup::get_from_user_activity($user_id, $entity->id);
        $called_user = ClipitActivity::get_called_users($entity->id);
        if(!$user_activity || !in_array($user_id, $called_user)){
            register_error(elgg_echo("discussion:cantcreate"));
        }
        break;
    // Clipit Group
    case 'ClipitGroup':
        $entity = array_pop(ClipitGroup::get_by_id(array($entity_id)));
        $user_groups = ClipitUser::get_groups($user_id);
        if(!in_array($entity->id, $user_groups)){
            register_error(elgg_echo("discussion:cantcreate"));
        }
        break;
    default:
        register_error(elgg_echo("discussion:cantcreate"));
        break;
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($discussion_title) == "" || trim($discussion_text) == ""){
    register_error(elgg_echo("discussion:cantcreate"));
} else{
    $new_message_id = ClipitPost::create(array(
        'name' => $discussion_title,
        'description' => $discussion_text,
        'destination' => $entity->id,
    ));
    if($file_ids){
        ClipitPost::add_files($new_message_id, $file_ids);
    }
    // set read status true to the owner's message
    ClipitPost::set_read_status($new_message_id, true, array($user_id));

    system_message(elgg_echo('discussion:created'));
}


forward(REFERER);