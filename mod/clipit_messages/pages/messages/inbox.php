<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/03/14
 * Last update:     26/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
$user_id = elgg_get_logged_in_user_guid();
$title = elgg_echo("messages:inbox");
elgg_push_breadcrumb($title);
$messages = array_pop(ClipitMessage::get_by_destination(array($user_id)));
if(!is_array($messages)){
    $messages = array();
}
$messages_by_sender = array_pop(ClipitMessage::get_by_sender(array($user_id), $category = 'pm'));
foreach($messages_by_sender as $message_sender){
    if(count(ClipitMessage::get_replies($message_sender->id)) > 0){
        $messages = array_merge(array($message_sender), $messages);
    }
}
$sidebar = elgg_view('messages/sidebar/group_list');
$params = array(
    'content'   => elgg_view_form('messages/list', array(), array('entity' => $messages, 'inbox' => true)),
    'filter'    => '',
    'title'     => $title,
    'sidebar'   => $sidebar
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);