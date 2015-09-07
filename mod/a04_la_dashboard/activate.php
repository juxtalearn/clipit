<?php
$stumblingblock_lowerthreshold = elgg_get_plugin_setting('stumblingblock_lowerthreshold','a04_la_dashboard');
$stumblingblock_upperthreshold = elgg_get_plugin_setting('stumblingblock_upperthreshold','a04_la_dashboard');

if ( is_null($stumblingblock_lowerthreshold) ) {
    elgg_set_plugin_setting('stumblingblock_lowerthreshold','1','a04_la_dashboard');
    system_message(elgg_echo('la:admin:lowerthreshold').'1');
}

if ( is_null($stumblingblock_lowerthreshold) ) {
    elgg_set_plugin_setting('stumblingblock_upperthreshold','4','a04_la_dashboard');
    system_message(elgg_echo('la:admin:upperthreshold').'4');
}

