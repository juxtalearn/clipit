<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/10/2014
 * Last update:     09/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract('entity', $vars);
$metrics = elgg_extract('metrics', $vars);

$available_metrics = array('' => 'Select metric');
foreach(ActivityStreamer::get_available_metrics() as $metric){
    $available_metrics[$metric['TemplateId']] = $metric['Name'];
}
?>
<script>
$(function(){
    $(document).on("click", ".view-metric", function(){
        $(".loading-block").show();
        var $select = $(".select-metrics");
        var metrics_data = {
            'metric_id': $select.find(".available-metrics").val(),
            'context': {'activity_id': $select.find(".activities").val()}
        };
        console.log(metrics_data);
        elgg.get('ajax/view/metrics/metric', {
            data: {
                metrics: metrics_data
            },
            success: function(data){
                $(".metrics").html(data);
            }
        });
    });
});
</script>
<div class="row">
    <?php
        $activities = array('' => 'Select activity');
        foreach(ClipitUser::get_activities(elgg_get_logged_in_user_guid()) as $activity_id){
            $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
            $activities[$activity->id] = $activity->name;
        }
        ?>
        <div class="col-md-4 select-metrics">
            <div style="padding: 10px;background: #fafafa;">
                <div class="form-group">
                    <label><?php echo elgg_echo("activity:select");?></label>
                    <?php echo elgg_view('input/dropdown', array(
                        'name' => 'activity_id',
                        'class' => 'form-control activities',
                        'style' => 'padding-top: 5px;padding-bottom: 5px;',
                        'required' => true,
                        'options_values' => $activities
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label>Available metrics</label>
                    <?php echo elgg_view('input/dropdown', array(
                        'name' => 'metric_id',
                        'class' => 'form-control available-metrics',
                        'style' => 'padding-top: 5px;padding-bottom: 5px;',
                        'required' => true,
                        'options_values' => $available_metrics
                    ));
                    ?>
                </div>
                <button class="btn btn-primary view-metric">View metric</button>
            </div>
        </div>
    <div class="col-md-8 metrics">
        <div style="height: 245px; display: none" class="wrapper separator loading-block">
            <div>
                <i class="fa fa-spinner fa-spin blue-lighter"></i>
                <h3 class="blue-lighter"><?php echo elgg_echo('loading');?>...</h3>
            </div>
        </div>
    </div>
</div>