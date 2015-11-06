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
$activity = elgg_extract('entity', $vars);
$start = $activity->start;
$end = $activity->end;
// (today - start) / (end - start) * 100
$activity_progress = round(((time() - $start)/($end - $start)) * 100);
if($activity_progress < 0){
    $activity_progress = 0;
}
?>
<div style="position: relative;" class="overflow-hidden">
    <?php echo elgg_view("page/components/progressbar", array(
        'value' => $activity_progress,
        'width' => '100%',
    ));
    ?>
    <?php
    foreach(ClipitTask::get_by_id($activity->task_array) as $task):
        $task_progress = round((($task->start - $start)/($end - $start)) * 100);
        ?>
        <div style="position: absolute; top:0; left: <?php echo $task_progress+0.3;?>%">
            <?php echo elgg_view('output/url', array(
                'title' =>  elgg_echo('activity:task'). ": ".$task->name,
                'text' => '',
                'style' => "opacity: 0.7;".($activity_progress > $task_progress ? "color:#fff;": ""),
                'class' => 'fa fa-exclamation',
                'href' => "clipit_activity/{$activity->id}/tasks/view/{$task->id}",
                'aria-label' => elgg_echo('activity:task'). ": ".$task->name,
                'aria-describedby' => elgg_echo('activity:progress'),
            ));
            ?>
        </div>
    <?php endforeach;?>
</div>
<small class="show margin-top-5">
    <strong><?php echo elgg_echo('start');?>: </strong>
    <?php echo elgg_view('output/friendlytime', array('time' => $activity->start));?>
    <span class="pull-right">
        <strong><?php echo elgg_echo('end');?>: </strong>
        <?php echo elgg_view('output/friendlytime', array('time' => $activity->end));?>
    </span>
</small>