<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */


$user_id = (int)get_input('user-id');
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$message_reply = get_input('message-reply');

if(!$user || trim($message_reply) == "" ){
    register_error(elgg_echo("reply:cantcreate"));
} else{
    ClipitChat::create(array(
        'name' => '',
        'description' => $message_reply,
        'destination' => $user->id,
    ));
    system_message(elgg_echo('reply:created'));
}

forward(REFERER);