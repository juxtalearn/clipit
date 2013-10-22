<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pablo
 * Date: 18/10/13
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */
function clipit_quiz_expose_functions(){
    expose_function("clipit.quiz.list_properties",
        "clipit_quiz_list_properties",
        null, "description", 'GET', false, true);
    expose_function("clipit.quiz.get_properties",
        "clipit_quiz_get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
    expose_function("clipit.quiz.set_properties",
        "clipit_quiz_set_roperties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true),
            "value_array" => array(
                "type" => "array",
                "required" => true)),
        "description goes here", 'GET', false, true);
}

/*function clipit_quiz_list_properties(){
    return get_class_vars("ClipitQuiz");
}

function clipit_user_create_user($login, $password, $name, $email, $role = null, $description = null){
    if(empty($login)){
        throw(new InvalidParameterException("The user login cannot be empty"));
    }
    if(get_user_by_username($login)){
        throw(new InvalidParameterException("The user login already exists"));
    }
    if(!$user = new ClipitUser()){
        return false;
    }
    $user->login = $login;
    $user->password_hash = generate_random_cleartext_password();
    $user->password = md5($password.$user->password_hash);
    $user->name = $name;
    $user->email = $email;
    if(is_not_null($role)){
        $user->role = $role;
    }
    if(is_not_null($description)){
        $user->description = $description;
    }
    if($user->save()){
        return "User with id = $user->id was created";
    }
    else{
        throw(new CallException("There was a problem creating the new user"));
    }
}

function clipit_user_delete_user($id){
    if(!$user = new ClipitUser($id)){
        return false;
    }
    return $user->delete();
}

function clipit_user_get_properties($id, $prop_array){
    $user = new ClipitUser($id);
    if(!$user){
        return false;
    }
    $value_array = array();
    for($i = 0; $i < count($prop_array); $i++){
        $value_array[$i] = $user->$prop_array[$i];
    }
    return array_combine($prop_array, $value_array);
}

function clipit_user_set_properties($id, $prop_array, $value_array){
    if(count($prop_array) != count($value_array)){
        return null;
    }
    $user = new ClipitUser($id);
    if(!$user){
        return null;
    }
    for($i = 0; $i < count($prop_array); $i++){
        $user->$prop_array[$i] = $value_array[$i];
    }
    return $user->save();
}*/