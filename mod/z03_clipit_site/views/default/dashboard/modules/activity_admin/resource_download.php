<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/02/2015
 * Last update:     26/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$task = elgg_extract('task', $vars);
$users = elgg_extract('users', $vars);
$users = ClipitUser::get_by_id($users, 0, 0, 'name');
?>
<ul>
    <?php foreach($users as $user):?>
        <li class="list-item-5" data-entity="<?php echo $user->id;?>">
            <?php if(ClipitTask::get_completed_status($task->id, $user->id)):?>
                <i class="fa fa-check green" title="<?php echo elgg_echo('task:completed');?>"></i>
            <?php elseif($task->status == ClipitTask::STATUS_ACTIVE):?>
                <i class="fa fa-minus yellow" title="<?php echo elgg_echo('task:pending');?>"></i>
            <?php else: ?>
                <i class="fa fa-times red"></i>
            <?php endif;?>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/{$user->login}",
                'title' => $user->name,
                'text'  => $user->name,
            ));
            ?>
        </li>
    <?php endforeach;?>
</ul>