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
 * @package         Clipit
 */
$reply_msg = elgg_extract('entity', $vars);
$auto_id = elgg_extract('auto_id', $vars);
$user_reply = array_pop(ClipitUser::get_by_id(array($reply_msg->owner_id)));
$user_reply_elgg = new ElggUser($reply_msg->owner_id);
if($vars['activity']){
    $group_id = ClipitGroup::get_from_user_activity($user_reply->id, 74);
}
?>
<a name="reply_<?php echo $reply_msg->id; ?>"></a>
<div class="discussion discussion-reply-msg">
    <div class="header-post">
        <a class="show btn pull-right msg-quote" style="
    background: #fff;
    padding: 3px 7px;
    border-radius: 4px;
    border: 1px solid #bae6f6;
">#<?php echo $auto_id;?></a>
        <?php echo $owner_reply_options; ?>
        <div class="user-reply">
            <img class="user-avatar" src="<?php echo $user_reply_elgg->getIconURL('small'); ?>" />
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
                <?php if($vars['show_group'] && $group = array_pop(ClipitGroup::get_by_id(array($group_id)))):?>
                    <span class="label label-primary" style="display: inline-block;background: #32b4e5;color: #fff;">
                        <?php echo $group->name?>
                    </span>
                <?php endif; ?>

                <?php echo elgg_view('output/friendlytime', array('time' => $reply_msg->time_created));?>
            </small>
        </div>
    </div>
    <div class="body-post"><?php echo text_reference($reply_msg->description); ?></div>
</div>