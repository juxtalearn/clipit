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
$group =  elgg_extract('entity', $vars);
$users_id = ClipitGroup::get_users($group->id);
$activity_status = array_pop(ClipitActivity::get_status(elgg_get_page_owner_guid()));
?>
<?php if(count($users_id) > 0): ?>
   <div class="row">
<?php
foreach($users_id as $user_id):
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $user_elgg = new ElggUser($user->id);
?>
    <div class="col-md-4" style="margin-bottom: 10px;">
        <div style="border-bottom: 1px solid #bae6f6; padding: 5px;overflow: hidden">
        <?php echo elgg_view("page/elements/user_block", array('entity' => $user)); ?>
        </div>
    </div>
<?php endforeach ?>
    </div>
<?php endif ?>