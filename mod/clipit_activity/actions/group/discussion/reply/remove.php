<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   3/04/14
 * Last update:     3/04/14
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
$discussion_id = (int)get_input('id');
$user_id = elgg_get_logged_in_user_guid();
$message = array_pop(ClipitPost::get_by_id(array($discussion_id)));

if(count($message)==0 || $message->owner_id != $user_id){
    register_error(elgg_echo("reply:cantdelete"));
} else{
    ClipitPost::delete_by_id(array($discussion_id));
    system_message(elgg_echo('reply:deleted'));
}

forward(REFERER);