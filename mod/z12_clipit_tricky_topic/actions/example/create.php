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
$title = get_input('title');
$description = get_input('description');
$tags = get_input('tags');
$url = get_input('url');
$file = get_input('file');
$tricky_topic = get_input('tricky-topic');
$subject = get_input('subject');
$education_level = get_input('education-level');
$location = get_input('location');

$example_id = ClipitExample::create(array(
    'name' => $title,
    'description' => $description,
    'resource_url' => $url,
));
ClipitExample::add_tags($example_id, $tags);
//$file_array