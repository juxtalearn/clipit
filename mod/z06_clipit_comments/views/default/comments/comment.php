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
$target_id = elgg_extract('target_id', $vars);
$user = array_pop(ClipitUser::get_by_id(array($comment->owner_id)));
$user_elgg = new ElggUser($comment->owner_id);
$user_loggedin_elgg = new ElggUser(elgg_get_logged_in_user_guid());
$files_id = $comment->get_files($comment->id);
$activity_id = elgg_get_page_owner_guid();
$group_id = ClipitGroup::get_from_user_activity($comment->owner_id, $activity_id);
$group = array_pop(ClipitGroup::get_by_id(array($group_id)));
?>
<a name="comment_<?php echo $comment->id; ?>"></a>
<div class="message <?php echo $vars['class'];?>">
    <div class="image-block">
        <img src="<?php echo $user_elgg->getIconURL('small'); ?>"/>
    </div>
    <div class="content-block">
        <?php
        $owner_rating_entity = ClipitRating::get_from_user_for_target($comment->owner_id, $target_id);
        if($owner_rating_entity){
            echo elgg_view("publications/stars_summary", array('entity' => $owner_rating_entity));
        }
        ?>
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$user->login,
                'title' => $user->name,
                'text'  => $user->name));
            ?>
        </strong>
        <small class="show">
            <span class="label label-primary text-truncate" style="background: #32b4e5;color: #fff;max-width: 80px;display: inline-block;        vertical-align: middle;"><?php echo $group->name;?></span>
            <?php echo elgg_view('output/friendlytime', array('time' => $comment->time_created));?>
        </small>
        <div class="body">
            <?php echo text_reference($comment->description); ?>
            <!-- Attachs files -->
            <?php if($files_id): ?>
                <?php echo elgg_view("multimedia/file/attach_files", array('files' => $files_id)); ?>
            <?php endif; ?>
            <!-- Attachs files end-->
        </div>
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
                    'reply' => true
                ));
            endforeach; ?>
        </div>
        <?php endif; ?>
    <?php if(!$vars['reply']): ?>
    <div style="margin-top: 10px;text-align: right">
        <button id="<?php echo $comment->id; ?>" class="reply-to btn btn-default btn-sm reply-button">
            <i class="fa fa-reply"></i> Reply
        </button>
    </div>
    <!-- Reply form -->
    <div class="form-block message" id="form-<?php echo $comment->id; ?>">
        <div class="image-block">
            <img src="<?php echo $user_loggedin_elgg->getIconURL('small'); ?>"/>
        </div>
        <div class="content-block">
            <small class="block">
                <i class="fa fa-reply"></i> Reply to:
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$user->login,
                    'title' => $user->name,
                    'text'  => $user->name));
                ?>
                <a href="javascript:;" id="<?php echo $comment->id; ?>" class="close-reply-to" >&times;</a>
            </small>
            <?php echo elgg_view_form("comments/create", array('data-validate'=> "true", 'class'=>'fileupload'), array('entity'  => $comment)); ?>
        </div>
    </div>
    <!-- Reply form end-->
    <?php endif; ?>
</div>