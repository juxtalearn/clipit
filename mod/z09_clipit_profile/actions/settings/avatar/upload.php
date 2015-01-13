<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/06/14
 * Last update:     27/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = get_input('user_id');

$file = $_FILES['avatar'];
$new_file_id = ClipitFile::create(array(
    'name' => $file['name'],
    'temp_path'  => $file['tmp_name']
));
if($new_file_id){
    ClipitUser::set_avatar($user_id, $new_file_id);
} else {
    register_error(elgg_echo("avatar:cantupload"));
}
system_message(elgg_echo('avatar:uploaded'));
