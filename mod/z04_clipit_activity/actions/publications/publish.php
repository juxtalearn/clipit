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
$tags = get_input("tags", array());
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
        $scope_entity = 'ClipitSite';
        $href = REFERER;
        break;
    // Clipit Group
    case 'ClipitGroup':
        $entity_level_class = "ClipitActivity";
        $parent_id = ClipitGroup::get_activity($parent_id);
        $scope_entity = 'ClipitTask';
        $group_id = $entity_class::get_group($entity_id);
        /* get tags from group */
        $group_tags = ClipitGroup::get_tags($group_id);
        if($group_tags){
            $tags = array_merge($tags, $group_tags);
        }
        $href = "clipit_activity/{$parent_id}/tasks/view/{$task_id}";
        if(ClipitTask::get_completed_status($task_id, $group_id)){
            forward("clipit_activity/{$parent_id}/tasks/view/{$task_id}");
        }
        break;
    default:
        register_error(elgg_echo("video:cantadd"));
        break;
}

$entity = array_pop($entity_class::get_by_id(array($entity_id)));
if(count($entity)==0 || trim($title) == "" || trim($description) == ""){
    register_error(elgg_echo("cantpublish"));
} else{
    // Clone
    $new_entity_id = $entity_class::create_clone($entity_id);

    $entity_class::set_properties($new_entity_id, array(
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
    $entity_class::set_labels($new_entity_id, $total_labels);
    // Tags
    $entity_class::set_tags($new_entity_id, $tags);
    /* Get performance items from task */
    if(get_config('fixed_performance_rating') && $task_feedback_id = ClipitTask::get_child($task_id)){
        $task_feedback = array_pop(ClipitTask::get_by_id(array($task_feedback_id)));
        $performance_items = $task_feedback->performance_item_array;
    }
    // Performance items
    $entity_class::add_performance_items($new_entity_id, $performance_items);

    if($new_entity_id){
        switch($entity_class){
            case "ClipitVideo":
                if($scope_entity == 'ClipitTask') {
                    $scope_entity::add_videos($task_id, array($new_entity_id));
                } else {
                    $scope_entity::add_videos(array($new_entity_id));
                    if(get_input('remote')){
                        $scope_entity::add_pub_videos(array($new_entity_id));
                    }
                }
                break;
            case "ClipitStoryboard":
                if($scope_entity == 'ClipitTask') {
                    $scope_entity::add_storyboards($task_id, array($new_entity_id));
                } else {
                    $scope_entity::add_pub_storyboards(array($new_entity_id));
                }
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