<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$message = elgg_extract('message', $vars);
$user_id = elgg_get_logged_in_user_guid();
$user_from = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
$total_messages = ClipitChat::get_conversation_count($user_id, $message->owner_id);
?>
<?php
if($total_messages > 0):
    // Get last post data
    $last_post = ClipitChat::get_conversation($message->owner_id, $user_id);
    $last_post = end($last_post);
    $author_last_post = array_pop(ClipitUser::get_by_id(array($last_post->owner_id)));
    ?>
    <a href="<?php echo elgg_get_site_url()."messages/view/{$user_from->login}#reply_".$last_post->id; ?>">
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