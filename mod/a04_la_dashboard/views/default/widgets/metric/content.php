<?php
$widget = $vars['entity'];
$widget_id = $widget->guid;

if ($widget->metric_id == elgg_echo('la_dashboard:select_metric')) {
   echo elgg_echo("la_dashboard:please_config_widget");
}
else {
?>
    <div id="metrics-<?php echo $widget_id?>">
        <div style="height: 245px; display: inline" class="wrapper separator loading-block-<?php echo $widget_id ?>">
            <div>
                <i class="fa fa-spinner fa-spin blue-lighter"></i>

                <h3 class="blue-lighter"><?php echo elgg_echo('loading'); ?>...</h3>
            </div>
        </div>
    </div>

<script>
            var metrics_data = {
                'metric_id': <?php echo $widget->metric_id ?>,
                'context':  <?php echo $widget->activity_id ?>,
                'target' : <?php echo $widget_id ?>
            };
            elgg.get('ajax/view/metrics/metric', {
                data: {
                    metrics: metrics_data
                },
                success: function (data) {
                   $("#metrics-<?php echo $widget_id?>").html(data);
                }
            });
</script>
<?php
}
?>

