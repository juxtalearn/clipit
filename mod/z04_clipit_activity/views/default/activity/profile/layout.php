<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 11:33
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract("entity", $vars);
$access = elgg_extract("access", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user_inActivity = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
$tags = $tricky_topic->tag_array;

if($access == 'ACCESS_TEACHER'){
    $tasks = ClipitTask::get_by_id($activity->task_array, 0, 0, 'start', true);
    $groups = ClipitGroup::get_by_id($activity->group_array, 0, 0, 'name');
    natural_sort_properties($groups, 'name');
} else {
    $tasks = ClipitTask::get_by_id($activity->task_array, 0, 0, 'end', true);
//    end_date <= date()
    $tasks_filtered = array();
    foreach ($tasks as $task) {
        $status = get_task_status($task);
        if (time() < $task->start) {
            $num = 4;
        } else {
            switch($status['color']){
                case 'yellow':  $num = 1; break;
                case 'green':   $num = 2; break;
                case 'red':     $num = 3; break;
            }
        }
        $tasks_filtered[$num."_".$task->id] = $task;
    }
    ksort($tasks_filtered);
    $tasks = $tasks_filtered;
}
?>
<div class="row">
    <div class="col-md-12" data-shorten="true" style="overflow: hidden;max-height: 160px;">
        <p class="text-justify">
            <?php echo nl2br($activity->description);?>
        </p>
    </div>
</div>
<?php if($access == 'ACCESS_TEACHER' || $access == 'ACCESS_MEMBER'):?>
<div class="row">
    <div class="col-md-7">
        <?php if($access == 'ACCESS_TEACHER'):?>
            <h3 class="activity-module-title"><?php echo elgg_echo('activity:progress');?></h3>
            <?php echo elgg_view('activity/profile/admin/activity_progress', array('entity' => $activity));?>
        <?php endif;?>
        <h3 class="activity-module-title"><?php echo elgg_echo('activity:tasks');?></h3>
        <?php echo elgg_view("tasks/list", array(
            'tasks' => $tasks,
            'href' => "clipit_activity/{$activity->id}/tasks",
            'activity' => $activity,
            'style' => 'max-height: 200px;overflow: auto;'
        ));
        ?>
        <?php if($tasks): ?>
        <p class="text-right view-all">
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}/tasks",
                'title' => elgg_echo('view_all'),
                'text'  => elgg_echo('view_all')));
            ?>
        </p>
        <?php endif; ?>
    </div>
    <div class="col-md-5">
        <?php echo elgg_view("activity/profile/stumbling_block_module", array(
            'tags' => $tags,
            'tt' => $activity->tricky_topic
        ));?>
    </div>
</div>
<?php if($access == 'ACCESS_MEMBER'):?>
<div class="row">
    <div class="col-md-12">
        <?php echo elgg_view("activity/profile/related_videos_module");?>
    </div>
</div>
<?php endif;?>

<?php if($access == 'ACCESS_TEACHER'):?>
    <?php
        echo elgg_view('activity/profile/admin/groups', array(
            'entities' => $activity->group_array,
            'activity' => $activity,
        ));
    ?>
<?php endif;?>

<?php endif; ?>
