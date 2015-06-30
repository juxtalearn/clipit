<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/04/2015
 * Last update:     09/04/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$activity_id = get_input('entity-id');
$tasks = get_input('task');
$quiz = get_input('quiz');

$correct_msg = elgg_echo('task:updated');
$error_msg = elgg_echo("task:cantupdate");
foreach ($tasks as $task) {
    $is_correct = elgg_trigger_plugin_hook('task:save', 'task', array(
        'task' => $task,
        'activity_id' => $activity_id
    ), true);
}

if($is_correct){
    system_message($correct_msg);
} else {
    register_error($error_msg);
}

forward(REFERRER);