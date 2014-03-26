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
    'sidebar'   => elgg_view('messages/sidebar/group_list')
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($params['title'], $body);