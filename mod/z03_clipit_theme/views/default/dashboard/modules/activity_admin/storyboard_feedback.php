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
$users = elgg_extract('users', $vars);
$users = ClipitUser::get_by_id($users);
$task = elgg_extract('task', $vars);
?>
<?php
foreach($users as $user):
    $status = get_task_status($task, 0, $user->id);
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
<!--        <small class="pull-right margin-right-5">-->
<!--            --><?php //echo elgg_view('output/url', array(
//                'href'  => "clipit_activity/{$activity_id}/publications/view/{$storyboard->id}",
//                'title' => elgg_echo('view:storyboard'),
//                'text'  => elgg_echo('view'),
//            ));
//            ?>
<!--        </small>-->
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
