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
$entity_class = $object['subtype'];
$tags = array_filter(get_input("tags", array()));
if(!$tags){
    $tags = array();
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));

if(count($entity)==0){
    register_error(elgg_echo("storyboard:cantupload"));
} else{
    $files = $_FILES['files'];
    $new_file_id = ClipitFile::create(array(
        'name' => $files['name'],
        'description' => $file_text,
        'temp_path'  => $files['tmp_name']
    ));
    if($new_file_id){
        $new_sb_id = ClipitStoryboard::create(array(
            'name' => $files['name'],
            'description' => $file_text,
            'file' => $new_file_id
        ));
        $entity_class::add_storyboards($entity_id, array($new_sb_id));
        ClipitStoryboard::add_tags($new_sb_id, $tags);
    } else {
        register_error(elgg_echo("storyboard:cantupload"));
    }

    system_message(elgg_echo('storyboard:uploaded'));
}
die();
