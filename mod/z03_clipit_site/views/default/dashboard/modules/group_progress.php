<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activities = elgg_extract('entities', $vars);
$user_id = elgg_get_logged_in_user_guid();
?>
<script>
$(function(){
    var container = $('.module-activity_status');
    elgg.get('ajax/view/dashboard/modules/group_status_data', {
        data: {entities: <?php echo json_encode(array_keys($activities));?>, type: 'group_status'},
        dataType: 'json',
        success: function (data) {
            $.each(data, function(group, progress){
                $('[data-group-id='+group+']').css('width', progress + '%').find('span').html(progress + '%');
            });
        }
    });
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
                <?php echo elgg_view('output/url', array(
                    'href' => "clipit_activity/{$activity->id}/group/{$group_id}",
                    'class' => 'pull-right margin-left-5',
                    'text' => $group_object['name'],
                    'title' => $group_object['name'],
                    'is_trusted' => true,
                ));
                ?>
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
                <div class="bg-bar">
                    <div class="bar" data-group-id="<?php echo $group_id;?>" style="width: 0%;">
                        <div>
                            <span><i class="fa fa-spinner fa-spin"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>