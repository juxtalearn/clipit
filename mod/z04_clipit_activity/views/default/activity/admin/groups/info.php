<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/07/14
 * Last update:     17/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = get_input('entity');
$entities_id = get_input('entities');
?>
<?php
if($entities_id):
    $groups_progress = array();
    foreach($entities_id as $group_id){
        $groups_progress[$group_id] = get_group_progress($group_id);
    }
    echo json_encode($groups_progress);
    die;
elseif($entity_id):
    $group = array_pop(ClipitGroup::get_by_id(array($entity_id)));
    $tasks = ClipitActivity::get_tasks($group->activity);
?>
<div class="row">
    <div class="col-md-6">
        <h4>
            <?php echo elgg_echo('tags');?>
        </h4>
        <small class="show">
            <?php
            echo elgg_view('output/url', array(
                'href'  => "ajax/view/modal/group/assign_sb?group_id={$group->id}",
                'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('group:assign_sb'),
                'id' => 'assign-sb',
                'data-toggle'   => 'modal',
                'data-target'   => '#sb-group-'.$group->id
            ));
            ?>
        </small>
        <?php echo elgg_view("page/components/modal_remote", array('id'=> "sb-group-{$group->id}" ));?>
        <?php if($group->tag_array):?>
            <div class="tags-list margin-top-10">
                <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group->tag_array, 'width' => '40%')); ?>
            </div>
        <?php endif;?>
        <h4><?php echo elgg_echo('group:members');?></h4>
        <hr class="margin-0 margin-bottom-10">
        <ul class="scroll-list-400">
        <?php
        foreach($users = ClipitGroup::get_users($group->id) as $user_id):
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        ?>
        <li class="list-item">
            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'class' => 'image-block avatar-tiny',
                'alt' => 'avatar-tiny',
            ));
            ?>
            <div class="content-block">
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
        <?php echo elgg_view('activity/admin/tasks/summary', array(
            'tasks' => $tasks,
            'group' => $group->id,
            'users' => $users,
            'href' => "clipit_activity/{$group->activity}/tasks"
        ));?>
        <div style="display: none;">
            <h4 class="margin-top-20"><?php echo elgg_echo('group:graph');?></h4>
            <hr class="margin-0 margin-bottom-10">
            <?php echo elgg_view('group/graph');?>
        </div>
    </div>
</div>
<?php endif;?>