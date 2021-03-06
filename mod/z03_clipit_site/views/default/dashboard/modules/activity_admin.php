<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activities = elgg_extract('entities', $vars);
?>

<style>
.panel-blue > .panel-heading{
    background: transparent;
    padding: 0;
}
.panel-blue .panel-body{
    padding: 5px;
}
.panel-blue{
    /*border-bottom: 2px solid #bae6f6 !important;*/
}
</style>
<script>
$(function(){
    $(".task-view").click(function(){
        $(this).find('.collapse-icon').toggleClass('fa-chevron-down fa-chevron-up');
        var content = $(this).closest(".panel").find(".panel-body");
        if(content.find('.task-details').length == 0){
            content.html('<span class="blue-lighter"><i class="fa fa-spinner fa-spin fa-1x"></i> <?php echo elgg_echo('loading');?></span>');
            $.ajax({
                url: elgg.config.wwwroot+"ajax/view/dashboard/modules/activity_admin/task_list",
                type: "POST",
                data: { task_id : $(this).data("task")},
                success: function(html){
                    content.html(html);
                }
            });
        }
    });
});
</script>
<div class="separator">
<?php
foreach($activities as $activity):
    if($activity->status != 'closed'):
    $tasks = ClipitTask::get_by_id($activity->task_array);
    $activity_progress = round(((time() - $activity->start)/($activity->end - $activity->start)) * 100);
    if($activity_progress == 0){
        $activity_progress = 5;
    } elseif($activity_progress < 0){
        $activity_progress = 0;
    } elseif($activity_progress > 100){
    $activity_progress = 100;
}
?>
    <div style="background: #<?php echo $activity->color;?>;padding: 10px;color: #fff">
        <div class="pull-right">
            <small class="show text-right white" style="line-height: 5px;">
                <?php echo $activity_progress;?>%
            </small>
            <div class="progressbar-mini progressbar-blue inline-block">
                <div class="blue" data-value="<?php echo $activity_progress;?>" style="width: <?php echo $activity_progress;?>%"></div>
            </div>
        </div>
        <h4 class="margin-0">
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$activity->id}",
                'style' => 'color: #FFF;',
                'title' => $activity->name,
                'text'  => $activity->name,
                'name'  => elgg_echo('activity:number'),
            ));
            ?>
        </h4>
    </div>
    <div class="wrapper">
    <ul class="panel-group" id="accordion_<?php echo $activity->id;?>">
    <?php
    foreach($tasks as $task):
    ?>
        <li class="panel panel-blue list-item">
            <div class="panel-heading task-view" data-task="<?php echo $task->id;?>" style="cursor: pointer" data-toggle="collapse" data-parent="#accordion_<?php echo $activity->id;?>" href="#collapse_<?php echo $task->id;?>">
                <div class="pull-right margin-top-5">
                    <?php echo elgg_view("tasks/icon_task_status", array('status' => $task->status)); ?>
                    <i class="blue-lighter fa fa-chevron-down collapse-icon"></i>
                </div>
                <small class="pull-right hide">
                    <div class="progressbar-mini progressbar-blue inline-block">
                        <div class="<?php echo $progress_color;?>" data-value="<?php echo $completed_count['count'];?>" style="width: <?php echo $completed_count['count'];?>%"></div>
                    </div>
                    <strong class="inline-block blue margin-left-5"><?php echo $completed_count['text'];?></strong>
                </small>
                <span style="border-right: 1px solid #bae6f6;padding-right: 5px;margin-right: 5px;">
                    <?php echo elgg_view("tasks/icon_task_type", array('type' => $task->task_type)); ?>
                </span>
                <strong class="blue"><?php echo $task->name;?></strong>
                <small class="margin-bottom-10 hide">
                    <div class="pull-right">
                        <strong><?php echo elgg_echo('end');?>:</strong>
                        <?php echo elgg_view('output/friendlytime', array('time' => $task->end));?>
                    </div>
                    <div>
                        <strong><?php echo elgg_echo('start');?>:</strong>
                        <?php echo elgg_view('output/friendlytime', array('time' => $task->start));?>
                    </div>
                </small>
            </div>
            <div id="collapse_<?php echo $task->id;?>" class="panel-collapse collapse ">
                <div class="panel-body"></div>
            </div>
        </li>


    <?php endforeach;?>
    </ul>
    </div>
    <?php endif;?>
<?php endforeach;?>
</div>