<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$entity_id = get_input('entity-id');
$object = ClipitSite::lookup($entity_id);
$file_name = get_input('file-name');
$file_text = get_input('file-text');

switch($object['subtype']){
    // Clipit Activity
    case 'clipit_activity':
        $entity_class = "ClipitActivity";
        break;
    // Clipit Group
    case 'clipit_group':
        $entity_class = "ClipitGroup";
        $entity = array_pop(ClipitGroup::get_by_id(array($entity_id)));
        $user_groups = ClipitUser::get_groups($user_id);
        if(!in_array($entity->id, $user_groups)){
            register_error(elgg_echo("file:cantupload"));
        }
        break;
    default:
        register_error(elgg_echo("file:cantupload"));
        break;
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0){
    register_error(elgg_echo("file:cantupload"));
} else{
    $files = $_FILES['files'];

    $new_file_id = ClipitFile::create(array(
        'name' => $files['name'],
        'description' => $file_text,
        'temp_path'  => $files['tmp_name']
    ));

    if($new_file_id){
        $entity_class::add_files($entity_id, array($new_file_id));
    } else {
        register_error(elgg_echo("file:cantupload"));
    }

    system_message(elgg_echo('file:uploaded'));
}
die();
