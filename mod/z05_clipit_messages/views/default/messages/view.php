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
$messages = elgg_extract('entity', $vars);
$sender = elgg_extract('sender', $vars);

$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_logged = array_pop(ClipitUser::get_by_id(array($user_loggedin_id)));

foreach($messages as $message):
    $owner_user = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
    // Set read status from user logged in
    ClipitChat::set_read_status($message->id, true, array($user_loggedin_id));

?>
<a name="reply_<?php echo $message->id; ?>"></a>
<div class="message"
    <?php if($message->owner_id == $user_loggedin_id): ?>
        style="background: #fff;border-bottom: 1px solid #bae6f6;"
    <?php endif; ?>
>
    <div class="image-block">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($owner_user, 'small'),
            'class' => 'avatar-small'
        ));?>
    </div>
        <div class="content-block">
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$owner_user->login,
                    'title' => $owner_user->name,
                    'text'  => $owner_user->name,
                ));
                ?>
            </strong>
            <small class="show">
                <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
            </small>
                <?php if($message->name): ?>
                    <h3 class="subject">
                        <?php echo $message->name; ?>
                    </h3>
                <?php endif; ?>
            <div class="body">
                <?php echo $message->description; ?>
            </div>
        </div>
</div>

<?php endforeach ?>
<!-- Reply section -->
<div class="reply-section">
<!-- Reply form -->
<a name="create_reply"></a>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($user_logged, 'small'),
            'class' => 'user-avatar avatar-small'
        ));?>
    </div>
    <div class="block">
        <?php echo elgg_view_form("messages/reply/create", array('data-validate'=> "true" ), array('entity'  => $sender, 'category' => 'pm')); ?>
    </div>
</div>
<!-- Reply form end-->
</div>
<!-- Reply section end -->
