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
$message = elgg_extract('entity', $vars);

// Load wysihtml5 in textarea
$body = "<script>$('#edit-".$message->id."').wysihtml5();</script>";

$body .= elgg_view("input/hidden", array(
    'name' => 'message-id',
    'value' => $message->id,
));

$body .='
<div class="form-group">
    <label for="discussion-text">'.elgg_echo("discussion:text_topic").'</label>
    '.elgg_view("input/plaintext", array(
        'name'  => 'discussion-text',
        'value' => $message->description,
        'id'    => 'edit-'.$message->id,
        'class' => 'form-control wysihtml5',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "edit-discussion-{$message->id}",
        "title"     => elgg_echo("reply:edit"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('save'),
                'class' => "btn btn-primary"
            ))
    ));
?>