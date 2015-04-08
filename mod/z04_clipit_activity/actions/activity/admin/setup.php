<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity_id = get_input('entity-id');
$activity_title = get_input('activity-title');
$activity_description = get_input('activity-description');
$only_calendar = get_input('calendar');
$start = get_input('activity-start');
$end = get_input('activity-end');
$start = get_timestamp_from_string($start)+(60*1);
$end = get_timestamp_from_string($end)+(60*60*24)-(60*1);

if($only_calendar){
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    $activity_title = $activity->name;
    $activity_description = $activity->description;
}
if(trim($activity_title) == "" || trim($activity_description) == ""){
    register_error(elgg_echo("activity:cantupdate"));
} else {
    if($end < $start){
        $end = $start + (60*60*24*1);
    }
    ClipitActivity::set_properties($activity_id, array(
        'name' => $activity_title,
        'description' => $activity_description,
        'start' => $start,
        'end' => $end
    ));
    system_message(elgg_echo('activity:updated'));
}

forward(REFERER);