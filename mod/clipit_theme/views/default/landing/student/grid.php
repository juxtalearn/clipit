<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 6/02/14
 * Time: 12:41
 * To change this template use File | Settings | File Templates.
 */

$role = elgg_extract("role", $vars);
$landing_dir = "landing/".$role;

?>
<div class="col-md-4 events-list">
    <?php echo elgg_view($landing_dir."/events_module"); ?>
</div>

<div class="col-md-8">
    <div class="col-md-6">
        <?php echo elgg_view($landing_dir."/pending_module"); ?>
        <?php echo elgg_view($landing_dir."/activity_status_module"); ?>
        <?php echo elgg_view($landing_dir."/group_activity_module"); ?>
    </div>
    <div class="col-md-6" style="background: #EBEBEB;">
        <?php echo elgg_view($landing_dir."/recommended_videos_module"); ?>
        <?php echo elgg_view($landing_dir."/tags_module"); ?>
    </div>
</div>
