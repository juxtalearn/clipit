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
$title = elgg_echo("messages:trash");
elgg_push_breadcrumb($title);
$user_id = elgg_get_logged_in_user_guid();

$messages = ClipitChat::get_archived($user_id);

if(!is_array($messages)){
    $messages = array();
}


$content = elgg_view_form('messages/list', array(), array('entity' => $messages, 'trash' => true));
//
foreach($messages as $message){
    $message->description = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 80
    if(mb_strlen($message->description) > 80){
        $message->description = substr($message->description, 0, 80)."...";
    }
}
$content = elgg_view("messages/list/section", array('entity' => $messages, 'trash' => true));
//

if(empty($messages)){
    $content = elgg_echo("messages:trash:none");
}
$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);