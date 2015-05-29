<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 20/01/2015
 * Time: 16:55
 */
// disable new student registration by default
set_config('allow_registration', 0);
// z99_clipit_demo changed to z20_clipit_demo, so reactivate all plugins
$plugins = elgg_get_plugins('inactive');
foreach ($plugins as $plugin){
    $plugin->activate();
}
