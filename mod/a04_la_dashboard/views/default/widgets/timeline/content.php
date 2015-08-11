
<div class="module-events"></div>
<div class="events-list" style="padding-right: 15px;">
<?php
$widget = $vars['entity'];
$widget_id = $widget->guid;
echo elgg_view('dashboard/modules/events', array('entity' =>elgg_extract("entity", $vars)));
    ?>




</div>

