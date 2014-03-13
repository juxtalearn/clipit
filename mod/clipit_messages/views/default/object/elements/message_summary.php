<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/03/14
 * Last update:     13/03/14
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
$limit = elgg_extract("limit", $vars);
if(!$limit){
    $limit = 3;
}

$messages = array_pop(ClipitMessage::get_by_destination(array($user_id)));
if(!is_array($messages)){
    $messages = array();
}
$messages_by_sender = array_pop(ClipitMessage::get_by_sender(array($user_id)));
foreach($messages_by_sender as $message_sender){
    if(count(ClipitMessage::get_replies($message_sender->id)) > 0){
        $messages = array_merge(array($message_sender), $messages);
    }
}
$messages = array_slice($messages, 0, $limit);
foreach($messages as $message):
    $user = new ElggUser($message->owner_id);
?>
<li role="presentation message-item">
    <a style="padding: 5px 10px;width: 300px;" role="menuitem" tabindex="-1" href="">
        <img style="float:left;margin-right: 10px;" src="http://juxtalearn.org/sandbox/clipit_befe/_graphics/icons/user/defaultsmall.gif">
        <div style=" font-size: 13px; text-transform: none; overflow: hidden; letter-spacing: 0;">
            <span class="label label-primary pull-right">Unread</span>
            <span><?php echo $user->name;?></span>
            <small style="display: block;">12:00H, NOV 18, 2013</small>
            <div style="color: #333;" class="text-truncate">
                Duis et ante turpis. Praesent risusligula, porta vitae hendrerit quis
            </div>
        </div>
    </a>
</li>
<li role="presentation" class="divider"></li>
<?php endforeach; ?>
<li class="message-options">
    <button type="button" class="btn btn-primary btn-compose" data-toggle="modal" data-target="#compose-msg">
        <?php echo elgg_echo("messages:compose"); ?>
    </button>
    <?php echo elgg_view('output/url', array(
        'href'  => "messages/inbox",
        'title' => elgg_echo("messages:inbox"),
        'text'  => '<i class="fa fa-inbox"></i> '.elgg_echo("messages:inbox"),
        'class' => 'pull-right',
    ));
    ?>
</li>