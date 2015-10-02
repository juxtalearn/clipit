<?php
$widget = $vars['entity'];
$widget_id = $widget->guid;

if (!isset($widget->user_id) || $widget->user_id == elgg_echo('la_dashboard:widget:selectuser')) {
   echo elgg_echo("la_dashboard:please_config_widget");
}
else {
    $user = array_pop(ClipitUser::get_by_id(array($widget->user_id)));
    $user_name = is_not_null($user) ? $user->name : "";
    $metrics_data = array("metric_id"=> "user-activities", "context"=>array("user_id" => $widget->user_id, "user_name"=>$user_name), "target"=> $widget_id);
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
                    var text = $("#userid_dropdown-<?php echo $widget_id?>  option:selected").text();
                    $("#metrics-<?php echo $widget_id?>").prepend("<h5 role='title'>" + text + "</h5>");
                }
            });
</script>
<?php
}
?>

