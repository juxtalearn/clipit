<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/07/14
 * Last update:     9/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$file = $_FILES['upload-users'];
$users = ClipitUser::import_data($file['tmp_name']);
foreach($users as $user_id){
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $output[] = array(
        'name' => $user->name,
        'id' => $user->id
    );
}

echo json_encode($output);
die();