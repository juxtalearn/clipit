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
        case ClipitActivity::REL_ACTIVITY_VIDEO:
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitVideo::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/resources";
            $params = array(
                'title' => elgg_echo('teacher:addedresource') /*'Teacher added new video to resources'*/,
                'icon' => 'fa-video-camera',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/video", array('entity' => $entity, 'href' => $href, 'rating' => false))
            );
            break;
        case ClipitActivity::REL_ACTIVITY_FILE:
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/resources/view/{$entity->id}";
            $params = array(
                'title' => elgg_echo('teacher:addedresource') /*'Teacher added new file to resources' */,
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $entity)
                    )))
            );
            break;
        case ClipitActivity::REL_ACTIVITY_STUDENT:
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitUser::get_by_id(array($relationship->guid_two)));
            $activity_link = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}",
                'title' => $activity->name,
                'text'  => $activity->name,
            ));
            $params = array(
                'title' => elgg_echo ('activity:invited') . "" . /*'Called for '*/ ' ' .$activity_link,
                'icon' => 'fa-bullhorn',
                'author' => $entity->owner_id,
                'body' => ''
            );
            break;
        case ClipitActivity::REL_ACTIVITY_GROUP:
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitGroup::get_by_id(array($relationship->guid_two)));
            $activity_link = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}",
                'title' => $activity->name,
                'text'  => $activity->name,
            ));
            $params = array(
                'title' => elgg_echo('group:added'). /* 'Group added to activity'  */ ': <strong class="show">'.$activity_link.'</strong>',
                'icon' => 'fa-bullhorn',
                'author' => $entity->id,
                'body' => ''
            );
            break;
        case ClipitActivity::REL_ACTIVITY_TASK:
            $activity = array_pop(ClipitActivity::get_by_id(array($relationship->guid_one)));
            $entity = array_pop(ClipitTask::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/task";
            $task_link = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}/tasks/view/{$entity->id}",
                'title' => $entity->name,
                'text'  => $entity->name,
            ));
            $params = array(
                'title' => elgg_echo('task:added'). /*'Added new task */': <strong>'.$task_link.'</strong>',
                'icon' => 'fa-tasks',
                'author' => $activity->id,
                'body' => ''
            );
            break;
        case ClipitGroup::REL_GROUP_VIDEO:
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $entity = array_pop(ClipitVideo::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/group/{$relationship->guid_one}/repository";
            $params = array(
                'title' => elgg_echo ('video:uploaded'), //Added new video to group',
                'icon' => 'fa-video-camera',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/video", array('entity' => $entity, 'href' => $href, 'rating' => false))
            );
            break;
        case ClipitGroup::REL_GROUP_FILE:
            $activity_id = ClipitGroup::get_activity($relationship->guid_one);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $entity = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/group/{$relationship->guid_one}/repository/view/{$entity->id}";
            $params = array(
                'title' => elgg_echo('multimedia:file_uploaded'), //'Added new file to group',
                'icon' => 'fa-file',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $entity)
                    )))
            );
            break;

        case ClipitPost::REL_MESSAGE_DESTINATION:
            // Message from group|activity
            $object = ClipitSite::lookup($relationship->guid_two);
            switch($object['subtype']){
                case "ClipitGroup":
                    $activity_id = ClipitGroup::get_activity($relationship->guid_two);
                    $group = "group/{$relationship->guid_two}/";
                    break;
                case "ClipitActivity":
                    $activity_id = $relationship->guid_two;
                    $group = "";
                    break;
                default:
                    return false;
                    break;
            }
            $entity = array_pop(ClipitPost::get_by_id(array($relationship->guid_one)));
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $href = "clipit_activity/{$activity->id}/{$group}discussion/view/{$entity->id}";
            $params = array(
                'title' => elgg_echo('discussion:created'), //'Added a new discussion topic',
                'icon' => 'fa-comment',
                'author' => $entity->owner_id,
                'body' => elgg_view("recommended/events/discussion", array('entity' => $entity,'href' => $href))
            );
            break;
        case ClipitGroup::REL_GROUP_USER:
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
                'title' => elgg_echo('group:joined').': <strong>'.$group_info.'</strong>',
                'icon' => 'fa-user',
                'author' => $entity->id,
                'body' => ''
            );
            break;
        // Tasks
        case ClipitTask::REL_TASK_FILE:
            $activity_id = ClipitStoryboard::get_activity($relationship->guid_two);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $group_id = ClipitStoryboard::get_group($relationship->guid_two);
            $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
            $entity = array_pop(ClipitStoryboard::get_by_id(array($relationship->guid_two)));
            $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
            $href = "clipit_activity/{$activity->id}/publications/view/{$entity->id}";
            $storyboard_info = elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}/tasks/view/{$relationship->guid_one}",
                'title' => $entity->name,
                'text'  => $entity->name,
            ));
            $params = array(
                'title' => elgg_echo('task:file_upload') .' '.$storyboard_info,
                'icon' => 'fa-file',
                'author' => $group->id,
                'body' => elgg_view("recommended/events/file", array(
                    'entity' => $entity,
                    'href' => $href,
                    'image' => elgg_view("multimedia/file/preview", array('file'  => $file)
                    )))
            );
            break;
        case ClipitTask::REL_TASK_VIDEO:
            $activity_id = ClipitVideo::get_activity($relationship->guid_two);
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $group_id = ClipitVideo::get_group($relationship->guid_two);
            $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
            $entity = array_pop(ClipitVideo::get_by_id(array($relationship->guid_two)));
            $href = "clipit_activity/{$activity->id}/publications";
            $params = array(
                'title' => elgg_echo ('video:uploaded'), //Added new video to group',
                'icon' => 'fa-video-camera',
                'author' => $group->id,
                'body' => elgg_view("recommended/events/video", array('entity' => $entity, 'href' => $href, 'rating' => false))
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
