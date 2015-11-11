<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$to_array =  array_filter(explode(",", get_input('message-to')));
$activity_id = get_input('activity');
$message_subject = get_input('message-subject');
$message_text = get_input('message-text');

if((count($to_array)==0 && !$activity_id) || trim($message_text) == ""){
    register_error(elgg_echo("message:cantcreate"));
}

if($activity_id){
    foreach(ClipitActivity::get_students($activity_id) as $student){
        if(trim($message_text) != ""){
            ClipitChat::create(array(
                'name' => $message_subject,
                'description' => $message_text,
                'destination' => $student,
            ));
        }
    }
}
if(count($to_array)>0) {
    foreach ($to_array as $to_id) {
        $to_id = (int)$to_id;
        $user = array_pop(ClipitUser::get_by_id(array($to_id)));

        if (!$user || trim($message_text) == "") {
            register_error(elgg_echo("message:cantcreate"));
        } else {
            ClipitChat::create(array(
                'name' => $message_subject,
                'description' => $message_text,
                'destination' => $user->id,
            ));
            system_message(elgg_echo('message:created'));
        }
    }
}
forward(REFERER);
