<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pablo
 * Date: 18/10/13
 * Time: 15:37
 * To change this template use File | Settings | File Templates.
 */

function clipit_user_expose_functions(){
    expose_function("clipit.user.new_user",
        "clipit_user_new_user",
        array(
            "login" => array(
                "type" => "string",
                "required" => true),
            "password" => array(
                "type" => "string",
                "required" => false),
            "name" => array(
                "type" => "string",
                "required" => false),
            "email" => array(
                "type" => "string",
                "required" => false),
            "role" => array(
                "type" => "string",
                "required" => false),
            "description" => array(
                "type" => "string",
                "required" => false)
        ),
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.get_properties",
        "clipit_user_get_properties",
        array(
            "id" => array(
                "type" => "int",
                "required" => true),
            "prop_array" => array(
                "type" => "array",
                "required" => true)),
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.set_properties",
        "clipit_user_set_roperties",
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
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.get_all_users",
        "clipit_user_get_all_users",
        NULL,
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.get_users_by_id",
        "clipit_user_get_users_by_id",
        array(
            "id_array" => array(
                "type" => "array",
                "required" => true)),
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.get_users_by_login",
        "clipit_user_get_users_by_login",
        array(
            "login_array" => array(
                "type" => "array",
                "required" => true)),
        "<description>", //@todo
        'GET',
        true,
        false);
    expose_function("clipit.user.get_users_by_email",
        "clipit_user_get_users_by_email",
        array(
            "email_array" => array(
                "type" => "array",
                "required" => true)),
        "<description>", //@todo
        'GET',
        true,
        false);
}

function clipit_user_new_user($login, $password = null, $name = null, $email = null, $role= null, $description= null){
    if(get_user_by_username($login)){
        throw(new InvalidParameterException("The user login already exists"));
    }
    if(!$user = new ClipitUser()){
        return null;
    }
    $user->login = $login;
    if($password){
        $user->password_hash = generate_random_cleartext_password();
        $user->password = md5($password.$user->password_hash);
    }
    if($name){
        $user->name = $name;
    }
    if($email){
        $user->email = $email;
    }
    if($role){
        $user->role = $role;
    }
    if($description){
        $user->description = $description;
    }
    return $user->save();
}

function clipit_user_get_properties($id, $prop_array){
    $user = new ClipitUser($id);
    if(!$user){
        return null;
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
}

function clipit_user_get_all_users(){
    $elgg_user_array = elgg_get_entities(array('type' => 'user'));
    $user_array = array();
    for($i = 0; $i < count($elgg_user_array); $i++){
        $user_array[$i] = new ClipitUser($elgg_user_array[$i]->guid);
    }
    if(!$user_array){
        return null;
    }
    return $user_array;
}

function clipit_user_get_users_by_id($id_array){
    $user_array = array();
    for($i = 0; $i < count($id_array); $i++){
        $elgg_user = get_user($id_array[$i]);
        if(!$elgg_user){
            $user_array[$i] = null;
            continue;
        }
        $user_array[$i] = new ClipitUser($elgg_user->guid);
    }
    if(!$user_array){
        return null;
    }
    return $user_array;
}

function clipit_user_get_users_by_login($login_array){
    $user_array = array();
    for($i = 0; $i < count($login_array); $i++){
        $elgg_user = get_user_by_username($login_array[$i]);
        if(!$elgg_user){
            $user_array[$i] = null;
            continue;
        }
        $user_array[$i] = new ClipitUser($elgg_user->get("guid"));
    }
    if(!$user_array){
        return null;
    }
    return $user_array;
}

function clipit_user_get_users_by_email($email_array){
    $user_array = array(); // so that the first merge doesn't fail
    for($i = 0; $i < count($email_array); $i++){
        $elgg_user_array = get_user_by_email($email_array[$i]);
        if(!$elgg_user_array){
            $user_array[$i] = null;
            continue;
        }
        $temp_array = array();
        for($j = 0; $j < count($elgg_user_array); $j++){
            $temp_array[$j] = new ClipitUser($elgg_user_array[$j]->getguid);
        }
        if(!$temp_array){
            $user_array[$i] = null;
            continue;
        }
        $user_array = array_merge($user_array, $temp_array);
    }
    if(!$user_array){
        return null;
    }
    return $user_array;
}
