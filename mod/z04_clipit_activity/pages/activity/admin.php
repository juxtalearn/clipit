<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/09/14
 * Last update:     9/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if($user->role == 'student' || $access != 'ACCESS_TEACHER'){
    return false;
}
$title = elgg_echo('activity:admin');
$href = "clipit_activity/{$activity->id}/admin";
$selected_tab = get_input('filter', 'setup');
$filter = elgg_view('activity/admin/filter', array('selected' => $selected_tab, 'href' => $href));
// dashboard, default admin view
switch($selected_tab){
    case 'tasks':
        $content = elgg_view('activity/admin/tasks/view', array('entity' => $activity));
        break;
    case 'setup':
        $setup_view = elgg_view('activity/admin/setup', array('entity' => $activity));
        $content = elgg_view_form('activity/admin/setup', array('body' => $setup_view));
        break;
    case 'groups':
        $content = elgg_view('activity/admin/groups/view', array('entity' => $activity));
        break;
    case 'videos':
        $content = elgg_view('activity/admin/videos', array('videos' => $videos));
        $tasks = ClipitTask::get_by_id($activity->task_array);
        $href = 'clipit_activity/'.$activity->id.'/publications';
        $content = '';
//        for($i=0;$i<25; $i++) {
//            ClipitComment::create(array(
//                'name' => '',
//                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu semper orci. Integer et tortor nunc. Maecenas justo ex, tincidunt non nibh et, sagittis fringilla justo. Etiam ultricies, enim mattis condimentum viverra, diam est dignissim ex, at pretium sapien elit ac ipsum. Sed porta tellus quis sapien imperdiet semper. Vivamus sed mauris id turpis tincidunt pretium. Cras consequat efficitur sem id egestas. ',
//                'destination' => 579
//            ));
//        }
        foreach($tasks as $task){
            $videos = array();
            if($task->task_type == ClipitTask::TYPE_VIDEO_UPLOAD) {
                $videos = ClipitTask::get_videos($task->id);
                if($videos) {
                    $content .= elgg_view('page/components/title_block', array('title' => $task->name));
//                    $content .= elgg_view('multimedia/video/list', array(
//                        'entities' => $videos,
//                        'href' => $href,
//                        'total_comments' => true,
//                        'rating'    => true,
//                        'send_site' => true,
//                        'href_site' => 'clipit_activity/'.$activity->id.'/admin/publish/'
//                    ));
                    $content .= elgg_view('multimedia/video/list_summary', array(
                        'videos' => $videos,
                        'href' => $href,
                        'preview' => false,
                        'total_comments' => true,
                        'rating'    => true,
                        'send_site' => true,
                        'author_bottom' => true,
                        'href_site' => 'clipit_activity/'.$activity->id.'/admin/publish/'
                    ));
                }
            }
        }
        break;
    case 'rubric':
        $content = elgg_view('activity/admin/assessment_rubric/view', array('entity' => $activity));
        break;
}
// Publish to Site
if($page[2] == 'publish' && $id = $page[3]){
    $entity = array_pop(ClipitVideo::get_by_id(array($id)));
    $content = elgg_view_form('publications/publish', array('data-validate'=> "true" ),
        array(
            'entity'  => $entity,
            'parent_id' => $group->id,
            'activity' => $activity,
            'tags' => $tags,
            'entity_preview' => $entity_preview
        ));
}

$params = array(
    'content'   => $content,
    'filter'    => $filter,
    'class' => "activity-section activity-layout activity-admin-section",
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);