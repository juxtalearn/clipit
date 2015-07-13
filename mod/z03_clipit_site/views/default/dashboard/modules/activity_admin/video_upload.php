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
natural_sort_properties($groups, 'name');
$task = elgg_extract('task', $vars);
?>
<?php
foreach($groups as $group):
    $status = get_task_status($task, $group->id);
?>
    <li class="list-item-5">
        <?php
        if($video_id = $status['result']):
            $video = array_pop(ClipitVideo::get_by_id(array($video_id)));
            ?>
            <small class="pull-right">
                <?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?>
            </small>
        <?php endif;?>
        <div class="text-truncate">
            <?php echo $status['icon']; ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$task->activity}/group/{$group->id}",
                'title' => $group->name,
                'text'  => $group->name,
            ));
            ?>
        </div>
        <?php if($video_id):?>
            <small>
                <i class="fa fa-level-up blue-lighter fa-rotate-90 margin-left-20 margin-right-5" style="font-size: 21px;"></i>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}/publications/view/{$video->id}",
                    'title' => elgg_echo('view'),
                    'class' => 'btn btn-primary btn-xs pull-right',
                    'text'  => '<i class="fa fa-youtube-play"></i>',
                ));
                ?>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "clipit_activity/{$task->activity}/publications/view/{$video->id}",
                    'title' => elgg_echo('view'),
                    'text'  => $video->name,
                ));
                ?>
                </strong>
            </small>
        <?php endif;?>
    </li>
<?php endforeach;?>
