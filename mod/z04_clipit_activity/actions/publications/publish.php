<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = get_input("title");
$description = get_input("description");
$tags = get_input("tags");
$tags = explode(",", $tags);
$performance_items = get_input("performance_items");
$entity_id = get_input("entity-id");
$parent_id = get_input("parent-id");

$object = ClipitSite::lookup($entity_id);
$entity_class = $object['subtype'];

$parent_object = ClipitSite::lookup($parent_id);
$parent_entity_class = $parent_object['subtype'];

switch($parent_entity_class){
    // Clipit Activity
    case 'ClipitActivity':
        $entity_level_class = "ClipitActivity";
        $parent_id = array_pop(ClipitActivity::get_by_id(array($parent_id)));
        break;
    // Clipit Group
    case 'ClipitGroup':
        $entity_level_class = "ClipitActivity";
        $parent_id = ClipitGroup::get_activity($parent_id);
        $href = "clipit_activity/{$parent_id}/publications";
        break;
    default:
        register_error(elgg_echo("video:cantadd"));
        break;
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));

if(count($entity)==0 || trim($title) == "" || trim($description) == "" || trim($entity->url) == ""){
    register_error(elgg_echo("cantpublish"));
} else{
    $entity_class::set_properties($entity_id, array(
        'name' => $title,
        'description' => $description
    ));
    foreach($tags as $tag_value){
        $new_tag_ids[] = ClipitTag::create(array(
            'name'    => $tag_value,
        ));
    }
    $entity_class::add_tags($entity_id, $new_tag_ids);
    $entity_class::add_performance_items($entity_id, $performance_items);
    // Clone
    $new_video_id = $entity_class::create_clone($entity->id);

    if($new_video_id){
        $entity_level_class::add_videos($parent_id, array($new_video_id));
    } else {
        register_error(elgg_echo("cantpublish"));
    }

    system_message(elgg_echo('published'));
}
forward($href);