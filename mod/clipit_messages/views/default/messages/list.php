<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
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
<div style="margin-bottom: 30px;color #999;margin-left: 15px;">

    <div class="checkbox" style=" display: inline-block;margin: 0;">
        <label>
            <input type="checkbox" class="select-all"> <?php echo elgg_echo("selectall"); ?>
        </label>
    </div>
    <?php if(!$vars['sent']): ?>
    <div style=" display: inline-block; margin-left: 10px; ">
        <?php
        $options_dropdown = array(
            'disabled' => 'disabled',
            'class' => 'form-control message-options',
            'name'  => 'set-option',
            'style' => 'height: 20px;padding: 0;',
            'options_values' => array(
                ''          => '['.elgg_echo('message:options').']',
                'read'      => elgg_echo('message:markasread'),
                'unread'    => elgg_echo('message:markasunread'),
                'remove'    => elgg_echo('message:movetotrash'),
            ));
        if($vars['trash']){
            unset($options_dropdown['options_values']['remove']);
            $options_dropdown['options_values']['to_inbox'] = elgg_echo('message:movetoinbox');
        }
        echo elgg_view("input/dropdown", $options_dropdown); ?>
    </div>
    <?php endif; ?>

    <div class="pull-right search-box">
        <input type="text" placeholder="<?php echo elgg_echo('search');?>">
        <div class="input-group-btn">
            <span></span>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>
<table class="messages-table table table-advance table-hover">
    <?php
    foreach($messages_array as $message):
        $last_message = end($message);
        if($vars['trash']){
            $isRemoved = false;
        } else {
            $message = array_pop($message);
            $isRemoved = array_pop(ClipitChat::get_archived_status($message->id, array($user_id)));
        }

        if(!$isRemoved):
        // Get replies
        $message_text = trim(elgg_strip_tags($last_message->description));
        // Message text truncate max length 40
        if(mb_strlen($message_text)>50){
            $message_text = substr($message_text, 0, 50)."...";
        }

        $user_from = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
        $user_from_elgg = new ElggUser($message->owner_id);
        $text_from = "";
        $text_user_from = $user_from->name;
        if($user_from->id == $user_id){
            $text_user_from = elgg_echo("me");
        }
        if($vars['sent']){
            // $user_from = array_pop(ClipitUser::get_by_id(array($message->destination)));
            $user_from = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
            $text_from = elgg_echo("message:to").":";
            $text_user_from = $user_from->name;
        }

        $new_replies = ClipitChat::get_conversation_unread($user_id, $message->owner_id);
        $total_replies = ClipitChat::get_conversation_count($user_id, $message->owner_id);
        $message_url = elgg_get_site_url()."messages/view/$user_from->login";
    ?>
    <tr class="<?php echo $message_unread; ?>">
        <?php if(!$vars['sent']): ?>
        <td class="select">
            <input type="checkbox" name="check-msg[]" value="<?php echo $message->owner_id; ?>" class="select-simple">
        </td>
        <?php endif; ?>
        <td class="user-avatar">
            <img src="<?php echo $user_from_elgg->getIconURL("tiny"); ?>">
        </td>
        <td class="user-owner">
            <?php echo $text_from; ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user_from->login,
                'title' => $user_from->name,
                'text'  => $text_user_from));
            ?>
            <?php
            if($total_replies > 0):
                // Get last post data
                $last_post_id = end($replies);
                $last_post = ClipitChat::get_conversation($message->owner_id, $user_id);
                $last_post = end($last_post);
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
            <span class="label label-primary label-mini new-replies" title="<?php echo elgg_echo("message:unreads", array($new_replies)); ?>">
                +<?php echo $new_replies; ?>
            </span>
            <?php endif; ?>
        </td>
        <td class="click-simulate" onclick="document.location.href = '<?php echo $message_url; ?>';">
            <?php echo $message_text; ?>
        </td>
        <td>
        <?php if($vars['inbox']): ?>
            <button class="btn btn-default btn-xs reply-button">
            <?php echo elgg_view('output/url', array(
                'href'  => $message_url."#create_reply",
                'title' => elgg_echo("reply:create"),
                'text'  => '<i class="fa fa-plus"></i> '.elgg_echo("reply"),
            ));
            ?>
            </button>
            <?php
            $remove_msg_url = "action/messages/list?set-option=remove&check-msg[]={$message->owner_id}";
            echo elgg_view('output/url', array(
                'href'  => elgg_add_action_tokens_to_url($remove_msg_url, true),
                'title' => elgg_echo("message:movetotrash"),
                'text'  => '<i class="fa fa-trash-o" style="color: #fff;font-size: 18px;"></i> ',
                'class' => 'btn btn-danger btn-xs',
            ));
            ?>
        <?php endif; ?>

        <?php if($vars['trash']): ?>
            <?php
            $move_msg_url = "action/messages/list?set-option=to_inbox&check-msg[]={$message->owner_id}";
            echo elgg_view('output/url', array(
                'href'  => elgg_add_action_tokens_to_url($move_msg_url, true),
                'title' => elgg_echo("message:movetoinbox"),
                'style' => 'padding: 3px 9px;',
                'text'  => '<i class="fa fa-check"></i> '.elgg_echo("message:movetoinbox"),
                'class' => 'btn btn-success-o btn-xs',
            ));
            ?>
        <?php endif; ?>
        </td>
    </tr>
    <?php endif; endforeach; ?>
</table>