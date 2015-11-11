<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activities = elgg_extract('entities', $vars);
$user_id = elgg_get_logged_in_user_guid();
?>
<script>
$(function(){
    clipit.loadGroupStatus(<?php echo json_encode(array_keys($activities));?>);
});
</script>
<style>
    .module-activity_status .elgg-body .bar{
        transition: all 1s;
    }
</style>
<div class="wrapper separator">
    <?php
    foreach($activities as $activity):
        if($activity->status != ClipitActivity::STATUS_CLOSED):
        $group_id = ClipitGroup::get_from_user_activity($user_id, $activity->id);
        $group_object = ClipitSite::lookup($group_id);
    ?>
            <div>
                <?php if($group_id):?>
                    <?php echo elgg_view('output/url', array(
                        'href' => "clipit_activity/{$activity->id}/group/{$group_id}",
                        'class' => 'pull-right margin-left-5',
                        'text' => $group_object['name'],
                        'title' => $group_object['name'],
                        'is_trusted' => true,
                    ));
                    ?>
                <?php endif;?>
                <?php echo elgg_view('output/url', array(
                    'href' => "clipit_activity/{$activity->id}",
                    'class' => 'activity-point',
                    'style' => "background: #$activity->color;",
                    'text' => '',
                    'title' => $activity->name,
                    'is_trusted' => true,
                ));
                ?>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href' => "clipit_activity/{$activity->id}",
                        'text' => $activity->name,
                        'title' => $activity->name,
                        'is_trusted' => true,
                    ));
                    ?>
                </strong>
                <?php if($group_id):?>
                <div class="bg-bar">
                    <div class="bar" data-group-id="<?php echo $group_id;?>" style="width: 0%;">
                        <div>
                            <span><i class="fa fa-spinner fa-spin"></i></span>
                        </div>
                    </div>
                </div>
                <?php else:?>
                    <div>
                        <small><?php echo elgg_echo('my_group:none');?></small>
                    </div>
                <?php endif;?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>