<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = get_input("video-title");
$description = get_input("video-description");
$entity_id = get_input("entity-id");

$parent_id = get_input("parent-id");
$object = ClipitSite::lookup($parent_id);
$entity_class = $object['subtype'];

switch($entity_class){
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

$entity = array_pop(ClipitVideo::get_by_id(array($entity_id)));

if(count($entity)==0 || trim($title) == "" || trim($description) == "" || trim($entity->url) == ""){
    register_error(elgg_echo("cantpublish"));
} else{
    ClipitVideo::set_properties($entity_id, array(
        'name' => $title,
        'description' => $description
    ));
    $new_video_id = ClipitVideo::create_clone($entity->id);

    if($new_video_id){
        $entity_level_class::add_videos($parent_id, array($new_video_id));
    } else {
        register_error(elgg_echo("cantpublish"));
    }

    system_message(elgg_echo('published'));
}
forward($href);