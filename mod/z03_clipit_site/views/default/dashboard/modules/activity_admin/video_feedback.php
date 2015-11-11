<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$users = elgg_extract('users', $vars);
$users = ClipitUser::get_by_id($users);
$task = elgg_extract('task', $vars);
?>
<?php
foreach($users as $user):
    $status = get_task_status($task, 0, $user->id);
    ?>
    <li class="list-item-5">
        <?php if(ClipitTask::get_completed_status($task->id, $user->id)):?>
        <small class="pull-right margin-right-5">
            <?php echo elgg_view('output/url', array(
                'href'  => "clipit_activity/{$task->activity}/tasks/view/{$task->id}#{$user->id}",
                'title' => elgg_echo('view:feedback'),
                'text'  => elgg_echo('view'),
            ));
            ?>
        </small>
        <?php endif;?>
        <div class="text-truncate">
            <?php echo $status['icon']; ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/{$user->login}",
                'title' => $user->name,
                'text'  => $user->name,
            ));
            ?>
        </div>
    </li>
<?php endforeach;?>