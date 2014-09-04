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
$activity_id =  (int)elgg_get_page_owner_guid();
$groups_id = ClipitActivity::get_groups($activity_id);
?>

<div class="row">
<?php
foreach($groups_id as $group_id):
    $users_id = ClipitGroup::get_users($group_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
?>
    <div class="col-md-6">
        <div style="border-bottom: 6px solid #bae6f6; padding-bottom: 15px;">
            <h3><?php echo $group->name; ?></h3>
            <ul style="height: 250px;overflow-y: auto;">
                <?php
                foreach($users_id as $user_id):
                    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
                ?>
                    <li class="list-item">
                        <?php echo elgg_view("page/elements/user_block", array("entity" => $user)); ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endforeach ?>

</div>
