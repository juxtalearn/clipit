<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/09/2014
 * Last update:     25/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
// Load tinyMCE in textarea
$body = "<script>$(function(){clipit.tinymce();});</script>";

$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));

$body .='<div class="form-group">
    <label for="video-title">'.elgg_echo("resource:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'resource-title',
        'value' => $entity->name,
        'class' => 'form-control',
        'required' => true
    )).'
</div>
<div class="form-group">
    <label for="video-description">'.elgg_echo("resource:description").'</label>
    '.elgg_view("input/plaintext", array(
        'name'  => 'resource-description',
        'value' => $entity->description,
        'id'    => 'edit-'.$entity->id,
        'class' => 'form-control mceEditor',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "edit-resource-{$entity->id}",
        "title"     => elgg_echo("resource:edit"),
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