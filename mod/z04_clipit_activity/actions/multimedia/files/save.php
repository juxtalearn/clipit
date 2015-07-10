<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
$entity_id = get_input('entity-id');
$file_name = get_input('file-name');
$file_text = get_input('file-text');
$tags = array_filter(get_input("tags", array()));
if(!$tags){
    $tags = array();
}
if($scope_id = get_input('scope-id')){
    // Scope entity (Activity|Task|Group) id
    $object = ClipitSite::lookup($scope_id);
    $entity_class = $object['subtype'];
    $entity = array_pop($entity_class::get_by_id(array($scope_id)));
}

$data = array(
    'name' => $file_name,
    'description' => $file_text,
);
$href = REFERER;

if(trim($file_name) == ""){
    register_error(elgg_echo("file:cantedit"));
} else{
    if($entity_id) {
        // ClipitFile exists
        $file = array_pop(ClipitFile::get_by_id(array($entity_id)));
        // Edit file properties
        ClipitFile::set_properties($entity_id, array(
            'description' => $file_description
        ));
    } else {
        // Create file
        $files = $_FILES['files'];
        $new_file_id = ClipitFile::create(array_merge(array(
            'temp_path'  => $files['tmp_name']
        ), $data));
        if($scope_id) {
            $entity_class::add_files($scope_id, array($new_file_id));
        }
        ClipitFile::add_tags($new_file_id, $tags);
    }

    system_message(elgg_echo('file:edited'));
}


forward(REFERER);