<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/03/14
 * Last update:     10/03/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
$user_to =  elgg_extract('entity', $vars);
$input_id = "compose";
$textarea_id = "";
$remote = false;
if($user_to){
    $send_msg_js = elgg_view("messages/search_to", array('user_id' => $user_to->id));
    $input_id = "compose-to-".$user_to->id;
    $textarea_id = "send-".$user_to->id;
    $body = "<script>$('#send-".$user_to->id."').wysihtml5(); $('input#compose-to-".$user_to->id."').send_msg(".$send_msg_js.");</script>";
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
    <label for="discussion-title">'.elgg_echo("messages:subject").' <small>(Optional)</small></label>
    '.elgg_view("input/text", array(
        'name' => 'message-subject',
        'class' => 'form-control'
    )).'
</div>
<div class="form-group">
    <label for="discussion-text">'.elgg_echo("message").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'message-text',
        'class' => 'form-control wysihtml5',
        'id'    => $textarea_id,
        'required' => true,
        'rows'  => 6,
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