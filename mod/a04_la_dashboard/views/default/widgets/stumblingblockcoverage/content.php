<?php


$widget = $vars['entity'];
$widget_id = $widget->guid;

if ($widget->activity_id == 0) {
   echo elgg_echo("la_dashboard:please_config_widget");
}
else {
    $additional_vars = array('activity_id' => $widget->activity_id,  'scale' => $widget->scale, 'group_id' => $widget->group_id,  'widget_id'=>$widget_id, 'user_id'=>$user->id);
    $queryString = http_build_query($additional_vars);
    $site = elgg_get_site_url();
    echo <<< HTML
	<!--[if IE]>
        <iframe src="$site/ajax/view/widgets/stumblingblockcoverage/stumblingblockcoverage_ajax?$queryString" width="100%" height="100px" scrolling="no" frameBorder="0"></iframe>
    <![endif]-->
    <!--[if !IE]>-->
        <iframe src="$site/ajax/view/widgets/stumblingblockcoverage/stumblingblockcoverage_ajax?$queryString" width="100%" height="100px" scrolling="no" style="border:none"></iframe>
    <!-- <![endif]-->
HTML;
}
?>

