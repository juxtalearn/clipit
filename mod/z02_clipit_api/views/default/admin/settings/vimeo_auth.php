<?php

require_once elgg_get_plugins_path() . "z02_clipit_api/libraries/vimeo_api/vimeo.php";

$app_id = get_config("vimeo_app_id");
$app_secret = get_config("vimeo_app_secret");
$access_token = get_config("vimeo_access_token");

//  Create a handle for the Vimeo API, with the access token.
$vimeo = new Vimeo($app_id, $app_secret, $access_token);

var_dump($vimeo->upload("/var/www/html/dev_data/2014/10/02/498/1527056745"));
