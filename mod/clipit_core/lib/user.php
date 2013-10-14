<?php

function elggUserToClipitUser(ElggUser $elggUser){
    $clipit_user = new ClipitUser();
    $clipit_user->avatar = "<TO-DO>";
    $clipit_user->description = "<TO-DO>";
    $clipit_user->email = $elggUser->get("email");
    $clipit_user->fullName = $elggUser->get("name");
    $clipit_user->id = $elggUser->get("guid");
    $clipit_user->login = $elggUser->get("username");
    $clipit_user->password = $elggUser->get("password");
    $clipit_user->type = $elggUser->get("type");
    $clipit_user->creationDate = "<TO-DO>";
    return $clipit_user;
}

function getUsers(){
    $user_list = elgg_get_entities(
        array('types' => 'user')
    );
    
    for($i=0; $i<count($user_list); $i++){
        $user_array[$i] = elggUserToClipitUser($user_list[$i]);
    }
    return $user_array;
}

function getUser(Integer $id){
    
}

