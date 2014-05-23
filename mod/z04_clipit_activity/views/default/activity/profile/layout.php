<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 17/02/14
 * Time: 11:33
 * To change this template use File | Settings | File Templates.
 */
$activity = elgg_extract("entity", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user_inActivity = ClipitGroup::get_from_user_activity($user_id, $activity->id);
?>
<div class="row">
    <div class="col-md-12" style="overflow-y: auto;max-height: 150px;">
        <p class="text-justify">
            <?php echo $activity->description;?>
        </p>
    </div>
</div>
<?php if($user_inActivity):?>
<div class="row">
    <div class="col-md-7">
        <?php echo elgg_view("activity/profile/deadline_module");?>
    </div>
    <div class="col-md-5">
        <?php echo elgg_view("activity/profile/stumbling_block_module");?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo elgg_view("activity/profile/related_videos_module");?>
    </div>
</div>
<?php endif; ?>
