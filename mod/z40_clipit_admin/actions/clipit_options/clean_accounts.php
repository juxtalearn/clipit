<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_admin
 */

// clean users with incorrect role
$users = ClipitUser::get_all();
$remove_array = array();
foreach($users as $user){
    if(array_search($user->role,
            array(ClipitUser::ROLE_ADMIN,
                ClipitUser::ROLE_STUDENT,
                ClipitUser::ROLE_TEACHER)) === false){
        $remove_array[] = $user->id;
    }
}

ClipitUser::delete_by_id($remove_array);
system_message("Accounts cleaned correctly");
