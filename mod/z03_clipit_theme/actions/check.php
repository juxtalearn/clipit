<?php
/**
 * Elgg CHECK action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */


// Get variables
$username = get_input('username');
$email = get_input('email');


if (elgg_get_config('allow_registration')) {
    $result = "true";
    /*if(!get_user_by_email($email) || !isset($email)){
        $result = "false";
    }*/
    if(get_user_by_username($username) && isset($username)){
        $result = "false";
    }
    if(!get_user_by_email($email) && isset($email)){
        $result = "false";
    }
    echo $result;
}
die();