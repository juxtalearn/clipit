<?php
$widget = $vars['entity'];
$widget_id = $widget->guid;

if (!isset($widget->activity_id) || $widget->activity_id == elgg_echo('la_dashboard:widget:quizresult:selectactivity')) {
   echo elgg_echo("la_dashboard:please_config_widget");
}
else {
    $user = array_pop(ClipitUser::get_by_id(array($widget->user_id)));
    $user_name = is_not_null($user) ? $user->name : "";
    $metrics_data = array("metric_id"=> "user-artifacts", "context"=>array("activity_id" => $widget->activity_id), "target"=> $widget_id);
    $json = json_encode($metrics_data);
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
            elgg.get('ajax/view/metrics/metric', {
                data: {
                    metrics: <?php echo $json ?>
                },
                success: function (data) {
                   $("#metrics-<?php echo $widget_id?>").html(data);
                }
            });
</script>
<?php
}
?>

