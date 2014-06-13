<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 11:33
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract("entity", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user_inActivity = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));
$tags = $tricky_topic->tag_array;
$tasks = array_slice($activity->task_array, 0, 4);
?>
<div class="row">
    <div class="col-md-12" data-shorten="true" style="overflow: hidden;max-height: 160px;">
        <p class="text-justify">
            <?php echo $activity->description;?>
        </p>
    </div>
</div>
<?php if($user_inActivity):?>
<div class="row">
    <div class="col-md-7">
        <h3 class="activity-module-title"><?php echo elgg_echo('activity:tasks');?></h3>
        <?php echo elgg_view("tasks/list", array(
            'tasks' => $tasks,
            'href' => "clipit_activity/{$activity->id}/tasks",
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
        <?php echo elgg_view("activity/profile/stumbling_block_module", array('tags' => $tags));?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo elgg_view("activity/profile/related_videos_module");?>
    </div>
</div>
<?php endif; ?>
