<?php
$params = get_input('params');
foreach($params as $key => $value){
    elgg_set_plugin_setting("$key","$value",'a04_la_dashboard');
}
forward(REFERER);