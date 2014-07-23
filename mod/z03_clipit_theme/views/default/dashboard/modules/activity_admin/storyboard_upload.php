<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$groups = elgg_extract('groups', $vars);
$groups = ClipitGroup::get_by_id($groups);
$task = elgg_extract('task', $vars);
//$entities = elgg_extract('entities', $vars);
//$storyboards = ClipitStoryboard::get_by_id($entities);
        $users_completed = count($task->storyboard_array)."/".count($activity->group_array);
        $task_progress = (count($task->storyboard_array)/count($activity->group_array)) * 100;
        $completed_count = get_task_completed_count($task);
        $progress_color = "blue";
        if($completed_count['count'] > 50 ){
            $progress_color = "yellow";
            if($completed_count['count'] == 100){
                $progress_color = "green";
            }
        }
?>
<small class="margin-bottom-10 show">

    <div class="align-left margin-bottom-5" style="
    float: right;
    margin-top: 5px;
">
        <div class="progressbar-mini progressbar-blue inline-block">
            <div class="blue" data-value="22" style="width: 22%"></div>
        </div>
        <strong class="inline-block blue margin-left-5">2/9</strong>
    </div><div>
        <strong>End:</strong>
        <abbr title="25 July 2014 @ 12:00am">tomorrow</abbr>                    </div>
    <div>
        <strong>Start:</strong>
        <abbr title="21 July 2014 @ 12:00am">3 days ago</abbr>                    </div>
</small>
<small class="show text-left margin-bottom-5" style="display: none !important;">
    <div class="progressbar-mini progressbar-blue inline-block">
        <div class="<?php echo $progress_color;?>" data-value="<?php echo $completed_count['count'];?>" style="width: <?php echo $completed_count['count'];?>%"></div>
    </div>
</small>
<ul>
    <?php
    foreach($groups as $group):
        $status = get_task_status($task, $group->id);
    ?>
    <li class="list-item-5">
        <?php
        if($storyboard_id = $status['result']):
            $storyboard = array_pop(ClipitStoryboard::get_by_id(array($storyboard_id)));
        ?>
            <small class="pull-right">
                <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
<!--                --><?php //echo elgg_view('output/url', array(
//                    'href'  => "clipit_activity/{$activity_id}/publications/view/{$storyboard->id}",
//                    'title' => elgg_echo('view:storyboard'),
//                    'text'  => elgg_echo('view'),
//                ));
//                ?>
            </small>
        <?php endif;?>
        <div class="text-truncate">
            <?php echo $status['icon']; ?>
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}/group/{$group->id}",
                    'title' => $group->name,
                    'text'  => $group->name,
                ));
                ?>
            </strong>
        </div>
        <?php if($storyboard_id):?>
            <small>
                <i class="fa fa-level-up blue-lighter fa-rotate-90 margin-left-20 margin-right-5" style="font-size: 21px;"></i>
                <?php echo elgg_view('output/url', array(
                    'href'  => 'file/download/'.$storyboard->file,
                    'title' => elgg_echo('download'),
                    'class' => 'btn btn-primary btn-xs pull-right',
                    'text'  => '<i class="fa fa-download"></i>',
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}/publications/view/{$storyboard->id}",
                    'title' => elgg_echo('view:storyboard'),
                    'text'  => $storyboard->name,
                ));
                ?>
            </small>
        <?php endif;?>
    </li>
    <?php endforeach;?>
</ul>
<ul style="display: none;">
<?php
foreach($storyboards as $storyboard):
    $activity_id = ClipitStoryboard::get_activity($storyboard->id);
    // get group
    $group_id = ClipitStoryboard::get_group($storyboard->id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    unset($total[$group_id]);
?>
    <li class="list-item">
        <?php echo elgg_view("group/preview", array('entity' => $group, 'class' => 'pull-right'));?>
        <?php echo elgg_view('output/url', array(
            'href'  => "clipit_activity/{$activity_id}/publications/view/{$storyboard->id}",
            'title' => $storyboard->name,
            'text'  => $storyboard->name,
        ));
        ?>
    </li>
<?php endforeach;?>
</ul>
