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
$user_id = elgg_get_logged_in_user_guid();
$title = elgg_echo("messages:inbox");
elgg_push_breadcrumb($title);

$messages = ClipitChat::get_inbox($user_id);
array_reverse($messages);
if(!is_array($messages)){
    $messages = array();
}
$content = elgg_view_form('messages/list', array(), array('entity' => $messages, 'inbox' => true));
if (!$messages) {
    $content = elgg_echo("messages:inbox:none");
}
$params = array(
    'content'   => $content,
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);

$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);