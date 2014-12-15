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

$file = get_input('file');

$data = array(
    'name' => get_input('title'),
    'description' => get_input('description'),
    'country' => get_input('country'),
    'location' => get_input('location'),
    'education_level' => get_input('education-level'),
    'subject' => get_input('subject'),
);

$example_id = ClipitExample::create($data);
// Create Stumling blocks
$tags =  get_input('tag');
$tag_ids = array();
foreach($tags as $tag){
    $tag_ids[] = ClipitTag::create(array('name' => $tag));
}
ClipitExample::set_tags($example_id, $tag_ids);
//$file_array