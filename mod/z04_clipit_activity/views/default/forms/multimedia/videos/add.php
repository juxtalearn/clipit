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
$entity = elgg_extract('entity', $vars);

$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
$body .= '<div class="row">';
$body .= '<div class="col-md-12 add-video">';
$body .= '
<div class="pull-left video-prev">
    <i class="fa fa-play"></i>
    <a target="_blank">
        <img id="video-prev" src="">
    </a>
</div>';
$body .='<div class="video-info">';
$body .= '<div class="form-group">
    <label for="video-url">'.elgg_echo("video:url").'</label>
    <div class="icon">
      <span>
        <a class="loading" style="display:none;"><i style="width:16px;height:16px;" class="fa fa-spinner fa-spin"></i></a>
        <img id="link-favicon" src="http://www.google.com/s2/favicons?domain=">
      </span>
     '.elgg_view("input/text", array(
        'name' => 'video-url',
        'id' => 'video-url',
        'style' => 'padding-left: 25px;',
        'class' => 'form-control blue',
        'required' => true
    )).'
    </div>
    <div class="error">
        <small><strong>'.elgg_echo("video:url:error").'</strong></small>
    </div>
</div>';
// Input group set hidden by default
$body .= '<div id="group-hide" style="display: none">';

$body .= '<div class="form-group">
    <label for="video-title">'.elgg_echo("video:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'video-title',
        'id' => 'video-title',
        'class' => 'form-control',
        'required' => true
    )).'
</div>';
$body .= '<div class="form-group">
    <label for="video-description">'.elgg_echo("video:description").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'video-description',
        'class' => 'form-control mceEditor',
        'id' => 'video-description',
        'rows'  => 3,
        'placeholder' => 'Set description...',
        'style' => "width: 100%;"
    )).'
</div>';

$body .='</div>';
$body .='</div>'; // .col-md-12
$body .='</div>'; // .row

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "target"    => "add-video",
        "title"     => elgg_echo("video:add"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('add'),
                'class' => "btn btn-primary"
            ))
    ));
