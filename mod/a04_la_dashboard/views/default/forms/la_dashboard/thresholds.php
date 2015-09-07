<?php
$stumblingblock_lowerthreshold = elgg_get_plugin_setting('stumblingblock_lowerthreshold','a04_la_dashboard');
$stumblingblock_upperthreshold = elgg_get_plugin_setting('stumblingblock_upperthreshold','a04_la_dashboard');
$body .= "<div><label>".elgg_echo("la:admin:lowerthreshold")."</label>";
$body .= elgg_view("input/number",array('name'=>'params[stumblingblock_lowerthreshold]','value'=>$stumblingblock_lowerthreshold));
$body .= "</div><div><label>".elgg_echo("la:admin:upperthreshold")."</label>";
$body .= elgg_view("input/number",array('name'=>'params[stumblingblock_upperthreshold]','value'=>$stumblingblock_upperthreshold)) ."</div>";
$body .= elgg_view("input/submit", array('value' =>elgg_echo("save")));
echo $body;