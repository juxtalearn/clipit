<?php


function getUsers(){
   
    $user_list = elgg_get_entities(
        array('types' => 'user')
    );
    

    for($i=0; $i<count($user_list); $i++){
        $user_array[$i]["avatar"] = "<TO-DO>";
        $user_array[$i]["description"] = "<TO-DO>";
        $user_array[$i]["email"] = $user_list[$i]->get("email");
        $user_array[$i]["fullName"] = $user_list[$i]->get("name");
        $user_array[$i]["id"] = $user_list[$i]->get("guid");
        $user_array[$i]["login"] = $user_list[$i]->get("username");
        $user_array[$i]["password"] = $user_list[$i]->get("password");
        $user_array[$i]["type"] = $user_list[$i]->get("type");
        $user_array[$i]["creationDate"] = "<TO-DO>";
    }
    return $user_array;
}

