<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 11:01
 * To change this template use File | Settings | File Templates.
 */
$entity = elgg_extract("entity", $vars);
$messages = elgg_extract("messages", $vars);
$href = elgg_extract("href", $vars);
$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$activity_id = elgg_get_page_owner_guid();
?>
<?php if($vars['create']): ?>
    <div style="margin-bottom: 15px;">
        <?php echo elgg_view_form('discussion/create',
            array('data-validate'=> 'true' ,'class'=> 'fileupload'),
            array('entity'  => $entity, 'attach_multimedia' => $vars['attach_multimedia'])
        ); ?>
        <button type="button" data-toggle="modal" data-target="#create-new-topic" class="btn btn-default">
            <?php echo elgg_echo('discussion:create'); ?>
        </button>
    </div>
<?php endif; ?>
<?php
foreach($messages as $message):
    $message_text = trim(elgg_strip_tags($message->description));
    // Message text truncate max length 280
    if(mb_strlen($message_text)>280){
        $message_text = substr($message_text, 0, 280)."...";
    }
    $total_replies = array_pop(ClipitPost::count_by_destination(array($message->id)));
    $total_unread_replies = array_pop(ClipitPost::unread_by_destination(array($message->id), $user_id, true));
    if($total_unread_replies > 0){
        $total_replies = "+".$total_unread_replies;
    }
    // Get owner user object
    $owner = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
    // Owner options (edit/delete)
    $owner_options = "";
    if($message->owner_id == elgg_get_logged_in_user_guid() || hasTeacherAccess($user->role)){
        $options = array(
            'entity' => $message,
            'edit' => array(
                "data-target" => "#edit-discussion-{$message->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/discussion/edit?id={$message->id}",
                "data-toggle" => "modal"
            ),
        );
        if($message->owner_id == elgg_get_logged_in_user_guid()){
            $options['remove'] = array("href" => "action/discussion/remove?id={$message->id}");
        }
        $owner_options = elgg_view("page/components/options_list", $options);
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$message->id}" ));
    }
    // Attach multimedia items
    $videos = ClipitPost::get_videos($message->id);
    $files = ClipitPost::get_files($message->id);
    $multimedia = array_merge($videos, $files);
    ?>
    <div class="row row-flex messages-discussion">
        <div class="col-md-9 col-xs-9">
            <?php echo $owner_options; ?>
            <h4>
                <?php echo elgg_view('output/url', array(
                    'href' => "{$href}/view/{$message->id}",
                    'title' => $message->name,
                    'text' => $message->name,
                    'is_trusted' => true, ));
                ?>
            </h4>
            <div class="overflow-hidden">
                <?php if(count($multimedia) > 0): ?>
                    <?php if(count($multimedia) > 1):?>
                        <div class="attach-count pull-left text-center">
                            <h4>
                                <i class="fa fa-paperclip"></i>
                                <sub> x<span class="blue"><?php echo count($multimedia);?></span></sub>
                            </h4>
                        </div>
                    <?php else: ?>
                        <div style="margin: 5px 5px 5px 0;" class="pull-left">
                            <?php echo elgg_view('multimedia/preview', array('entity_id' => array_pop($multimedia)));?>
                        </div>
                    <?php endif;?>
                <?php endif; ?>
                <div class="content-block">
                    <p>
                        <?php echo $message_text; ?>
                    </p>
                </div>
            </div>
            <small class="show">
                <i>
                    <?php echo elgg_echo('discussion:created_by');?>
                    <?php echo elgg_view('page/elements/user_summary', array('user' => $owner)) ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
                </i>
                <?php
                if($total_replies > 0):
                    $last_post = end(array_pop(ClipitPost::get_by_destination(array($message->id))));
                    $author_last_post = array_pop(ClipitUser::get_by_id(array($last_post->owner_id)));
                    ?>
                    <i class="pull-right">
                        <?php echo elgg_echo('discussion:last_post_by');?>
                        <?php echo elgg_view('page/elements/user_summary', array('user' => $author_last_post)); ?>
                        (<?php echo elgg_view('output/friendlytime', array('time' => $last_post->time_created));?>)
                    </i>
                <?php endif; ?>
            </small>
        </div>
        <div class="col-md-3 col-xs-3 text-center">
            <?php echo elgg_view('output/url', array(
                'href'  => "{$href}/view/{$message->id}#replies",
                'title' => elgg_echo("reply:total", array($total_replies)),
                'text'  => '<i class="fa fa-comment fa-stack-2x"></i>
                        <i class="fa-stack-1x replies-count">'.$total_replies.'</i>',
                'class' => "fa-stack replies"
            ));
            ?>

            <?php echo elgg_view('output/url', array(
                'href'  => "{$href}/view/{$message->id}#create_reply",
                'title' => elgg_echo("reply:create"),
                'text'  => '<i class="fa fa-plus"></i> '.elgg_echo("reply"),
                'class' => "btn btn-default btn-sm reply-button"
            ));
            ?>
        </div>
    </div>
<?php endforeach; ?>