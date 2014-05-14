<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);

// Load tinyMCE in textarea
$body = "<script>$(function(){tinymce_setup();});</script>";

$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));

$body .='<div class="form-group">
    <label for="video-title">'.elgg_echo("video:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'video-title',
        'value' => $entity->name,
        'class' => 'form-control',
        'required' => true
    )).'
</div>
<div class="form-group">
    <label for="video-description">'.elgg_echo("video:description").'</label>
    '.elgg_view("input/plaintext", array(
        'name'  => 'video-description',
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
        "target"    => "edit-video-{$entity->id}",
        "title"     => elgg_echo("discussion:edit"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('update'),
                'class' => "btn btn-primary"
            ))
    ));
?>