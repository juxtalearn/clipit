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
$task_id = (int)get_input("id");
$task = array_pop(ClipitTask::get_by_id(array($task_id)));

if($task){
    echo elgg_view_form('task/edit', array('data-validate'=> "true", 'enctype' => 'multipart/form-data'), array('entity'  => $task));
}