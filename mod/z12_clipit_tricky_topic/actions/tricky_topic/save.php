<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/12/2014
 * Last update:     04/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$data = array(
    'name' => get_input('title'),
    'description' => get_input('description'),
);
$url = REFERER;
$entity_id = get_input('entity-id');
if($entity_id){
    $tricky_topic_id = $entity_id;
    ClipitTrickyTopic::set_properties($tricky_topic_id, $data);
} else {
    $tricky_topic_id = ClipitTrickyTopic::create($data);
    $url = "tricky_topics";
}
// Create Stumling blocks
$tags =  get_input('tag');
$tag_ids = array();
foreach($tags as $tag){
    $tag_ids[] = ClipitTag::create(array('name' => $tag));
}
ClipitTrickyTopic::set_tags($tricky_topic_id, $tag_ids);

forward($url);