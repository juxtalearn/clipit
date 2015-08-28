<?php
$widget_id = get_input("widget_id");
$widget = array_pop(elgg_get_entities(array('guid'=>$widget_id)));
$activities = array();
if ($widget->activityids) {
$activity_ids = unserialize($widget->activityids);
$activities = ClipitActivity::get_by_id($activity_ids);
}
$content = elgg_view('page/components/not_found', array('height' => '245px', 'text' => elgg_echo('activities:active:none')));
if (!empty($activities)) {
$content = elgg_view('dashboard/modules/activity_status_progress', array(
'entities' => $activities
));
}

echo <<< HTML
	<!--[if IE]>
        <iframe src="$site/ajax/view/widgets/quizresultcompare/quizresultcompare_ajax?$queryString" width="100%" height="240px" frameBorder="0"></iframe>
    <![endif]-->
    <!--[if !IE]>-->
        <iframe src="$site/ajax/view/widgets/activityprogress/quizresultcompare_ajax?$queryString" width="100%" height="240px" style="border:none"></iframe>
    <!-- <![endif]-->
HTML;


echo $content;