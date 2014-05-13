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
$owner = new ElggUser($message->owner_id);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$total_replies = array_pop(ClipitPost::count_by_destination(array($message->id)));
$files_id = $message->get_files($message->id);

// set read status
if($message->owner_id != $user_loggedin_id){
    ClipitPost::set_read_status($message->id, true, array($user_loggedin_id));
}
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
    </div>
    <div class="body-post">
        <?php echo $message->description; ?>
        <!-- Attachs files -->
        <?php if($files_id): ?>
            <?php echo elgg_view("multimedia/file/attach_files", array('files' => $files_id)); ?>
        <?php endif; ?>
        <!-- Attachs files end-->
    </div>
</div>

<script>
$(function(){
    $("#wrap").on("click", ".quote-ref", function(){
        var quote_id = $(this).data("quote-ref");
        var parent = $(this).closest("div");
        var $obj = $(this);
        var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");

        if(quote_content.length == 0){
            $(this).addClass("active");
            $(this).after("<div class='quote-content' data-quote-id='"+quote_id+"'></div>");
            var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");
            quote_content.html("<a class='loading'><i class='fa fa-spinner fa-spin'></i> loading...</a>");
            $.ajax({
                url: elgg.config.wwwroot+"ajax/view/discussion/quote",
                type: "POST",
                data: { quote_id : quote_id, message_destination_id : <?php echo $message->id; ?>},
                success: function(html){
                    quote_content.html(html);
                    console.log(html);
                }
            });
        } else {
            parent.find(".quote-content[data-quote-id="+quote_id+"]").toggle(1,function(){
                $obj.toggleClass("active");
            });
        }
    });

});
</script>
<a name="replies"></a>
<?php
$auto_id = 1;
foreach(array_pop(ClipitPost::get_by_destination(array($message->id))) as $reply_msg){
    echo elgg_view("discussion/reply",
            array(
                'entity' => $reply_msg,
                'auto_id' => $auto_id,
                'activity' => $vars['activity'],
                'show_group' => $vars['show_group']
            ));
    $auto_id++;
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
        <?php echo elgg_view_form("discussion/reply/create", array('data-validate'=> "true", 'class'=>'fileupload' ), array('entity'  => $message)); ?>
    </div>
</div>
<!-- Reply form end-->
