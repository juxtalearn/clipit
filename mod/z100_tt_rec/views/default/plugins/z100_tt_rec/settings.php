<?php
/**
 * Created by IntelliJ IDEA.
 * User: Batman
 * Date: 27.10.2015
 * Time: 12:09
 */

$sesameserverurl_setting = elgg_get_plugin_setting('sesameserver', 'z100_tt_rec');
if (is_null($sesameserverurl_setting)) {
    $sesameserverurl_setting = "http://localhost:8080";
}
$body .= '<h3>'.elgg_echo('z100:sesameserver:url').'</h3>';
$body .= elgg_view("input/url", array('name' => 'params[sesameserver]', 'value' => $sesameserverurl_setting));

echo $body;
