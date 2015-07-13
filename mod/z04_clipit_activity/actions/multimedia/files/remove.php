<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$ids = is_array($id) ? $id : array($id);
$unlink = get_input('unlink');

foreach($ids as $file_id){
    $file = array_pop(ClipitFile::get_by_id(array((int)$file_id)));
    if(!$file){
        register_error(elgg_echo("file:cantremove"));
    } elseif(!$unlink){
        ClipitFile::delete_by_id(array($file->id));
        system_message(elgg_echo('file:removed', array($file->name)));
    } elseif($unlink) {
        ClipitFile::unlink_from_parent($file->id);
        ClipitTask::remove_files(ClipitFile::get_task($file->id), array($file->id));
        system_message(elgg_echo('file:removed', array($file->name)));
    }
}
forward(custom_forward_referer("/view/", "?filter=files"));