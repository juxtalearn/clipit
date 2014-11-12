<?php
/**
 * Elgg CHECK action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */


// Get variables
$username = get_input("username");
$user = get_input('email');

$result = "false";
if(isset($username) && !get_user_by_username($username)){
    $result = "true";
}
if(get_user_by_username($user) || get_user_by_email($user) && isset($user)){
    $result = "true";
}
echo $result;

die();