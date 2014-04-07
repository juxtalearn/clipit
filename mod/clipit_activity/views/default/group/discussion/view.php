<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 5/03/14
 * Time: 11:36
 */
$message = elgg_extract("entity", $vars);
$owner = new ElggUser($message->owner_id);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$total_replies = ClipitPost::get_count_by_destination(array($message->id));

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
        'remove' => array("href" => "action/group/discussion/remove?id={$message->id}"),
    );

    $owner_options = elgg_view("page/components/options_list", $options);
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$message->id}" ));
}
?>
<div class="discussion discussion-owner-msg">
    <div class="header-post">
        <?php echo $owner_options; ?>
        <img class="user-avatar" src="<?php echo $owner->getIconURL('small'); ?>" />
        <div class="block">
            <h2 class="title"><?php echo $message->name; ?></h2>
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
                    $last_post_id = end(ClipitMessage::get_replies($message->id));
                    $last_post = array_pop(ClipitMessage::get_by_id(array($last_post_id)));
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
    </div>
    <div class="body-post"><?php echo $message->description; ?></div>
</div>

<a name="replies"></a>
<?php
foreach(array_pop(ClipitPost::get_by_parent(array($message->id))) as $reply_msg){
    if(!empty($reply_msg)){
        $second_level = array_pop(ClipitPost::get_by_parent(array($reply_msg->id)));
        echo elgg_view("group/discussion/reply", array('entity' => $reply_msg, 'second_level' => $second_level));
    }
}
?>

<!-- Reply form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("reply:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("group/discussion/reply/create", array('data-validate'=> "true" ), array('entity'  => $message)); ?>
    </div>
</div>
<!-- Reply form end-->