<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);

$groups_id = ClipitActivity::get_groups($activity->id);
$groups = ClipitGroup::get_by_id($groups_id, 0, 0, 'name');
$user_id = elgg_get_logged_in_user_guid();
$user_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$isCalled = in_array($user_id, $activity->student_array);
?>
<style>
    .group-details .tags-list{
        height: 30px;
    }
    .group-details .tags-list .tags{
        margin: 0;
    }
</style>
<h3 class="margin-bottom-20">Sin agrupar</h3>
<div style="border-bottom: 6px solid #bae6f6;max-height:400px;overflow-y:auto;overflow-x:hidden;padding-bottom: 15px;">
    <ul class="row">
        <?php
        foreach($activity->student_array as $student_id):
            if(!ClipitGroup::get_from_user_activity($student_id, $activity->id)):
                $student = array_pop(ClipitUser::get_by_id(array($student_id)));
        ?>
            <li class="list-item col-md-3">
                <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
            </li>
        <?php
            endif;
        endforeach;
        ?>
    </ul>
</div>
<div class="row">
    <?php
    $group_students = array();
    foreach($groups as $group):
        $students_id = ClipitGroup::get_users($group->id);
        $group_students[] = array_merge($group_students, $students_id);
        $rest = $activity->max_group_size - count(ClipitGroup::get_users($group->id));
        if(($user->role == ClipitUser::ROLE_STUDENT || $user->role == ClipitUser::ROLE_ADMIN)
            && $isCalled
            && $activity->status != ClipitActivity::STATUS_CLOSED
            && $activity->group_mode == ClipitActivity::GROUP_MODE_STUDENT
        ) {
            $optGroup = false;
            $optButton = false;
            if (!$user_group) {
                $optGroup = "join";
            } elseif ($user_group == $group->id) {
                $optGroup = "leave";
            }
            if ($optGroup) {
                $optButton = elgg_view_form('group/' . $optGroup,
                    array('class' => 'pull-right'),
                    array('entity' => $group)
                );
            }
        }
        ?>
        <div class="col-md-6">
            <div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px;">
                <?php echo $optButton;?>
                <h3 class="margin-bottom-5"><?php echo $group->name; ?></h3>
                <div class="group-details">
                    <?php if($optGroup == 'join' && $rest > 0):?>
                        <small class="show">
                            <?php echo elgg_echo('group:free_slot', array($rest));?>
                        </small>
                    <?php endif;?>
                    <div class="tags-list margin-top-10">
                        <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $group->tag_array, 'limit' => 4, 'width' => '22%')); ?>
                    </div>
                </div>
                <ul style="height: 250px;overflow-y: auto;">
                    <?php
                    foreach($students_id as $student_id):
                        $student = array_pop(ClipitUser::get_by_id(array($student_id)));
                        ?>
                        <li class="list-item">
                            <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endforeach ?>
</div>