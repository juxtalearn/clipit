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
$title = elgg_echo("message");
$user_id = elgg_get_logged_in_user_guid();
$user_sender = array_pop(ClipitUser::get_by_login(array($page[1])));
if($user_sender){
    $message = ClipitChat::get_conversation($user_id, $user_sender->id);
}
$breadcrumb_title = $user_sender->name;
elgg_push_breadcrumb($user_sender->name);
//if(!isset($page[1]) || empty($message)
//    || ($message->destination != $user_id && $message->owner_id != $user_id )){
//    register_error(elgg_echo('message:notfound'));
//    forward();
//}
$params = array(
    'content'   => elgg_view("messages/view", array('entity' => $message, 'sender' => $user_sender)),
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);