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
$user_id = elgg_get_logged_in_user_guid();
$id = get_input('entity-id');
$file = array_pop(ClipitFile::get_by_id(array($id)));

$file_description = get_input('file-description');

if(!isset($file) || $file->owner_id != $user_id || trim($file_description) == ""){
    register_error(elgg_echo("file:cantedit"));
} else{
    ClipitFile::set_properties($file->id, array(
        'description' => $file_description
    ));
    system_message(elgg_echo('file:edited'));
}


forward(REFERER);