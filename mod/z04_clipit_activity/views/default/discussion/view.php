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
$message = elgg_extract("entity", $vars);
$reply = elgg_extract('reply', $vars);
$href_multimedia = elgg_extract('href_multimedia', $vars);
$owner = array_pop(ClipitUser::get_by_id(array($message->owner_id)));
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_logged = array_pop(ClipitUser::get_by_id(array($user_loggedin_id)));
$total_replies = array_pop(ClipitPost::count_by_destination(array($message->id)));
// Attach multimedia items
$videos = ClipitPost::get_videos($message->id);
$files = ClipitPost::get_files($message->id);
$multimedia = array_merge($videos, $files);

$user_read_status = array_pop(ClipitPost::get_read_status($message->id, array($user_loggedin_id)));
// set read status
if($message->owner_id != $user_loggedin_id && !$user_read_status){
    ClipitPost::set_read_status($message->id, true, array($user_loggedin_id));
}
// Owner options (edit/delete)
$owner_options = "";
if($message->owner_id == $user_loggedin_id || $user_logged->role == ClipitUser::ROLE_TEACHER){
    $options = array(
        'entity' => $message,
        'edit' => array(
            "data-target" => "#edit-discussion-{$message->id}",
            "href" => elgg_get_site_url()."ajax/view/modal/discussion/edit?id={$message->id}",
            "data-toggle" => "modal"
        ),
    );
    if($message->owner_id == $user_loggedin_id){
        $options['remove'] = array("href" => "action/discussion/remove?id={$message->id}");
    }
    $owner_options = elgg_view("page/components/options_list", $options);
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "edit-discussion-{$message->id}" ));
}
?>
<div class="discussion discussion-owner-msg">
    <div class="header-post">
        <?php echo $owner_options; ?>
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($owner, 'small'),
            'class' => 'user-avatar avatar-small'
        ));?>
        <div class="block">
            <h3 class="title"><?php echo $message->name; ?></h3>
            <small class="show">
                <i>
                    <?php echo elgg_echo('discussion:created_by');?>
                    <?php echo elgg_view('page/elements/user_summary', array('user' => $owner)); ?>
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
    </div>
    <div class="body-post">
        <?php echo $message->description; ?>
        <!-- Attachs multimedia -->
        <?php if(count($multimedia) > 0): ?>
            <?php echo elgg_view("multimedia/attach/full", array(
                'entities' => $multimedia,
                'href_multimedia' => $href_multimedia,
                'group' => $vars['group']
            )); ?>
        <?php endif; ?>
        <!-- Attachs multimedia end -->
    </div>
</div>
<a name="replies"></a>
<?php
$auto_id = 1;
$replies = array_pop(ClipitPost::get_by_destination(array($message->id), 0, 0, false, 'time_created', true));
foreach($replies as $reply_msg){
    echo elgg_view("discussion/reply",
            array(
                'user_id' => $user_loggedin_id,
                'entity' => $reply_msg,
                'auto_id' => $auto_id,
                'activity_id' => $vars['activity_id'],
                'show_group' => $vars['show_group']
            ));
    $auto_id++;
}
?>
<?php if($reply !== false): ?>
<!-- Reply form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("reply:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($user_logged, 'small'),
            'class' => 'user-avatar avatar-small'
        ));?>
    </div>
    <div class="block">
        <?php echo elgg_view_form("discussion/reply/create", array('data-validate'=> "true", 'class'=>'fileupload' ), array('entity'  => $message)); ?>
    </div>
</div>
<!-- Reply form end-->
<?php endif;?>