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
$selected_tab = get_input('filter', 'videos');
$title = elgg_echo("activity:publications");
elgg_push_breadcrumb($title);
$href = "clipit_activity/{$activity->id}/publications";
$filter = '';
if($page[2] == 'view' && $page[3]){
    $entity_id = (int)$page[3];
    $filter = "";
    elgg_pop_breadcrumb($title);
    elgg_push_breadcrumb($title, "clipit_activity/{$activity->id}/publications");
    $object = ClipitSite::lookup($entity_id);
    $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
    // Check if user can evaluate own group video
    $hasRating = ClipitRating::get_user_rating_for_target($user_id, $entity_id);
    $owner_group_id = $entity->get_group($entity->id);
    $my_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
    $canEvaluate = false;
    $feedback_task = ClipitTask::get_child_task($entity::get_task($entity->id));
    if(
        !$hasRating
        && $feedback_task
        && $my_group != $owner_group_id
        && $user->role == ClipitUser::ROLE_STUDENT
        && ClipitTask::get_status($feedback_task) == ClipitTask::STATUS_ACTIVE
    ){
            $canEvaluate = ClipitTask::get_completed_status($feedback_task, $user_id) ? false:$feedback_task;

    }

    $owner_group = array_pop(ClipitGroup::get_by_id(array($owner_group_id)));
    $comments = array_pop(ClipitComment::get_by_destination(
        array($entity->id),
        clipit_get_limit(),
        clipit_get_offset()
    ));
    switch($object['subtype']){
        // Clipit Video publication
        case 'ClipitVideo':
            $task_id = ClipitVideo::get_task($entity_id);
            $videos = ClipitTask::get_videos($task_id);
            if(!$entity || !in_array($entity_id, $videos)){
                return false;
            }
            $send_to_site = false;
            if(hasTeacherAccess($user->role)){
                $send_to_site = true;
            }
            $body = elgg_view("multimedia/video/body", array('entity'  => $entity));
            $content = elgg_view('publications/view', array(
                'entity' => $entity,
                'body' => $body,
                'send_site' => $send_to_site,
                'canEvaluate' => $canEvaluate,
                'feedback_task' => $feedback_task,
                'activity' => $activity,
                'group' => $owner_group,
                'comments' => $comments
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
                'feedback_task' => $feedback_task,
                'activity' => $activity,
                'comments' => $comments,
                'group' => $owner_group
            ));
            break;
        default:
            return false;
            break;
    }
} else {
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
}
elgg_push_breadcrumb($entity->name);

$params = array(
    'content'   => $content,
    'filter'    => $filter,
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);