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
$my_groups_ids = ClipitUser::get_groups(elgg_get_logged_in_user_guid());
foreach($my_groups_ids as $group_id){
    $activity_ids[] = ClipitGroup::get_activity($group_id);
}

$activities = ClipitActivity::get_by_id($activity_ids);
$task_found = false;
foreach($activities as $activity):
    foreach(ClipitTask::get_by_id($activity->task_array) as $task):
        $status = get_task_status($task);
        if($task->start <= time() && $task->end >= time()):
            $task_found = true;
            $activity = array_pop(ClipitActivity::get_by_id(array($task->activity)));
            $content .= '
            <div class="separator wrapper">
                '.elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}",
                    'title' => $activity->name,
                    'style' => 'background: #'.$activity->color,
                    'class' => 'point',
                    'text'  => '',
                )).'
                '.elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}",
                    'title' => $task->name,
                    'text'  => $status['count']." ".$task->name,
                )).'
                <small class="pull-right" style="text-transform:uppercase">'.date("d M Y", $task->end).'</small>
            </div>';
        endif;
    endforeach;
endforeach;
if(!$task_found):
    $content = '<div class="separator wrapper">
                    <small><strong>'.elgg_echo('task:no_pending').'</strong></small>
                </div>';
endif;

$all_link = elgg_view('output/url', array(
    'href' => "linkHref",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
));
echo elgg_view('landing/module', array(
    'name'      => "pending",
    'title'     => "Pending",
    'content'   => $content,
    'all_link'  => $all_link,
));