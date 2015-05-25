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
$comment = elgg_extract('entity', $vars);
$user = elgg_extract('user', $vars);
$target_id = elgg_extract('target_id', $vars);
$activity_id = elgg_extract('activity_id', $vars);
$owner_user = array_pop(ClipitUser::get_by_id(array($comment->owner_id)));
$files_id = $comment->get_files($comment->id);
$group = "";
if($activity_id && $owner_user->role == ClipitUser::ROLE_STUDENT){
    $group_id = ClipitGroup::get_from_user_activity($comment->owner_id, $activity_id);
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
}
?>
<a name="comment_<?php echo $comment->id; ?>"></a>
<div class="message <?php echo $vars['class'];?>">
    <div class="image-block">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($owner_user, 'small'),
            'class' => 'avatar-small'
        ));?>
    </div>
    <div class="content-block">
        <?php
        $owner_rating_entity = ClipitRating::get_user_rating_for_target($comment->owner_id, $target_id);
        if($owner_rating_entity){
            echo elgg_view("performance_items/rating_button", array('entity' => $owner_rating_entity, 'group_id' => $group->id));
        }
        ?>
        <strong>
            <?php echo elgg_view('page/elements/user_summary', array('user' => $owner_user)) ?>
        </strong>
        <small class="show">
            <?php if($group):?>
                <?php echo elgg_view("group/preview", array('entity' => $group, 'class' => 'text-truncate inline'));?>
            <?php endif;?>
            <?php echo elgg_view('output/friendlytime', array('time' => $comment->time_created));?>
        </small>
    </div>
    <div class="body">
        <?php echo text_reference($comment->description); ?>
        <!-- Attachs files -->
        <?php if($files_id): ?>
            <?php echo elgg_view("multimedia/attach/summary", array('files' => $files_id)); ?>
        <?php endif; ?>
        <!-- Attachs files end-->
    </div>
        <?php
        $replies = array_pop(ClipitComment::get_by_destination(array($comment->id)));
        if(!empty($replies)):
        ?>
        <div class="replies-block">
            <?php
            foreach($replies as $reply):
                echo elgg_view("comments/comment", array(
                    'entity' => $reply,
                    'class' => 'reply',
                    'target_id' => $target_id,
                    'activity_id' => $activity_id,
                    'reply' => true,
                ));
            endforeach; ?>
        </div>
        <?php endif; ?>
    <?php if(!$vars['reply']): ?>
    <div class="margin-top-10 text-right">
        <button id="<?php echo $comment->id; ?>" class="reply-to btn btn-default btn-sm reply-button" title="<?php echo elgg_echo('reply');?>">
            <i class="fa fa-reply"></i> <?php echo elgg_echo('reply');?>
        </button>
    </div>
    <!-- Reply form -->
    <div class="form-block message" id="form-<?php echo $comment->id; ?>">
        <div class="image-block">
            <?php echo elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'class' => 'avatar-small'
            ));?>
        </div>
        <div class="content-block">
            <small class="block">
                <i class="fa fa-reply"></i> <?php echo elgg_echo('comment:reply:to');?>:
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$owner_user->login,
                    'title' => $owner_user->name,
                    'text'  => $owner_user->name));
                ?>
                <a href="javascript:;" id="<?php echo $comment->id; ?>" class="close-reply-to" >&times;</a>
            </small>
            <?php echo elgg_view_form("comments/create",
                array('data-validate'=> "true", 'class'=>'fileupload'),
                array('entity'  => $comment, 'wysiwyg' => false)
            );
            ?>
        </div>
    </div>
    <!-- Reply form end-->
    <?php endif; ?>
</div>
