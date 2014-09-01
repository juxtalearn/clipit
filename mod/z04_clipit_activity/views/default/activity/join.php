<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 24/02/14
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract("entity", $vars);
$groups_id = ClipitActivity::get_groups($activity->id);
$user_owner = elgg_get_logged_in_user_guid();
$user_group = ClipitGroup::get_from_user_activity($user_owner, $activity->id);
?>
<div class="row">
<?php foreach($groups_id as $group_id):
    $users_id = ClipitGroup::get_users($group_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    $optGroup = false;
    $optButton = false;
    if(!$user_group){
        $optGroup = "join";
    }elseif($user_group == $group_id){
         $optGroup = "leave";
    }
    if($optGroup){
        $optButton = elgg_view_form('group/'.$optGroup,
            array('class'   => 'pull-right'),
            array('entity'  => $group)
        );
    }
?>

    <div class="col-md-6 col-lg-4 group-info">
        <div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px; ">
    <!-- Button group join/leave -->
    <?php echo $optButton;?>
    <h3 class='title-bold'><?php echo $group->name;?></h3>
    <?php if(count($users_id) > 0):?>
        <ul style="height: 150px;overflow-y: auto;" class="member-list">
        <?php
        foreach($users_id as $user_id):
            $user = array_pop(ClipitUser::get_by_id(array($user_id)));
        ?>
            <li class="list-item">
                <?php echo elgg_view("page/elements/user_block", array("entity" => $user)); ?>
            </li>
        <?php endforeach;?>
        </ul>
    <?php endif; ?>
    </div>
</div>
<?php endforeach;?>
</div>