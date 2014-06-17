<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/05/14
 * Last update:     29/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function view_recommended_event($event, $view_type = 'full'){
    $relationship = get_relationship($event->object_id);
    switch($relationship->relationship){
        case "activity-video":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitVideo::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/materials";
            $params = array(
                'title' => 'Teacher added new video to materials',
                'icon' => 'fa-video-camera',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/video", array('entity' => $entity, 'href' => $href, 'rating' => false))
            );
            break;
        case "activity-file":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/materials/view/{$entity->id}";
            $params = array(
                'title' => 'Teacher added new file to materials',
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $entity)
                    )))
            );
            break;
        case "activity-storyboard":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitStoryboard::get_by_id(array($relationship->guid_two)));
            $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
            $href = "clipit_activity/{$activity->id}/materials/view/{$entity->id}";
            $params = array(
                'title' => 'Teacher added new storyboard to materials',
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $file)
                    )))
            );
            break;
        case "activity-user":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitUser::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/materials/view/{$entity->id}";
            $params = array(
                'title' => 'User called',
                'icon' => 'fa-bullhorn',
                'author' => $entity->owner_id,
                'body' => ''
            );
            break;
        case "activity-group":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitGroup::get_by_id(array($relationship->guid_two)));
            $activity_link = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}",
                'title' => $activity->name,
                'text'  => $activity->name,
            ));
            $params = array(
                'title' => 'Group added to activity <strong class="show">'.$activity_link.'</strong>',
                'icon' => 'fa-bullhorn',
                'author' => $entity->id,
                'body' => ''
            );
            break;
        case "activity-task":
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitTask::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/task";
            $task_link = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}/tasks/view/{$entity->id}",
                'title' => $entity->name,
                'text'  => $entity->name,
            ));
            $params = array(
                'title' => 'Added new task <strong>'.$task_link.'</strong>',
                'icon' => 'fa-tasks',
                'author' => $activity->id,
                'body' => ''
            );
            break;
        case "group-video":
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $entity = array_pop(ClipitVideo::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/group/{$relationship->guid_one}/multimedia";
            $params = array(
                'title' => 'Added new video to group',
                'icon' => 'fa-video-camera',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/video", array('entity' => $entity, 'href' => $href, 'rating' => false))
            );
            break;
        case "group-file":
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $entity = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/group/{$relationship->guid_one}/multimedia/view/{$entity->id}";
            $params = array(
                'title' => 'Added new file to group',
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $entity)
                    )))
            );
            break;
        case "group-storyboard":
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $entity = array_pop(ClipitStoryboard::get_by_id(array($relationship->guid_two)));
            $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
            $href = "clipit_activity/{$activity->id}/group/{$relationship->guid_one}/multimedia/view/{$entity->id}";
            $params = array(
                'title' => 'Added new storyboard to group',
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $file)
                    )))
            );
            break;
        case "message-destination":
            // Message from group|activity
            $object = ClipitSite::lookup($relationship->guid_two);
            $entity = array_pop(ClipitPost::get_by_id(array($relationship->guid_one)));
            switch($object['subtype']){
                case "ClipitGroup":
                    $activity_id = ClipitGroup::get_activity($relationship->guid_two);
                    $group = "group/{$relationship->guid_two}/";
                    break;
                case "ClipitActivity":
                    $activity_id = $relationship->guid_two;
                    $group = "";
                    break;
            }
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $href = "clipit_activity/{$activity->id}/{$group}discussion/view/{$entity->id}";
            $params = array(
                'title' => 'Added a new discussion topic',
                'icon' => 'fa-comment',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/discussion", array('entity' => $entity,'href' => $href))
            );
            break;
        case "group-user":
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $group = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitUser::get_by_id(array($relationship->guid_two)));
            $group_info = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}/group/{$group->id}",
                'title' => $group->name,
                'text'  => $group->name,
            ));
            $params = array(
                'title' => 'joined the group <strong>'.$group_info.'</strong>',
                'icon' => 'fa-user',
                'author' => $entity->id,
                'body' => ''
            );
            break;
    }
    // Output
    if($entity && $activity){
        switch($view_type){
            case "full":
                return elgg_view("recommended/events/section", array_merge(
                    $params,
                    array(
                        'time_created' => $relationship->time_created,
                        'activity' => $activity
                    )
                ));
                break;
            case "simple":
                return elgg_view("recommended/events/section_simple", array_merge(
                    $params,
                    array(
                        'time_created' => $relationship->time_created,
                        'activity' => $activity
                    )
                ));
                break;
        }

    }
}
