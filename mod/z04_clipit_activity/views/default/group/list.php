<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('entity', $vars);

$groups_id = ClipitActivity::get_groups($activity->id);
$groups = ClipitGroup::get_by_id($groups_id, 0, 0, 'name');
natural_sort_properties($groups, 'name');
$user_id = elgg_get_logged_in_user_guid();
$user_group = ClipitGroup::get_from_user_activity($user_id, $activity->id);
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$isCalled = in_array($user_id, $activity->student_array);
// Get ungrouped students
$ungruped_students = array();
foreach($activity->student_array as $student_id){
    if(!ClipitGroup::get_from_user_activity($student_id, $activity->id)){
        $ungrouped_students[] = array_pop(ClipitUser::get_by_id(array($student_id)));
    }
}
?>
<style>
    .group-details .tags-list{
        height: 30px;
    }
    .group-details .tags-list .tags{
        margin: 0;
    }
</style>

<?php if(count($ungrouped_students) > 0):?>
<h3 class="margin-bottom-20"><?php echo elgg_echo('group:ungrouped');?></h3>
<div style="border-bottom: 6px solid #bae6f6;max-height:400px;overflow-y:auto;overflow-x:hidden;padding-bottom: 15px;">
    <ul class="row">
        <?php foreach($ungrouped_students as $ungrouped_student):?>
            <li class="list-item col-md-3">
                <?php echo elgg_view("page/elements/user_block", array("entity" => $ungrouped_student)); ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<div class="row groups-list">
    <?php
    $group_students = array();
    $total_groups = count($groups);
    foreach($groups as $group):
        $students_id = ClipitGroup::get_users($group->id);
        $students = ClipitUser::get_by_id($students_id, 0, 0, 'name');
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
        <div class="<?php echo $total_groups > 6 ? 'col-md-4':'col-md-6';?>">
            <div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px;">
                <?php echo $optButton;?>
                <?php echo elgg_view('output/url', array(
                    'text'  => '',
                    'data-toggle' => 'collapse',
                    'href' => '#group_'.$group->id,
                    'class' => 'fa fa-angle-down pull-right fa-2x visible-xs',
                ));
                ?>
                <?php if(hasTeacherAccess($user->role)):?>
                    <?php echo elgg_view('output/url', array(
                        'href' => "clipit_activity/$activity->id/admin?filter=groups#edit-groups",
                        'title' => elgg_echo('edit'),
                        'text' => elgg_echo('edit'),
                        'class' => 'btn btn-xs btn-border-blue btn-default margin-right-10 pull-right',
                        'target' => '_blank',
                    ));
                    ?>
                <?php endif;?>
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
                <ul class="group-students" style="height: 250px !important;overflow-y: auto;" id="group_<?php echo $group->id; ?>">
                    <?php foreach($students as $student):?>
                        <li class="list-item">
                            <?php echo elgg_view("page/elements/user_block", array("entity" => $student)); ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endforeach ?>
</div>