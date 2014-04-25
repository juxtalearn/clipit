<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/04/14
 * Last update:     24/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$message = elgg_extract('entity', $vars);
$options = elgg_extract('options', $vars);

$user_logged_in = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
$user_elgg = new ElggUser($message->owner_id);
$message_url = elgg_get_site_url()."messages/view/$user->login";

?>
<?php if(!$vars['sent']): ?>
<td class="select">
    <input type="checkbox" name="check-msg[]" value="<?php echo $message->owner_id; ?>" class="select-simple">
</td>
<?php endif; ?>
<td class="user-avatar">
    <img src="<?php echo $user_elgg->getIconURL("tiny"); ?>">
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
        $last_post = ClipitChat::get_conversation($message->owner_id, $user_logged_in);
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
    <?php if($message->unread_count): ?>
        <span class="label label-primary label-mini new-replies" title="<?php echo elgg_echo("reply:unreads", array($message->unread_count)); ?>">
            +<?php echo $message->unread_count; ?>
        </span>
    <?php endif; ?>
</td>
<td class="click-simulate" onclick="document.location.href = '<?php echo $message_url; ?>';">
    <?php echo $message->description; ?>
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
