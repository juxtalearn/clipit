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
$activity_id = elgg_get_page_owner_guid();
?>
<div style="margin-bottom: 15px;">
    <?php echo elgg_view_form('discussion/create', array('data-validate'=> 'true' ,'class'=> 'fileupload'), array('entity'  => $entity)); ?>
    <button type="button" data-toggle="modal" data-target="#create-new-topic" class="btn btn-default">Create a new topic</button>
</div>
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
    if($message->owner_id == elgg_get_logged_in_user_guid()){
        $options = array(
            'entity' => $message,
            'edit' => array(
                "data-target" => "#edit-discussion-{$message->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/discussion/edit?id={$message->id}",
                "data-toggle" => "modal"
             ),
            'remove' => array("href" => "action/discussion/remove?id={$message->id}"),
        );

        $owner_options = elgg_view("page/components/options_list", $options);
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$message->id}" ));
    }
?>
<div class="row row-table messages-discussion">
    <div class="col-md-9">
        <?php echo $owner_options; ?>
        <h4>
            <?php echo elgg_view('output/url', array(
                'href' => "{$href}/view/{$message->id}",
                'title' => $message->name,
                'text' => $message->name,
                'is_trusted' => true, ));
            ?>
        </h4>
        <p>
            <?php echo $message_text; ?>
        </p>
        <small class="show">
            <i>
                Created by
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$owner->login,
                    'title' => $owner->name,
                    'text'  => $owner->name));
                ?>
                <?php echo elgg_view('output/friendlytime', array('time' => $message->time_created));?>
            </i>
            <?php
            if($total_replies > 0):
                $last_post = end(array_pop(ClipitPost::get_by_destination(array($message->id))));
                $author_last_post = array_pop(ClipitUser::get_by_id(array($last_post->owner_id)));
            ?>
            <i class="pull-right">
                Last post by
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$author_last_post->login,
                    'title' => $author_last_post->name,
                    'text'  => $author_last_post->name,
                ));
                ?> (<?php echo elgg_view('output/friendlytime', array('time' => $last_post->time_created));?>)</i>
            <?php endif; ?>
        </small>
    </div>
    <div class="col-md-3 text-center">
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