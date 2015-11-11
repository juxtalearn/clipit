<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$task_id = (int)get_input("id");
$task = array_pop(ClipitTask::get_by_id(array($task_id)));

if($task){
    echo elgg_view_form('task/save', array(
            'body' => elgg_view('forms/task/edit', array('entity'  => $task)),
            'data-validate'=> "true",
            'enctype' => 'multipart/form-data'
        ));
}