<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 26/02/14
 * Time: 16:23
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_extract("entity", $vars);
$activity_id = ClipitGroup::get_activity($group->id);
$events_log = ClipitEvent::get_by_object(array($group->id), 0, 30);


echo "<ul>";
foreach ($events_log as $event_log){
    echo clipit_event($event_log, 'full');
}
echo "</ul>";
