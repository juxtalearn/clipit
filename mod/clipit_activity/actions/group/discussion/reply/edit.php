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
$user_id = elgg_get_logged_in_user_guid();
$discussion_id = get_input('message-id');
$discussion = array_pop(ClipitPost::get_by_id(array($discussion_id)));

$discussion_title = get_input('discussion-title');
$discussion_text = get_input('discussion-text');

if(!isset($discussion) || $discussion->owner_id != $user_id || trim($discussion_text) == ""){
    register_error(elgg_echo("reply:cantedit"));
} else{
    ClipitPost::set_properties($discussion->id, array(
        'description' => $discussion_text
    ));
    system_message(elgg_echo('reply:edited'));
}


forward(REFERER);