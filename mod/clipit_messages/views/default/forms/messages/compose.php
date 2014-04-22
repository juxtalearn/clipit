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
$user_to =  elgg_extract('entity', $vars);
$input_id = "compose";
$textarea_id = "";
$remote = false;
if($user_to){
    $send_msg_js = elgg_view("messages/search_to", array('user_id' => $user_to->id));
    $input_id = "compose-to-".$user_to->id;
    $textarea_id = "send-".$user_to->id;
    $body = "<script>tinymce_setup(); $('input#compose-to-".$user_to->id."').send_msg(".$send_msg_js.");</script>";
    $body .= elgg_view("input/hidden", array(
        'name' => 'user-id',
        'value' => $user_to->id,
    ));
    $remote = true;
}
$body .='<div class="form-group">
    <label for="discussion-title">'.elgg_echo("message:to").'</label>
    <div>
    '.elgg_view("input/text", array(
        'name' => 'message-to',
        'class' => 'form-control',
        'required' => true,
        'id'    => $input_id
    )).'
    </div>
</div>
<div class="form-group">
    <label for="discussion-text">'.elgg_echo("message").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'message-text',
        'class' => 'form-control wysihtml5',
        'id'    => $textarea_id,
        'required' => true,
        'rows'  => 5,
    )).'
</div>';
echo elgg_view("page/components/modal",
    array(
        "target"    => "compose-msg",
        "remote"    => $remote,
        "title"     => elgg_echo("messages:compose"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('send'),
                'class' => "btn btn-primary"
            ))
    ));