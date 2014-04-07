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
$messages = elgg_extract('entity', $vars);
$sender = elgg_extract('sender', $vars);

$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);

foreach($messages as $message){
    $owner_user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
    $owner_user_elgg = new ElggUser($message->owner_id);
    // Set read status from user logged in
    ClipitChat::set_read_status($message->id, true, array($user_loggedin_id));

    if($message->owner_id == $user_loggedin_id):
?>
<a name="reply_<?php echo $message->id; ?>"></a>
<div class="discussion discussion-reply-msg" style="background: #fff;border-bottom: 1px solid #bae6f6;">
    <div class="message">
        <div class="message-owner">
            <img class="user-avatar" src="<?php echo $owner_user_elgg->getIconURL("small");?>">
            <div class="block">
                <div class="header-msg">
                    <p>
                        <strong>
                            <?php echo elgg_view('output/url', array(
                                'href'  => "profile/".$owner_user->login,
                                'title' => $owner_user->name,
                                'text'  => $owner_user->name,
                            ));
                            ?>
                        </strong>
                    </p>
                    <small class="show">
                        <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
                    </small>
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
</div>
<?php else: ?>
<a name="reply_<?php echo $message->id; ?>"></a>
<div class="discussion discussion-reply-msg">
    <div class="message">
        <div class="message-owner">
            <img class="user-avatar" src="<?php echo $owner_user_elgg->getIconURL("small");?>">
            <div class="block">
                <div class="header-msg">
                    <p>
                        <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/".$owner_user->login,
                            'title' => $owner_user->name,
                            'text'  => $owner_user->name,
                        ));
                        ?>
                        </strong>
                    </p>
                    <small class="show">
                        <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
                    </small>
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
</div>
<?php endif; ?>
<?php } ?>
<!-- Reply section -->
<div class="reply-section">
<!-- Reply form -->
<a name="create_reply"></a>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("messages/reply/create", array('data-validate'=> "true" ), array('entity'  => $sender, 'category' => 'pm')); ?>
    </div>
</div>
<!-- Reply form end-->
</div>
<!-- Reply section end -->
