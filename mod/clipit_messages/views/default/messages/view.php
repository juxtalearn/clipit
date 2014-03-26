<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   12/03/14
 * Last update:     12/03/14
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
$message = elgg_extract('entity', $vars);
$owner_user = new ElggUser($message->owner_id);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$replies = ClipitMessage::get_replies($message->id);

// Set read status when user visit this view
$message_read_status = array_pop(ClipitMessage::get_read_status($message->id, array($user_loggedin_id)));
if(!$message_read_status && $message->destination == $user_loggedin_id){
    ClipitMessage::set_read_status($message->id, true, array($user_loggedin_id));
}
foreach($replies as $reply_id){
    $reply = array_pop(ClipitMessage::get_by_id(array($reply_id)));
    $reply_read_status = array_pop(ClipitMessage::get_read_status($reply->id, array($user_loggedin_id)));
    if(!$reply_read_status && $reply->owner_id != $user_loggedin_id){
        ClipitMessage::set_read_status($reply->id, true, array($user_loggedin_id));
    }

}
?>
<div class="message">
    <div class="message-owner">
        <img class="user-avatar" src="<?php echo $owner_user->getIconURL("small");?>">
        <div class="block">
            <div class="header-msg">
                <div class="pull-right">
                    <button class="btn btn-default btn-xs reply-button">
                    <?php echo elgg_view('output/url', array(
                        'href'  => $message_url."#create_reply",
                        'title' => elgg_echo("reply:create"),
                        'text'  => '<i class="fa fa-plus"></i> '.elgg_echo("reply"),
                    ));
                    ?>
                    </button>
                </div>
                <p>
                    From:
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$owner_user->login,
                        'title' => $owner_user->name,
                        'text'  => $owner_user->name,
                    ));
                    ?>
                </p>
                <p>
                    <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
                </p>
                <?php if($message->name): ?>
                <h3 class="subject">
                    <?php echo $message->name; ?>
                </h3>
                <?php endif; ?>
            </div>
            <div class="body-msg">
                <?php echo $message->description; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reply section -->
<div class="reply-section">
<a name="replies"></a>
<?php
foreach($replies as $reply_msg_id){
    $reply_msg = array_pop(ClipitMessage::get_by_id(array($reply_msg_id)));
    $second_level_ids = ClipitMessage::get_replies($reply_msg->id);
    echo elgg_view("messages/reply", array('entity' => $reply_msg, 'second_level_ids' => $second_level_ids));
}
?>
<!-- Reply form -->
<a name="create_reply"></a>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("messages/reply/create", array('data-validate'=> "true" ), array('entity'  => $message, 'category' => 'pm')); ?>
    </div>
</div>
<!-- Reply form end-->
</div>
<!-- Reply section end -->