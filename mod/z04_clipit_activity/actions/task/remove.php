<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = (int)get_input('id');
// Delete child ids
if($child_id = ClipitTask::get_child_task($id)){
    ClipitTask::delete_by_id(array($child_id));
}
if(ClipitTask::delete_by_id(array($id))){
    system_message(elgg_echo('task:removed'));
} else {
    register_error(elgg_echo("task:cantremove"));
}
forward(REFERRER);