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
$message = elgg_extract('entity', $vars);
$user_id = elgg_extract('user_id', $vars);
$auto_id = elgg_extract('auto_id', $vars);
$activity_id = elgg_extract('activity_id', $vars);
$user_reply = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
$files_id = $message->get_files($message->id);
// activity discussion, get group data
$group = "";
if($activity_id && $user_reply->role == ClipitUser::ROLE_STUDENT){
    $group_id = ClipitGroup::get_from_user_activity($user_reply->owner_id, $activity_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
}
// set read status
if($message->owner_id != $user_id){
    ClipitPost::set_read_status($message->id, true, array($user_id));
}
?>
<a name="reply_<?php echo $message->id; ?>"></a>
<div class="discussion discussion-reply-msg"  data-message-destination="<?php echo ClipitPost::get_destination($message->id);?>">
    <div class="header-post">
        <a class="show btn pull-right msg-quote" style="
    background: #fff;
    padding: 2px 5px;
    border-radius: 4px;
    border: 1px solid #bae6f6;
">#<?php echo $auto_id;?></a>
        <div class="user-reply">
            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user_reply, 'small'),
                'class' => 'user-avatar avatar-small'
            ));?>
        </div>
        <div class="block">
            <strong>
                <?php echo elgg_view('page/elements/user_summary', array('user' => $user_reply)); ?>
            </strong>
            <small class="show">
                <?php if($vars['show_group'] && $group):?>
                    <?php echo elgg_view("group/preview", array('entity' => $group, 'class' => 'text-truncate inline'));?>
                <?php endif; ?>

                <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
            </small>
        </div>
    </div>
    <div class="body-post">
        <?php echo text_reference($message->description, $auto_id); ?>
        <!-- Attachs files -->
        <?php if($files_id): ?>
            <?php echo elgg_view("multimedia/attach/summary", array('files' => $files_id)); ?>
        <?php endif; ?>
        <!-- Attachs files end-->
    </div>
</div>