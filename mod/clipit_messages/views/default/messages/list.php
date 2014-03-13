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
$messages_array = elgg_extract('entity', $vars);
?>
<script>
$(function(){
    $('.select-all').click(function(){
        var table= $('.table');
        $('td input:checkbox',table).prop('checked',this.checked);
        if($('td input:checkbox',table).prop("checked") == true){
            $(".message-options").prop("disabled", false);
        } else {
            $(".message-options").prop("disabled", true);
        }
    });
    $('.select-simple').click(function(){
        var that = $(this);
        $('.select-simple').each(function(){
            if($(this).prop("checked") == true || that.prop("checked") == true){
                $(".message-options").prop("disabled", false);
            } else {
                $(".message-options").prop("disabled", true);
            }
        });
    });
    $(".message-options").on("change", function(){
        if($(this).val().length > 0){
            $(this).closest("form").submit();
        }
    });
});
</script>
<div style="margin-bottom: 30px;color: #999;margin-left: 10px;">
    <div class="checkbox" style=" display: inline-block;margin: 0;">
        <label>
            <input type="checkbox" class="select-all"> Select all
        </label>
    </div>
    <div style=" display: inline-block; margin-left: 10px; ">
        <select name="set-option" disabled class="form-control message-options" style="height: 20px;padding: 0;">
            <option>[Options]</option>
            <option value="read">Mark as read</option>
            <option value="unread">Mark as unread</option>
            <option value="remove">Delete</option>
        </select>
    </div>
    <div class="pull-right search-box">
        <input type="text" placeholder="<?php echo elgg_echo('search');?>">
        <div class="input-group-btn">
            <span></span>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    <!--
    <span> Order </span>
        <div style=" display: inline-block; margin-left: 10px; ">
            <select class="form-control" style="height: 20px;padding: 0;">
                <option>Date</option>
                <option>unread</option>
                <option>***</option>
            </select>
        </div>-->
    </div>
</div>
<table class="messages-table table table-advance table-hover">
    <?php
    foreach($messages_array as $message):
        // Get replies
        $replies = ClipitMessage::get_replies($message->id);
        $message_text = trim(elgg_strip_tags($message->description));
        // Message text truncate max length 280
        if(mb_strlen($message_text)>35){
            $message_text = substr($message_text, 0, 35)."...";
        }
        // No read messages
        $message_unread = false;
        $main_read_status = ClipitMessage::get_read_status($message->id);
        if(empty($main_read_status["read"]) && $message->destination == $user_id){
            $message_unread = "unread";
        }
        $new_replies = false;
        $total_count = 0;
        foreach($replies as $reply_id){
            $reply_reads = ClipitMessage::get_read_status($reply_id);
            $reply = array_pop(ClipitMessage::get_by_id(array($reply_id)));
            if(empty($reply_reads["read"]) && $reply->owner_id != $user_id){
                $total_count++;
                $message_unread = "unread";
            }
        }

        if(count($total_count) > 0){
            $new_replies = $total_count;
        }

        $user_from = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
        $user_from_elgg = new ElggUser($message->owner_id);
        $text_from = elgg_echo("message:from");
        if($vars['sent']){
            // $user_from = array_pop(ClipitUser::get_by_id(array($message->destination)));
            $user_from = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
            $text_from = elgg_echo("message:to");
        }
        $total_replies = count($replies);
        $message_url = elgg_get_site_url()."messages/view/$message->id";
    ?>
    <tr class="<?php echo $message_unread; ?>">
        <td class="select">
            <input type="checkbox" name="check-msg[]" value="<?php echo $message->id; ?>" class="select-simple">
        </td>
        <td class="user-avatar">
            <img src="<?php echo $user_from_elgg->getIconURL("tiny"); ?>">
        </td>
        <td class="user-owner">
            <?php echo $text_from; ?>:
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user_from->login,
                'title' => $user_from->name,
                'text'  => $user_from->name));
            ?>
            <?php
            if($total_replies > 0):
                $last_post_id = end($replies);
                $last_post = array_pop(ClipitMessage::get_by_id(array($last_post_id)));
                $author_last_post = array_pop(ClipitUser::get_by_id(array($last_post->owner_id)));
            ?>
            <a href="<?php echo $message_url."#reply_".$last_post->id; ?>">
            <small class="show">
                <i class="fa fa-mail-reply" style="font-size: 100%;  color: #999999;"></i>
                <?php echo elgg_echo("message:last_reply");?>
                (<?php echo elgg_view('output/friendlytime', array('time' => $last_post->time_created));?>)</i>
            </small>
            </a>
            <?php else: ?>
            <small class="show">
                <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
            </small>
            <?php endif; ?>
        </td>
        <td class="click-simulate" onclick="document.location.href = '<?php echo $message_url; ?>';">
            <?php if($new_replies): ?>
            <span class="label label-primary label-mini new-replies" title="<?php echo elgg_echo("reply:unreads", array($new_replies)); ?>">
                +<?php echo $new_replies; ?>
            </span>
            <?php else: ?>
            <span class="label label-primary label-mini" title="<?php echo elgg_echo("reply:total", array($total_replies)); ?>">
                <?php echo $total_replies; ?>
            </span>
            <?php endif; ?>
        </td>
        <td class="click-simulate" onclick="document.location.href = '<?php echo $message_url; ?>';">
            <?php echo $message_text; ?>
        </td>
        <td class="click-simulate" onclick="document.location.href = '<?php echo $message_url; ?>';">
            <i class="fa fa-paperclip icon" title="<?php echo elgg_echo("file:contains"); ?>"></i>
        </td>
        <td>
            <button class="btn btn-default btn-xs reply-button">
            <?php echo elgg_view('output/url', array(
                'href'  => $message_url."#create_reply",
                'title' => elgg_echo("reply:create"),
                'text'  => '<i class="fa fa-plus"></i> '.elgg_echo("reply"),
            ));
            ?>
            </button>
            <button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash "></i></button>
        </td>
        <!--<td><i class="fa fa-users"></i></td>-->
    </tr>
    <?php endforeach; ?>
    <!-- STATIC
    <tr>
        <td class="select"><input type="checkbox"></td>
        <td><a>Juan</a></td>
        <td class="replies-td">
            <a class="fa-stack replies">
                <i class="fa fa-comment-o fa-stack-2x"></i>
                <i class="fa-stack-1x replies-count">26</i>
            </a>
        </td>
        <td>Lorem ipsum sit amet constance</td>
        <td><i class="fa fa-paperclip"></i></td>
        <td>Jan 10, 2014</td>
        <td><i class="fa fa-users"></i></td>
    </tr>
    <tr>
        <td class="select"><input type="checkbox"></td>
        <td><a>Pepe</a></td>
        <td class="replies-td">
            <a class="fa-stack replies">
                <i class="fa fa-comment fa-stack-2x"></i>
                <i class="fa-stack-1x replies-count" style="color: #32b4e5">+26</i>
            </a>
        </td>
        <td>Lorem ipsum sit amet constance</td>
        <td><i class="fa fa-paperclip"></i></td>
        <td>Jan 10, 2014</td>
        <td><i class="fa fa-users"></i></td>
    </tr>-->
</table>