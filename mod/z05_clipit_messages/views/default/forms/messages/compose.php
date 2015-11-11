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
$user_to =  elgg_extract('entity', $vars);
$input_id = "compose";
$textarea_id = "";
$remote = false;
$user_id = elgg_get_logged_in_user_guid();
if($user_to){
    $send_msg_js = elgg_view("messages/search_to", array('user_id' => $user_to->id));
    $input_id = "compose-to-".$user_to->id;
    $textarea_id = "send-".$user_to->id;
    $body = "<script>clipit.tinymce(); $('input#compose-to-".$user_to->id."').send_msg(".$send_msg_js.");</script>";
    $body .= elgg_view("input/hidden", array(
        'name' => 'user-id',
        'value' => $user_to->id,
    ));
    $remote = true;
}
$body .='
<div class="form-group">
    <label for="'.$input_id.'">'.elgg_echo("message:to").'</label>
    <div>
    '.elgg_view("input/text", array(
        'name' => 'message-to',
        'class' => 'form-control hidden-validate',
        'required' => true,
        'id'    => $input_id
    )).'
    </div>
</div>';
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
if($user->role == ClipitUser::ROLE_TEACHER) {
    $activities = array('' => elgg_echo('activity:select'));
    foreach(ClipitActivity::get_from_user($user_id) as $activity){
        $activities[$activity->id] = $activity->name;
    }
    $body .= '
        <div class="form-group">
            <strong>
            '.elgg_view('output/url', array(
                'href'  => "javascript:;",
                'text'  => elgg_echo("message:to_students"),
                'onclick'   => '$(this).closest(\'.form-group\').find(\'.select-activities\').toggle()'
            )).'
            </strong>
            <div class="select-activities" class="margin-top-10" style="display: none;">
            ' . elgg_view("input/dropdown", array(
                    'name' => 'activity',
                    'aria-label' => 'activity',
                    'class' => 'form-control',
                    'style' => 'padding-top: 5px;padding-bottom: 5px;',
                    'options_values' => $activities
                )). '
            </div>
        </div>';
}
$body .= '
<div class="form-group">
    <label for="message-text">'.elgg_echo("message").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'message-text',
        'class' => 'form-control mceEditor',
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