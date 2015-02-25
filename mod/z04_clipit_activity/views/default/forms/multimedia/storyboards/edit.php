<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/05/14
 * Last update:     7/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$file = elgg_extract('file', $vars);

// Load tinyMCE in textarea
$body = "<script>$(function(){tinymce_setup();});</script>";

$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
$body .= elgg_view('multimedia/file/view_summary', array('file' => $file));
$body .='
<div class="form-group">
    <label for="sb-description">'.elgg_echo("description").'</label>
    '.elgg_view("input/plaintext", array(
        'name'  => 'sb-description',
        'value' => $entity->description,
        'id'    => 'edit-'.$entity->id,
        'class' => 'form-control mceEditor',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-md",
        "remote"    => true,
        "target"    => "edit-storyboard-{$entity->id}",
        "title"     => elgg_echo("storyboard:edit"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('save'),
                'class' => "btn btn-primary"
            ))
    ));