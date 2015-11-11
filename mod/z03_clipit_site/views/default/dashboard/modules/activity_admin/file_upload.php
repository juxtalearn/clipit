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
    if($file_id = $status['result']):
        $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    ?>
        <small class="pull-right">
            <?php echo elgg_view('output/friendlytime', array('time' => $file->time_created));?>
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
    <?php if($file_id):?>
        <small>
            <i class="fa fa-level-up blue-lighter fa-rotate-90 margin-left-20 margin-right-5" style="font-size: 21px;"></i>
            <?php echo elgg_view('output/url', array(
                'href'  => 'file/download/'.$file->id,
                'title' => elgg_echo('download'),
                'class' => 'btn btn-primary btn-xs pull-right',
                'text'  => '<i class="fa fa-download"></i>',
            ));
            ?>
            <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$task->activity}/publications/view/{$file->id}",
                'text'  => $file->name,
            ));
            ?>
            </strong>
        </small>
    <?php endif;?>
</li>
<?php endforeach;?>