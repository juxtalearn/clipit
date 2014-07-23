<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/07/14
 * Last update:     17/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$group_id = get_input('group_id');
$group = array_pop(ClipitGroup::get_by_id(array($group_id)));
$tasks = ClipitActivity::get_tasks($group->activity);
?>
<div class="row">
    <div class="col-md-6">
        <h4><?php echo elgg_echo('group:members');?></h4>
        <hr class="margin-0 margin-bottom-10">
        <ul>
        <?php
        foreach($users = ClipitGroup::get_users($group->id) as $user_id):
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        ?>
        <li class="list-item">
            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'class' => 'image-block avatar-tiny'
            ));
            ?>
            <div class="content-block">
                <?php echo elgg_view('output/url', array(
                    'text' => '<i class="fa fa-info blue"></i>',
                    'href' => "profile/{$user->login}?view_as=teacher&group_id={$group_id}",
                    'target' => '_blank',
                    'style' => 'padding-left: 10px;padding-right: 10px;',
                    'class' => "pull-right btn btn-xs btn-primary btn-blue-lighter",
                ));
                ?>
                <?php echo elgg_view("messages/compose_icon", array('entity' => $user));?>
                <?php echo elgg_view('output/url', array(
                    'title' => $user->name,
                    'text' => $user->name,
                    'href' => "profile/{$user->login}",
                ));
                ?>
            </div>
        </li>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="col-md-6">
        <h4><?php echo elgg_echo('activity:tasks');?></h4>
        <hr class="margin-0 margin-bottom-10">
        <?php echo elgg_view('activity/admin/dashboard/tasks', array(
            'tasks' => $tasks,
            'group' => $group->id,
            'users' => $users,
            'href' => "clipit_activity/{$group->activity}/tasks"
        ));?>
        <h4 class="margin-top-20"><?php echo elgg_echo('group:graph');?></h4>
        <hr class="margin-0 margin-bottom-10">
        <?php echo elgg_view('activity/admin/dashboard/group_graph');?>
    </div>
</div>