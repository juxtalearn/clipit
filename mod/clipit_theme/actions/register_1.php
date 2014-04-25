<?php
/**
 * Elgg registration action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */

elgg_make_sticky_form('register');

// Get variables
$username = get_input('username');
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
$email = get_input('email');
$name = get_input('name');
$friend_guid = (int) get_input('friend_guid', 0);
$invitecode = get_input('invitecode');

//$errors[] = "Password deben coincidir";
$error_list = array();

function register_json_error($error, $input_name){
    GLOBAL $error_list;
    $error_list[] = array("msg" =>$error, "input" => $input_name );
}
function load_json_error(){
    GLOBAL $error_list;
    header('Content-type: application/json');
    return json_encode(array("error" => $error_list ));
}
if (elgg_get_config('allow_registration')) {

        if(!$name){
            register_json_error("Debe insertar un nombre", "name");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            register_json_error('Correo electrónico no valido', "email");
        }
        if(!$username){
            register_json_error("Debe insertar un nombre de usuario", "username");
        }
        if (trim($password) == "" || trim($password2) == "") {
            register_json_error(elgg_echo('RegistrationException:EmptyPassword'), "password");
        }
        if (strcmp($password, $password2) != 0) {
            register_json_error(elgg_echo('RegistrationException:PasswordMismatch'), "password");
        }

        echo load_json_error();

} else {
    register_error(elgg_echo('registerdisabled'));
}
forward(REFERER);
