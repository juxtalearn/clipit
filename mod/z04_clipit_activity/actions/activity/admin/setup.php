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
if(trim($activity_title) == "" || trim($activity_description) == ""){
    register_error(elgg_echo("activity:cantupdate"));
} else {
    ClipitActivity::set_properties($activity_id, array(
        'name' => $activity_title,
        'description' => $activity_description
    ));
    system_message(elgg_echo('activity:updated'));
}

forward(REFERER);