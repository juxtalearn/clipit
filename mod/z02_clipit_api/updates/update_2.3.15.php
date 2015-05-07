<?php

// clean users with incorrect role
$users = ClipitUser::get_all();
$remove_array = array();
foreach($users as $user){
    if(array_search($user->role, array(ClipitUser::ROLE_ADMIN, ClipitUser::ROLE_STUDENT, ClipitUser::ROLE_TEACHER)) === false){
        $remove_array[] = $user->id;
    }
}
//var_dump($remove_array);
ClipitUser::delete_by_id($remove_array);
