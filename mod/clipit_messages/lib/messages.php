<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/03/14
 * Last update:     18/03/14
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
function messages_search_page($page){
    $title = elgg_echo("messages:search");
    $search = get_input("s");
    $search_type = $page[1];
    switch($search_type){
        case "inbox":
            $query = array();
            messages_handle_inbox_page($query);
            break;
        case "sent_email":
            $query = array();
            messages_handle_sent_page($query);
            break;
        default:
            return false;
    }
    elgg_push_breadcrumb(elgg_echo('messages:search', array($search)));
}

function messages_handle_inbox_page($search = null){
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

    $params = array(
        'content'   => elgg_view_form('messages/list', array(), array('entity' => $messages)),
        'filter'    => '',
        'title'     => $title,
    );
    $body = elgg_view_layout('content', $params);
    echo elgg_view_page($params['title'], $body);
}

function messages_handle_sent_page($search = null){
    $user_id = elgg_get_logged_in_user_guid();
    $title = elgg_echo("messages:sent_email");
    elgg_push_breadcrumb($title);
    $messages = array_pop(ClipitMessage::get_by_sender(array($user_id), $category = 'pm'));
    $params = array(
        'content'   => elgg_view_form('messages/list', array(), array('entity' => $messages, 'sent' => true)),
        'filter'    => '',
        'title'     => $title,
    );
    $body = elgg_view_layout('content', $params);
    echo elgg_view_page($params['title'], $body);
}

function messages_handle_view_page(int $page){
    $user_id = elgg_get_logged_in_user_guid();
    $title = elgg_echo("message");
    $message = array_pop(ClipitMessage::get_by_id(array((int)$page[1])));
    $breadcrumb_title = $message->name;
    // if subject is empty, set description in breadcrumb
    if(trim($breadcrumb_title) == ""){
        $breadcrumb_title = $message->description;
        if(mb_strlen($breadcrumb_title)>40){
            $breadcrumb_title = substr($breadcrumb_title, 0, 40)."...";
        }
    }
    elgg_push_breadcrumb($breadcrumb_title);

    if(!isset($page[1]) || empty($message)
        || ($message->destination != $user_id && $message->owner_id != $user_id )){
        register_error(elgg_echo('message:notfound'));
        forward();
    }
    $params = array(
        'content'   => elgg_view("messages/view", array('entity' => $message)),
        'filter'    => '',
        'title'     => $title,
    );
    $body = elgg_view_layout('content', $params);
    echo elgg_view_page($params['title'], $body);
}