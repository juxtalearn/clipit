<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$entity_id = get_input('entity-id');
$file_name = get_input('file-name');
$file_text = get_input('file-text');
$tags = array_filter(get_input("tags", array()));
$labels = get_input("labels");
$labels = array_filter(explode(",", $labels));

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
        system_message(elgg_echo('file:edited'));
        ClipitFile::set_properties($entity_id, $data);
    } else {
        // Create file
        $files = $_FILES['files'];
        $entity_id = ClipitFile::create(array(
            'temp_path'  => $files['tmp_name'],
            'name' => get_input('original_name'),
            'description' => $file_text,
        ));

        if($scope_id) {
            $entity_class::add_files($scope_id, array($entity_id));
        }
        // Upload to GDrive
        ClipitFile::upload_to_gdrive($entity_id);
        // Check if original name is different to input name
        if(get_input('original_name') != $data['name']) {
            ClipitFile::set_properties($entity_id, $data);
        }

        system_message(elgg_echo('file:added'));
    }

    // Set labels
    $total_labels = array();
    if(!empty($labels)){
        foreach ($labels as $label) {
            $total_labels[] = ClipitLabel::create(array(
                'name' => $label,
            ));
        }
    }
    ClipitFile::set_tags($entity_id, $tags);
    ClipitFile::set_labels($entity_id, $total_labels);
}

forward(REFERER);