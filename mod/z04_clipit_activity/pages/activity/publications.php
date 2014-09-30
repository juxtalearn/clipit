<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$selected_tab = get_input('filter', 'resources');
$title = elgg_echo("activity:publications");
elgg_push_breadcrumb($title);
$href = "clipit_activity/{$activity->id}/publications";
$filter = elgg_view('publications/filter', array('selected' => $selected_tab, 'entity' => $activity, 'href' => $href));
$tasks = ClipitActivity::get_tasks($activity->id);
switch($selected_tab){
    case 'videos':
        // Get last task [type: video_upload]
        $content = publications_get_page_content_list('video_upload', $tasks, $href);
        break;
    case 'resources':
        // Get last task [type: storyboard_upload]
        $content = publications_get_page_content_list('resource_upload', $tasks, $href);
        break;
    case 'storyboards':
        // Get last task [type: storyboard_upload]
        $content = publications_get_page_content_list('storyboard_upload', $tasks, $href);
        break;
}

if($page[2] == 'view' && $page[3]){
    $entity_id = (int)$page[3];
    $filter = "";
    elgg_pop_breadcrumb($title);
    elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/publications");
    $object = ClipitSite::lookup($entity_id);
    $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
    // Check if user can evaluate own group video
    $hasRating = ClipitRating::get_from_user_for_target($user_id, $entity_id);
    $owner_group_id = $entity->get_group($entity->id);
    $my_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    $canEvaluate = false;
    if(!$hasRating && ($my_group != $owner_group_id)){
        $canEvaluate = true;
    }

    $owner_group = array_pop(ClipitGroup::get_by_id(array($owner_group_id)));
    $comments = array_pop(ClipitComment::get_by_destination(array($entity->id), clipit_get_offset(), clipit_get_limit()));
    switch($object['subtype']){
        // Clipit Video publication
        case 'ClipitVideo':
            $task_id = ClipitVideo::get_task($entity_id);
            $videos = ClipitTask::get_videos($task_id);
            if(!$entity || !in_array($entity_id, $videos)){
                return false;
            }
            $body = elgg_view("multimedia/video/body", array('entity'  => $entity));
            $content = elgg_view('publications/view', array(
                'entity' => $entity,
                'body' => $body,
                'canEvaluate' => $canEvaluate,
                'activity' => $activity,
                'group' => $owner_group,
                'comments' => $comments
            ));
            break;
        // Clipit Resource publication
        case 'ClipitResource':
            $task_id = ClipitResource::get_task($entity_id);
            $resources = ClipitTask::get_resources($task_id);
            if(!$entity || !in_array($entity_id, $resources)){
                return false;
            }
            $body = elgg_view("multimedia/resource/body", array('entity'  => $entity));
            $content = elgg_view('publications/view', array(
                'entity' => $entity,
                'body' => $body,
                'canEvaluate' => $canEvaluate,
                'activity' => $activity,
                'group' => $owner_group,
                'comments' => $comments,
                'description' => false
            ));
            break;
        // Clipit Storyboard publication
        case 'ClipitStoryboard':
            $task_id = ClipitStoryboard::get_task($entity_id);
            $sbs = ClipitTask::get_storyboards($task_id);
            if(!$entity || !in_array($entity_id, $sbs)){
                return false;
            }
            $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
            $body = elgg_view("multimedia/storyboard/body", array(
                'entity' => $entity,
                'file'  => $file,
                'preview' => true
            ));
            $content = elgg_view('publications/view', array(
                'entity' => $entity,
                'type' => 'storyboard',
                'body' => $body,
                'canEvaluate' => $canEvaluate,
                'activity' => $activity,
                'comments' => $comments,
                'group' => $owner_group
            ));
            break;
        default:
            return false;
            break;
    }
}
elgg_push_breadcrumb($entity->name);

$params = array(
    'content'   => $content,
    'filter'    => $filter,
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);