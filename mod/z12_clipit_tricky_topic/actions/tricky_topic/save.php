<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/12/2014
 * Last update:     04/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activiy_tricky_topic = get_input('activity-tricky-topic');
$title = get_input('title');
$description = get_input('description');
$subject = get_input('subject');
$education_level = get_input('education_level');
if($activiy_tricky_topic){
    $title = get_input('tricky-topic-title');
    $description = get_input('tricky-topic-description');
    $education_level = get_input('tricky-topic-education_level');
    $subject = get_input('tricky-topic-subject');
}

$data = array(
    'name' => $title,
    'description' => $description,
    'subject' => $subject,
    'education_level' => $education_level
);

$entity_id = get_input('entity-id');
if($entity_id){
    $tricky_topic_id = $entity_id;
    if(get_input('clone')){
        $tricky_topic_id = ClipitTrickyTopic::create_clone($entity_id);
    }
    ClipitTrickyTopic::set_properties($tricky_topic_id, $data);
    system_message(elgg_echo('saved'));
} else {
    $tricky_topic_id = ClipitTrickyTopic::create($data);
    if($activiy_tricky_topic){
        echo json_encode(elgg_view("activity/create/tricky_topics", array('selected' => $tricky_topic_id)));
    }
    system_message(elgg_echo('tricky_topic:created'));
}
// Create Stumling blocks
$tags =  get_input('tag');
$tags = array_filter($tags);
$tag_ids = array();
foreach($tags as $tag){
    $tag_ids[] = ClipitTag::create(array('name' => $tag));
}
ClipitTrickyTopic::set_tags($tricky_topic_id, $tag_ids);

forward('tricky_topics/view/'.$tricky_topic_id);