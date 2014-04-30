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
print_r($_FILES);
die();
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
    register_error(elgg_echo("discussion:cantcreate"));
} else{
    $files = $_FILES['files'];
    $count = 0;
    $new_file_ids = array();
    foreach($files['name'] as $file){
        if(!empty($files['name'][$count])){
            $new_file_ids[] = ClipitFile::create(array(
                'name' => $files['name'][$count],
                'description' => "",
                'temp_path'  => $files['tmp_name'][$count]
            ));
        } else {
            register_error(elgg_echo("file:cantupload"));
        }
        $count++;
    }
    if(!empty($new_file_ids)){
        // add files to entity
        $entity_class::add_files($entity_id, $new_file_ids);
    }

    system_message(elgg_echo('file:uploaded'));
}



forward(REFERER);
