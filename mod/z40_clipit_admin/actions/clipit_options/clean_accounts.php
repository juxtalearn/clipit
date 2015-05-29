<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 29/05/2015
 * Time: 12:35
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
