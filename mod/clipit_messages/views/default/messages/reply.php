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
$reply_msg = elgg_extract('entity', $vars);
$second_level_ids = elgg_extract('second_level_ids', $vars);
$user_reply = new ElggUser($reply_msg->owner_id);

// Owner options (edit/delete)
$owner_reply_options = "";
if($reply_msg->owner_id == elgg_get_logged_in_user_guid()){
    $options = array(
        'entity' => $reply_msg,
        'edit' => array(
            "data-target" => "#edit-discussion-{$reply_msg->id}",
            "href" => elgg_get_site_url()."ajax/view/modal/messages/reply/edit?id={$reply_msg->id}",
            "data-toggle" => "modal"
        ),
        'remove' => array("href" => "action/messages/reply/remove?id={$reply_msg->id}"),
    );

    $owner_reply_options = elgg_view("page/components/options_list", $options);
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$reply_msg->id}" ));
}

$second_reply = false;
if($vars['second_reply']){
    $second_reply = true;
}
?>
<a name="reply_<?php echo $reply_msg->id; ?>"></a>
<div class="discussion discussion-reply-msg">
    <div class="header-post">
        <?php echo $owner_reply_options; ?>
        <div class="user-reply">
            <img class="user-avatar" src="<?php echo $user_reply->getIconURL('small'); ?>" />
            <?php if(!$second_reply && isset($vars['discussion'])): ?>
                <button id="<?php echo $reply_msg->id; ?>" class="reply-to btn btn-default btn-sm reply-button">Reply</button>
            <?php endif; ?>
        </div>
        <div class="block">
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$user_reply->login,
                    'title' => $user_reply->name,
                    'text'  => $user_reply->name));
                ?>
            </strong>
            <small class="show">
                <?php echo elgg_view('output/friendlytime', array('time' => $reply_msg->time_created));?>
            </small>
        </div>
    </div>
    <div class="body-post"><?php echo $reply_msg->description; ?></div>

    <?php if(!empty($second_level_ids)): ?>
        <!-- Reply second level -->
        <div class="second_level">
            <?php
            foreach($second_level_ids as $second_level_id):
                $second_level = array_pop(ClipitMessage::get_by_id(array($second_level_id)));
                echo elgg_view("messages/reply", array('entity' => $second_level, 'second_reply' => true));
            endforeach;
            ?>
            <!-- Reply second level end-->
        </div>
    <?php endif; ?>

    <!-- Reply form -->
    <div class="form-block" id="form-<?php echo $reply_msg->id; ?>">
        <small class="block">
            Reply to:
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user_reply->login,
                'title' => $user_reply->name,
                'text'  => $user_reply->name));
            ?>
            <a href="javascript:;" id="<?php echo $reply_msg->id; ?>" class="close-reply-to" >&times;</a>
        </small>
        <?php echo elgg_view_form("messages/reply/create", array('data-validate'=> "true" ), array('entity'  => $reply_msg, 'second_reply' => $second_reply)); ?>
    </div>
    <!-- Reply form end-->

</div>