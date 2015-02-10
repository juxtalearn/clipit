
<?php

$widget = elgg_extract('entity', $vars);
$widget_id = $widget->guid;
$metrics = elgg_extract('metrics', $vars);
?>
<div>
    This is the configuration view for widget <?php echo $widget->guid?>
    In the next version you will be able to configure activities, groups and students for this widget here.
</div>