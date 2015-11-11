<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$title = get_input("title");
$description = get_input("description");
$labels = get_input("labels");
$labels = array_filter(explode(",", $labels));
$tags = get_input("tags", array());
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
        $total_labels[] = ClipitLabel::create(array(
            'name'    => $label,
        ));
    }
    $entity_class::set_labels($new_entity_id, $total_labels);
    // Tags
    $entity_class::set_tags($new_entity_id, $tags);

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
            case "ClipitFile":
                if($scope_entity == 'ClipitTask') {
                    $scope_entity::add_files($task_id, array($new_entity_id));
                } else {
                    $scope_entity::add_pub_files(array($new_entity_id));
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