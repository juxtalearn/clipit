<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user_id = elgg_get_logged_in_user_guid();
$limit = elgg_extract("limit", $vars);
if(!$limit){
    $limit = 3;
}

//$messages = array_pop(ClipitChat::get_by_destination(array($user_id)));
$messages = ClipitChat::get_inbox($user_id);


$messages = array_slice($messages, 0, $limit);
?>
<?php if(empty($messages)): ?>
    <li role="presentation" class="message-item" style="margin-bottom: 10px;">
        <a style="font-size: 13px;text-transform: none;letter-spacing: 0;"><?php echo elgg_echo('messages:inbox:none'); ?></a>
    </li>
<?php endif; ?>
<?php
foreach($messages as $message):
    $message = array_pop($message);
    $user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
//    $last_message = end(ClipitChat::get_conversation($user_id, $message->owner_id));
    $last_message = $message;
    $message_text = trim(elgg_strip_tags($last_message->description));
    // Message text truncate max length 50
    $message_text = substr($message_text, 0, 50);
    // unread count messages
    $unread_count = ClipitChat::get_conversation_unread($user_id, $message->owner_id);
    ?>
    <li role="presentation" class="message-item">
        <a
            role="menuitem"
            tabindex="-1"
            href="<?php echo elgg_get_site_url(); ?>messages/view/<?php echo $user->login; ?>#reply_<?php echo $message->id; ?>">

            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'class' => 'user-avatar avatar-small'
            ));?>
            <div class="text-truncate" style=" font-size: 13px; text-transform: none; overflow: hidden; letter-spacing: 0;">
                <?php if($unread_count > 0): ?>
                    <span class="label label-primary pull-right">
                    <?php echo $unread_count; ?>
                    <?php echo elgg_echo("message:unread");?>
                </span>
                <?php endif; ?>
                <span><?php echo $user->name;?></span>
                <small class="show"><?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?></small>
                <div style="color: #333;" class="text-truncate">
                    <?php if($last_message->owner_id == $user_id): ?>
                        <small class="fa fa-mail-reply" style="font-size: 85% !important;color: #999;float: none !important;padding: 0;"></small>
                    <?php endif; ?>
                    <?php echo $message_text; ?>
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