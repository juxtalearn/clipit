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
$file = array_pop(ClipitFile::get_by_id(array((int)$id)));
$user_id = elgg_get_logged_in_user_guid();

if($file &&  $file->owner_id == $user_id){
    ClipitFile::delete_by_id(array($file->id));
    system_message(elgg_echo("file:removed", array($file->name)));
} else{
    register_error(elgg_echo("file:cantremove"));
}

forward(REFERER);