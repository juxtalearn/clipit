<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */


$entity_id = get_input('entity-id');
$data = array(
    'name' => get_input('title'),
    'description' => get_input('description'),
    'country' => get_input('country'),
    'location' => get_input('location'),
    'education_level' => get_input('education-level'),
    'subject' => get_input('subject'),
);
$reflection_items = get_input('reflections', array());
$reflection_items = array_filter($reflection_items);
if($entity_id){
    // Update
    $example_id = $entity_id;
    ClipitExample::set_properties($example_id, $data);
} else {
    // Create
    $example_id = ClipitExample::create($data);
}
// Add reflection items
ClipitExample::set_reflection_items($example_id, $reflection_items);
// Files, Storyboards and Videos
$file = $_FILES['file'];
$new_file_id = array();
for($i = 0;$i < count($file['name']);$i++){
    if($file['name'][$i]){
        $new_file_id[] = ClipitFile::create(array(
            'name' => $file['name'][$i],
            'temp_path'  => $file['tmp_name'][$i]
        ));
    }
}
ClipitExample::add_files($example_id, $new_file_id);
$storyboard = $_FILES['storyboard'];
$new_sb_id = array();
for($i = 0;$i < count($storyboard['name']);$i++){
    if($storyboard['name'][$i]){
        $file_id = ClipitFile::create(array(
            'name' => $storyboard['name'][$i],
            'temp_path'  => $storyboard['tmp_name'][$i]
        ));
        $new_sb_id[] = ClipitStoryboard::create(array(
            'name' => $storyboard['name'][$i],
            'file'  => $file_id
        ));
    }
}
ClipitExample::add_storyboards($example_id, $new_sb_id);
// Create Stumling blocks
$tags =  get_input('tag');
$tag_ids = array();
foreach($tags as $tag){
    $tag_ids[] = ClipitTag::create(array('name' => $tag));
}
ClipitExample::set_tags($example_id, $tag_ids);
//$file_array
forward("tricky_topics/examples");