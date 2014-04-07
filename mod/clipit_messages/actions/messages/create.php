<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
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
$to_array =  explode(",", get_input('message-to'));
foreach($to_array as $to_id){
    $to_id = (int)$to_id;
    $user = array_pop(ClipitUser::get_by_id(array($to_id)));
    $message_subject = get_input('message-subject');
    $message_text = get_input('message-text');
    if(!$user  || trim($message_text) == ""){
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

forward(REFERER);