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

$labels = get_input("labels");
$labels = array_filter(explode(",", $labels));
$tags = get_input("tags");
$performance_items = get_input("performance_items");
$entity_id = get_input("entity-id");
$task_id = get_input("task-id");
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
        $href = "clipit_activity/{$parent_id}/publications";
        break;
    // Clipit Group
    case 'ClipitGroup':
        $entity_level_class = "ClipitActivity";
        $parent_id = ClipitGroup::get_activity($parent_id);
        $href = "clipit_activity/{$parent_id}/tasks/view/{$task_id}";
        break;
    default:
        register_error(elgg_echo("video:cantadd"));
        break;
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($title) == "" || trim($description) == ""){
    register_error(elgg_echo("cantpublish"));
} else{
    $entity_class::set_properties($entity_id, array(
        'name' => $title,
        'description' => $description
    ));
    // Labels
    $total_labels = array();
    foreach($labels as $label){
        if($label_exist = array_pop(ClipitLabel::get_from_search($label, true, true))){
            $total_labels[] = $label_exist->id;
        } else {
            $total_labels[] = ClipitLabel::create(array(
                'name'    => $label,
            ));
        }
    }
    $entity_class::set_labels($entity_id, $total_labels);
    // Tags
    $entity_class::set_tags($entity_id, $tags);
    // Performance items
    $entity_class::add_performance_items($entity_id, $performance_items);
    // Clone
    $new_entity_id = $entity_class::create_clone($entity_id);

    if($new_entity_id){
        switch($entity_class){
            case "ClipitVideo":
                ClipitTask::add_videos($task_id, array($new_entity_id));
                break;
            case "ClipitStoryboard":
                ClipitTask::add_storyboards($task_id, array($new_entity_id));
                break;
            default:
                register_error(elgg_echo("cantpublish"));
                break;
        }
    } else {
        register_error(elgg_echo("cantpublish"));
    }
    system_message(elgg_echo('published'));
}
forward($href);