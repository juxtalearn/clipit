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

$messages = array_pop(ClipitMessage::get_by_destination(array($user_id)));
if(!is_array($messages)){
    $messages = array();
}
$messages_removed = array();
foreach($messages as $message){
    $isRemoved = array_pop(ClipitMessage::get_archived_status($message->id, array($user_id)));
    if($isRemoved){
        $messages_removed = array_merge(array($message), $messages_removed);
    }
}

$content = elgg_view_form('messages/list', array(), array('entity' => $messages_removed, 'trash' => true));
if(empty($messages_removed)){
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