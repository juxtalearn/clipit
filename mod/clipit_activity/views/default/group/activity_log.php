<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$group = elgg_extract("entity", $vars);
$activity_id = ClipitGroup::get_activity($group->id);
$events_log = ClipitEvent::get_by_object(array($group->id), 0, 30);


echo "<ul>";
foreach ($events_log as $event_log){
    echo clipit_event($event_log, 'full');
}
echo "</ul>";
